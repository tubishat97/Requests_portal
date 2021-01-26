<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{

    public function index()
    {
        $data = Customer::all();
        return view('admin.customers.list', compact('data'));
        
    }

    public function show(Customer $customer)
    {
        return view('admin.customers.profile', compact(['customer']));
    }

    public function update(Request $request, Customer $customer)
    {
        $validations = [
            'fullname' => 'required',
            'mobile' => 'nullable',
            'email' => 'nullable|email',
            'password' => 'nullable|min:6|confirmed',
        ];
        $request->validate($validations);

        try {
            if ($request->password) {
                $customer->password = Hash::make($request->password);
            }
            $customer->profile->email = $request->email;
            $customer->profile->fullname = $request->fullname;
            $customer->profile->is_active = $request->has('is_active') ? true : false;
            $customer->profile->mobile = $request->mobile;
            $customer->profile->save();
            $customer->save();
            return redirect()->back()->with('success', __('system-messages.update'));
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    public function destroy(Customer $customer)
    {
        if ($customer) {
            $customer->delete();
            return redirect(route('admin.customer.index'))->with('success', __('system-messages.delete'));
        } else {
            return redirect(route('admin.customer.index'))->with('error', 'cutomer not found');
        }
    }
}
