<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    public function deathRequestIndex()
    {
        $data = Customer::all();
        return view('admin.requests.list', compact('data'));
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
