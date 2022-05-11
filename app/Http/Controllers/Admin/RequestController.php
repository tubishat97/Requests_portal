<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    public function requestIndex(Request $request, $type)
    {
        if ($type && !in_array($type, claimsStatusesArray())) {
            abort(404);
        }

        $condition = getClaimStatusCondition($type);

        $user = session()->get('user');
        $response = $this->getRequestsWhereStatus($user, $condition);

        if (!empty($response->name)) {
            if ($response->name === "Invalid Session ID" || $response->name == 'Access Denied') {
                forgetAuthSessions($request);
                return redirect(route('admin.login_form'));
            }
        }

        $requests = $response->entry_list;

        return view('admin.requests.list', compact('requests', 'type'));
    }

    public function addDeathRequest(Request $request)
    {
        $langs  = $this->lang;
        $loanTypes = [
            'housing_loan' => trans('admin-content.housing-loan'),
            'personal_loan' => trans('admin-content.personal_loan'),
            'motor_loan' => trans('admin-content.motor-loan'),
            'credit_card' => trans('admin-content.credit-card'),
        ];

        return view('admin.requests.add', compact('langs', 'loanTypes'));
    }

    public function storeDeathRequest(Request $request)
    {
        $validations = [
            'fullname' => 'required',
            'national' => 'required|min:10',
            'date_of_occurrence' => 'required|date',
            'reason' => 'required',
            'loans.type.*' => 'required',
            'loans.amount.*' => 'required'
        ];

        $request->validate($validations);

        try {
            $user = session()->get('user');
            $this->storeWhereType($user, $request, 'death');

            return redirect()->route('admin.request', 'open')->with('success', __('system-messages.add'));
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    public function addInabilityRequest(Request $request)
    {
        $langs  = $this->lang;
        $loanTypes = [
            'housing_loan' => trans('admin-content.housing-loan'),
            'personal_loan' => trans('admin-content.personal_loan'),
            'motor_loan' => trans('admin-content.motor-loan'),
            'credit_card' => trans('admin-content.credit-card'),
        ];

        return view('admin.requests.inability-add', compact('langs', 'loanTypes'));
    }

    public function storeInabilityRequest(Request $request)
    {
        $validations = [
            'fullname' => 'required',
            'national' => 'required|min:10',
            'date_of_occurrence' => 'required|date',
            'reason' => 'required',
            'loans.*' => 'required',
        ];

        $request->validate($validations);

        try {
            $user = session()->get('user');
            $this->storeWhereType($user, $request, 'inability');
            return redirect()->route('admin.request', 'open')->with('success', __('system-messages.add'));
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    public function getRequestsWhereStatus($user, $condition)
    {
        $params = array(
            //session id
            'session' => $user->session_id,
            //The name of the module from which to retrieve records
            'module_name' => 'STS_Claiming_Loans',
            //The SQL WHERE clause without the word "where".
            'query' => "sts_claiming_loans.created_by = '$user->crm_user_id' AND $condition",
            //The SQL ORDER BY clause without the phrase "order by".
            'order_by' => "date_entered DESC",
            //The record offset from which to start.
            'offset' => '0',
            //Optional. A list of fields to include in the results.
            'select_fields' => array(
                'id',
                'name',
                'status',
                'national_id',
                'date_of_occurrence',
                'reason',
                'type',
                'assigned_user_id',
            ),
            'link_name_to_fields_array' => array(),
            //The maximum number of results to return.
            'max_results' => '',
            //To exclude deleted records
            'deleted' => 0,
            //If only records marked as favorites should be returned.
            'Favorites' => false,
        );

        return crmCall($params, 'get_entry_list');
    }

    public function storeWhereType($user, $request, $type)
    {
        $user = session()->get('user');

        $docs = getUploadedDocs($request);

        $params = array(
            //session id
            "session" => $user->session_id,
            //The name of the module from which to retrieve records.
            "module_name" => "STS_Claiming_Loans",
            //Record attributes
            "name_value_list" => array(
                array("name" => "name", "value" => $request->fullname),
                array("name" => "national_id", "value" => $request->national),
                array("name" => "date_of_occurrence", "value" => $request->date_of_occurrence),
                array("name" => "reason", "value" => $request->reason),
                array("name" => "type", "value" => $type),
                array("name" => "status", "value" => "initiated"),
            ),
        );

        $response = crmCall($params, 'set_entry');

        if (!empty($response->name)) {
            if ($response->name === "Invalid Session ID" || $response->name == 'Access Denied') {
                forgetAuthSessions($request);
                return redirect(route('admin.login_form'));
            }
        }

        foreach ($request->loans as $loan) {
            $loan_items_param = array(
                //session id
                "session" => $user->session_id,
                //The name of the module
                "module_name" => "STS_Claiming_Loans_Items",
                //Record attributes
                "name_value_list" => array(
                    array("name" => "type", "value" => $loan["type"]),
                    array("name" => "amount", "value" => $loan["amount"]),
                    array("name" => "sts_claimie1dbg_loans_ida", "value" => $response->id),
                ),
            );

            crmCall($loan_items_param, 'set_entry');
        }

        foreach ($docs as $doc) {
            $file = $doc['file'];
            $fileName = $file->getClientOriginalName();
            $fileTmp = $file->getPathName();
            $file_split = (explode('.', $fileName));

            $doc_param = array(
                //session id
                "session" => $user->session_id,
                //The name of the module
                "module_name" => "STS_Claiming_Loans_Documents",
                //Record attributes
                "name_value_list" => array(
                    array("name" => "document_name", "value" => $file_split[0]),
                    array("name" => "file_ext", "value" => $file->getClientOriginalExtension()),
                    array("name" => "file_mime_type", "value" => $file->getClientMimeType()),
                    array("name" => "doc_key_c", "value" => $doc['key']),
                    array("name" => "description", "value" => $doc['description']),
                    array("name" => "uploadfile", "value" => $fileName),
                    array("name" => "sts_claimi9ee4g_loans_ida", "value" => $response->id),
                    array("name" => "assigned_user_id", "value" => $user->crm_user_id),
                    array("name" => "revision", "value" => "1"),
                ),
            );

            $document  = crmCall($doc_param, 'set_entry');
            $attachment_id = $document->id;

            move_uploaded_file($fileTmp, "../../JI_new/upload/" . $attachment_id);
            $contents = file_get_contents('../../JI_new/upload/' . $attachment_id);

            $set_document_revision_parameters = array(
                //session id
                "session" => $user->session_id,
                //The attachment details
                "note" => array(
                    //The ID of the parent document.
                    'id' => $attachment_id,

                    //The binary contents of the file.
                    'file' => base64_encode($contents),

                    //The name of the file
                    'filename' => $fileName,

                    //The revision number
                    'revision' => '1',
                ),
            );

            crmCall($set_document_revision_parameters, 'set_document_revision');
        }
    }

    public function showNotes($request)
    {
        $user = session()->get('user');

        $params = array(
            //session id
            'session' => $user->session_id,
            //The name of the module from which to retrieve records
            'module_name' => 'STS_Claiming_Loans',
            //The id of the record to fetch
            'id' => $request,
            //Optional. The list of fields to be returned in the results
            'select_fields' => array(
                'id',
                'type',
                'status',
                'claim_name_c',
                'claim_number_c',
                'reject_reason_c',
            ),

            //A list of link names and the fields to be returned for each link name
            'link_name_to_fields_array' => array(
                array(
                    'name' => 'sts_claiming_loans_sts_claiming_loans_notes_1',
                    'value' => array(
                        'id',
                        'description',
                        'date_entered',
                        'created_by',
                        'note',
                    ),
                ),
                array(
                    'name' => 'sts_claiming_loans_sts_claiming_loans_documents',
                    'value' => array(
                        'id',
                        'document_name',
                        'uploadfile',
                        'created_by_name',
                        'created_by',
                        'date_entered',
                        'description',
                    ),
                ),
            ),
        );

        $response  = crmCall($params, 'get_entry');

        if (!empty($response->name)) {
            if ($response->name === "Invalid Session ID" || $response->name == 'Access Denied') {
                forgetAuthSessions($request);
                return redirect(route('admin.login_form'));
            }
        }

        $notes = [];

        if ($response->relationship_list && is_array($response->relationship_list)) {
            foreach ($response->relationship_list as $relationships) {
                foreach ($relationships as $relationship) {
                    if ($relationship->name == 'sts_claiming_loans_sts_claiming_loans_notes_1') {
                        $notes = $relationship->records;
                    }
                }
            }
        }

        $requestObj = $response->entry_list;
        $requestObj = $requestObj[0]->name_value_list;

        array_sort_by_column($notes);

        return view('admin.notes.show', compact('notes', 'requestObj', 'user'));
    }

    public function addNotes(Request $request)
    {
        $user = session()->get('user');

        $validations = [
            'beanID' => 'required',
            'note' => 'required',
            'documents.*' => 'required',
        ];

        $request->validate($validations);

        try {
            $params = array(
                //session id
                "session" => $user->session_id,
                //The name of the module from which to retrieve records.
                "module_name" => "STS_Claiming_Loans",
                //Record attributes
                "name_value_list" => array(
                    array("name" => "id", "value" => $request->beanID),
                    array("name" => "status", "value" => "feedback_provided"),
                ),
            );

            $response = crmCall($params, 'set_entry');


            if (!empty($response->name)) {
                if ($response->name === "Invalid Session ID" || $response->name == 'Access Denied') {
                    forgetAuthSessions($request);
                    return redirect(route('admin.login_form'));
                }
            }

            foreach ($request->documents as $file) {
                $fileName = $file->getClientOriginalName();
                $fileTmp = $file->getPathName();
                $file_split = (explode('.', $fileName));

                $doc_param = array(
                    //session id
                    "session" => $user->session_id,
                    //The name of the module
                    "module_name" => "STS_Claiming_Loans_Documents",
                    //Record attributes
                    "name_value_list" => array(
                        array("name" => "document_name", "value" => $file_split[0]),
                        array("name" => "file_ext", "value" => $file->getClientOriginalExtension()),
                        array("name" => "file_mime_type", "value" => $file->getClientMimeType()),
                        array("name" => "doc_key_c", "value" => 'feedback'),
                        array("name" => "description", "value" => $request->note),
                        array("name" => "uploadfile", "value" => $fileName),
                        array("name" => "sts_claimi9ee4g_loans_ida", "value" => $request->beanID),
                        array("name" => "assigned_user_id", "value" => $user->crm_user_id),
                        array("name" => "revision", "value" => "1"),
                    ),
                );

                $document  = crmCall($doc_param, 'set_entry');
                $attachment_id = $document->id;

                move_uploaded_file($fileTmp, "../../JI_new/upload/" . $attachment_id);
                $contents = file_get_contents('../../JI_new/upload/' . $attachment_id);

                $set_document_revision_parameters = array(
                    //session id
                    "session" => $user->session_id,
                    //The attachment details
                    "note" => array(
                        //The ID of the parent document.
                        'id' => $attachment_id,

                        //The binary contents of the file.
                        'file' => base64_encode($contents),

                        //The name of the file
                        'filename' => $fileName,

                        //The revision number
                        'revision' => '1',
                    ),
                );

                crmCall($set_document_revision_parameters, 'set_document_revision');
            }

            $notes_params = array(
                //session id
                "session" => $user->session_id,
                //The name of the module
                "module_name" => "STS_Claiming_Loans_Notes",
                //Record attributes
                "name_value_list" => array(
                    array("name" => "sts_claimi7e7dg_loans_ida", "value" => $request->beanID),
                    array("name" => "name", "value" => "View"),
                    array("name" => "note", "value" => $request->note),
                ),
            );

            $response = crmCall($notes_params, 'set_entry');

            if (!empty($response->name)) {
                if ($response->name === "Invalid Session ID" || $response->name == 'Access Denied') {
                    forgetAuthSessions($request);
                    return redirect(route('admin.login_form'));
                }
            }

            return redirect()->route('admin.request', 'open')->with('success', __('system-messages.add'));
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }


    public function show($request)
    {
        $user = session()->get('user');

        $params = array(
            //session id
            'session' => $user->session_id,
            //The name of the module from which to retrieve records
            'module_name' => 'STS_Claiming_Loans',
            //The id of the record to fetch
            'id' => $request,
            //Optional. The list of fields to be returned in the results
            'select_fields' => array(),

            //A list of link names and the fields to be returned for each link name
            'link_name_to_fields_array' => array(
                array(
                    'name' => 'sts_claiming_loans_sts_claiming_loans_notes_1',
                    'value' => array(
                        'id',
                        'description',
                        'date_entered',
                        'created_by',
                        'note',
                    ),
                ),
                array(
                    'name' => 'sts_claiming_loans_sts_claiming_loans_documents',
                    'value' => array(
                        'id',
                        'document_name',
                        'doc_key_c',
                        'uploadfile',
                        'created_by_name',
                        'created_by',
                        'date_entered',
                        'description',
                    ),
                ),
            ),
        );

        $response  = crmCall($params, 'get_entry');

        if (!empty($response->name)) {
            if ($response->name === "Invalid Session ID") {
                forgetAuthSessions($request);
                return redirect(route('admin.login_form'));
            }
        }

        $notes = [];
        $documents = [];

        if ($response->relationship_list && is_array($response->relationship_list)) {
            foreach ($response->relationship_list as $relationships) {
                foreach ($relationships as $relationship) {
                    switch ($relationship->name) {
                        case 'sts_claiming_loans_sts_claiming_loans_notes_1':
                            $notes = $relationship->records;
                            break;
                        case 'sts_claiming_loans_sts_claiming_loans_documents':
                            $documents = $relationship->records;
                            break;
                    }
                }
            }
        }

        $requestObj = $response->entry_list;
        $requestObj = $requestObj[0]->name_value_list;

        array_sort_by_column($notes);

        return view('admin.requests.show', compact('notes', 'requestObj', 'user', 'documents'));
    }
}
