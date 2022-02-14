<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class RequestController extends Controller
{

    public function __construct()
    {
        $this->user = session()->get('user');
    }

    public function deathRequestIndex(Request $request)
    {
        $user = session()->get('user');

        $params = array(
            //session id
            'session' => $user->session_id,
            //The name of the module from which to retrieve records
            'module_name' => 'STS_Claiming_Loans',
            //The SQL WHERE clause without the word "where".
            'query' => "sts_claiming_loans.created_by = '$user->crm_user_id' AND sts_claiming_loans.type = 'death'",
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

        $response = crmCall($params, 'get_entry_list');

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
                    array("name" => "type", "value" => "death"),
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


            // put the docs here.
            $requestFilePath = public_path('storage/request');
            if (!File::exists($requestFilePath)) {
                File::makeDirectory($requestFilePath, 0777, true);
            }

            $docs = getUploadedDocs($request);


            foreach ($docs as $doc) {
                $image = $doc['file'];
                if (!is_array($image)) {
                    $name = uniqid() . '-' . time() . '.' . $image->getClientOriginalExtension();
                    $docName = 'request/' . $name;
                    $doc['file']->move($requestFilePath, $docName);
                } else {
                    continue;
                }


                $doc_param = array(
                    //session id
                    "session" => $user->session_id,
                    //The name of the module
                    "module_name" => "STS_Claiming_Loans_Documents",
                    //Record attributes
                    "name_value_list" => array(
                        array("name" => "document_name", "value" => $doc['key']),
                        array("name" => "description", "value" => $doc['description']),
                        array("name" => "uploadfile", "value" => $doc['key']),
                        array("name" => "sts_claimi9ee4g_loans_ida ", "value" => $response->id),
                        array("name" => "assigned_user_id", "value" => $user->crm_user_id),
                        array("name" => "revision", "value" => "1"),
                    ),
                );

                $document  = crmCall($doc_param, 'set_entry');

                $attachment_id = $document->id;

                move_uploaded_file($doc['file'], "../../../JI_new/upload/" . $attachment_id);
                $contents = file_get_contents("../../../JI_new/upload/" . $attachment_id);

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
                        'filename' => $docName,

                        //The revision number
                        'revision' => '1',
                    ),
                );

                crmCall($set_document_revision_parameters, 'set_document_revision');
            }

            return redirect()->route('admin.request.death')->with('success', __('system-messages.add'));
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }


    public function inabilityRequestIndex()
    {

        $data = Customer::all();
        return view('admin.requests.inability-list', compact('data'));
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
            'type' => 'required',
            'description' => 'required',
        ];

        $request->validate($validations);

        try {
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }
}
