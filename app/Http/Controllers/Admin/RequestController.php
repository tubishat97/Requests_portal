<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class RequestController extends Controller
{
    public function deathRequestIndex(Request $request)
    {
        $user = session()->get('user');
        $response = $this->getRequestsWhereType($user, 'death');

        if (!empty($response->name)) {
            if ($response->name === "Invalid Session ID") {
                forgetAuthSessions($request);
                return redirect(route('admin.login_form'));
            }
        }

        $requests = $response->entry_list;

        return view('admin.requests.list', compact('requests'));
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
            'loans.*' => 'required'
        ];

        $request->validate($validations);

        try {
            $user = session()->get('user');
            $this->storeWhereType($user, $request, 'death');

            return redirect()->route('admin.request.death')->with('success', __('system-messages.add'));
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    public function inabilityRequestIndex(Request $request)
    {
        $user = session()->get('user');

        $response = $this->getRequestsWhereType($user, 'inability');

        if (!empty($response->name)) {
            if ($response->name === "Invalid Session ID") {
                forgetAuthSessions($request);
                return redirect(route('admin.login_form'));
            }
        }

        $requests = $response->entry_list;

        return view('admin.requests.inability-list', compact('requests'));
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
            return redirect()->route('admin.request.inability')->with('success', __('system-messages.add'));
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    public function getRequestsWhereType($user, $type)
    {
        $params = array(
            //session id
            'session' => $user->session_id,
            //The name of the module from which to retrieve records
            'module_name' => 'STS_Claiming_Loans',
            //The SQL WHERE clause without the word "where".
            'query' => "sts_claiming_loans.created_by = '$user->crm_user_id' AND sts_claiming_loans.type = '$type'",
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
            'deleted' => '0',
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
            if ($response->name === "Invalid Session ID") {
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

        $requestFilePath = public_path('storage/request');
        if (!File::exists($requestFilePath)) {
            File::makeDirectory($requestFilePath, 0777, true);
        }

        foreach ($docs as $doc) {
            $file = $doc['file'];
            $path = $doc['path'];
            $name = uniqid() . '-' . time() . '.' . $file->getClientOriginalExtension();
            $doc_param = array(
                //session id
                "session" => $user->session_id,
                //The name of the module
                "module_name" => "STS_Claiming_Loans_Documents",
                //Record attributes
                "name_value_list" => array(
                    array("name" => "document_name", "value" => $doc['description']),
                    array("name" => "description", "value" => $doc['description']),
                    array("name" => "uploadfile", "value" => $doc['key']),
                    array("name" => "sts_claimi9ee4g_loans_ida", "value" => $response->id),
                    array("name" => "assigned_user_id", "value" => $user->crm_user_id),
                    array("name" => "revision", "value" => "1"),
                ),
            );

            $document  = crmCall($doc_param, 'set_entry');

            $attachment_id = $document->id;
            $name = $attachment_id . '.' . $file->getClientOriginalExtension();
            $file->move($requestFilePath, 'request/' . $name);


            if (move_uploaded_file(public_path("storage/request/" . $name), "../../JI_new/upload/" . $attachment_id)) {
                dd("upload complete");
            } else {
                dd("move_uploaded_file failed");
            }
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
                    'filename' => $name . ' ' . "[$user->name]",

                    //The revision number
                    'revision' => '1',
                ),
            );

            crmCall($set_document_revision_parameters, 'set_document_revision');
        }
    }
}
