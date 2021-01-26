<?php

namespace App\Http\Controllers\API\User;

use App\Enums\VerificationService;
use App\Enums\VerificationTypes;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Requests\User\VerifySMSRequest;
use App\Http\Resources\User as ResourcesUser;
// use App\Point;
use App\Traits\ApiResponser;
// use Illuminate\Http\Request;
use App\Services\Verification;
// use App\SocialCustomer;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\URL;
// use Illuminate\Support\Facades\File;
// use Illuminate\Support\Facades\Storage;
// use Intervention\Image\ImageManagerStatic as Image;
// use Illuminate\Support\Str;

class AuthController extends Controller
{
    use ApiResponser;

    public function login(LoginRequest $request)
    {
        $http = new \GuzzleHttp\Client([
            'base_uri' => config('services.guzzle.base_url'),
        ]);
        try {
            $user = User::where('username', $request->username)->whereNull('account_verified_at')->first();
            if ($user) {
                return $this->errorResponse(205, trans('api.auth.enter_verify_code'), 400);
            }

            $response = $http->request('POST', config('services.passport.login_endpoint'), [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => config('services.passport.client_id'),
                    'client_secret' => config('services.passport.client_secret'),
                    'username' => $request->username,
                    'password' => $request->password,
                    'provider' => 'users'
                ],
            ]);

            $result = json_decode($response->getBody());
            return $this->successResponse(200, trans('api.auth.login'), 200, $result);
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            switch ($e->getCode()) {
                case 400:
                case 401:
                    return $this->errorResponse($e->getCode(), trans('api.auth.invalid_credentials'), $e->getCode());
                    break;
                default:
                    return $this->errorResponse($e->getCode(), trans('api.public.server_error'), $e->getCode());
                    break;
            }
        }
    }

    public function register(RegisterRequest $request)
    {
        $user = new User($request->all());
        $user->password = bcrypt($request->password);
        $user->save();

        $verification = app()->makeWith(Verification::class, [
            'user' => $user,
            'user_type' => 'user',
            'verification_type' => VerificationTypes::fromValue(VerificationTypes::Register),
            'verify_using' => VerificationService::fromValue(VerificationService::SMS),
            'send_to' => $user->username,
        ]);
        $code = $verification->process();
        return $this->successResponse(200, trans('api.auth.register'), 200, []);
    }

    public function verifySMS(VerifySMSRequest $request)
    {
        $user = User::where('username', $request->username)->first();

        $verifications_row = $user->verifications->where('code', $request->verification_code)
            ->where('type', VerificationTypes::Register)
            ->where('service', VerificationService::SMS)
            ->where('status', 0)
            ->first();

        if (is_null($verifications_row)) {
            return $this->errorResponse(401, trans('api.verification.invalid'), 401);
        }

        $user->account_verified_at = now();
        $user->save();

        $verifications_row->status = true;
        $verifications_row->save();

        return $this->successResponse(200, trans('api.auth.verify_SMS_done'), 200, []);
    }

    // public function resendSMS(Request $request)
    // {
    //     $request->validate([
    //         'mobile' => 'required|string',
    //     ]);

    //     $customer = Customer::where('mobile', $request->mobile)->first();
    //     if (is_null($customer)) {
    //         return $this->errorResponse(401, trans('api.customer.not_found'), 401);
    //     }

    //     if (!is_null($customer->verified_mobile_at)) {
    //         return $this->errorResponse(401, trans('api.auth.verify_SMS_already'), 401);
    //     }

    //     $customer->verifications()->where('service', VerificationService::SMS)
    //         ->where('status', 0)->update(['status' => true]);

    //     $verification = app()->makeWith(Verification::class, [
    //         'user' => $customer,
    //         'user_type' => 'customer',
    //         'verification_type' => VerificationTypes::fromValue(VerificationTypes::Resend),
    //         'verify_using' => VerificationService::fromValue(VerificationService::SMS),
    //         'send_to' => $customer->mobile,
    //     ]);
    //     $code = $verification->process();

    //     return $this->successResponse(200, trans('api.auth.resent_SMS_done'), 200, []);
    // }

    // public function forgetPassword(Request $request)
    // {
    //     $request->validate(
    //         [
    //             'mobile' => 'required',
    //         ]
    //     );

    //     $customer = Customer::where('mobile', $request->mobile)->first();
    //     if (!is_null($customer)) {
    //         $verification = app()->makeWith(Verification::class, [
    //             'user' => $customer,
    //             'user_type' => 'customer',
    //             'verification_type' => VerificationTypes::fromValue(VerificationTypes::ForgetPassword),
    //             'verify_using' => VerificationService::fromValue(VerificationService::SMS),
    //             'send_to' => $customer->mobile,
    //         ]);
    //         $code = $verification->process();
    //     }
    //     return $this->successResponse(200, trans('api.auth.forget_password_config'), 200, []);
    // }

    public function logout()
    {
        auth()->user()->tokens()->each(function ($token) {
            $token->delete();
        });
        return $this->successResponse(200, trans('api.auth.loggedout'), 200, []);
    }

    public function profile()
    {
        return $this->successResponse(200, trans('api.public.done'), 200, new ResourcesUser(auth()->user()));
    }

    // public function changePassword(Request $request)
    // {
    //     $request->validate(
    //         [
    //             'old_password' => 'required',
    //             'new_password' => 'required|min:6|different:old_password',
    //             'confirm_password' => 'required|same:new_password',
    //         ],
    //         [
    //             'confirm_password.required' => 'The confirm password is required.',
    //             'confirm_password.same' => 'The confirm password and new password must match.',
    //         ]
    //     );

    //     if (Hash::check($request->old_password, auth()->user()->password)) {
    //         auth()->user()->password = bcrypt($request->new_password);
    //         auth()->user()->save();
    //         return $this->successResponse(200, trans('api.auth.password_updated'), 200, []);
    //     } else {
    //         return $this->successResponse(20, trans('api.auth.old_password_incorrect'), 200, []);
    //     }
    // }

    // public function resetPassword(Request $request)
    // {
    //     $request->validate([
    //         'mobile' => 'required|string',
    //         'verification_code' => 'required|string',
    //         'new_password' => 'required|min:6|different:old_password',
    //         'confirm_password' => 'required|same:new_password',
    //     ]);

    //     $customer = Customer::where('mobile', $request->mobile)->first();
    //     if (is_null($customer)) {
    //         return $this->errorResponse(401, trans('api.customer.not_found'), 401);
    //     }

    //     $verifications_row = $customer->verifications->where('code', $request->verification_code)
    //         ->where('type', VerificationTypes::ForgetPassword)
    //         ->where('service', VerificationService::SMS)
    //         ->where('status', 0)
    //         ->first();

    //     if (is_null($verifications_row)) {
    //         return $this->errorResponse(401, trans('api.verification.invalid'), 401);
    //     }

    //     $customer->password = bcrypt($request->new_password);
    //     $customer->verified_mobile_at = date('Y-m-d H:i:s');
    //     $customer->save();

    //     $verifications_row->status = true;
    //     $verifications_row->save();

    //     return $this->successResponse(200, trans('api.auth.password_reset'), 200, []);
    // }

    // public function updateProfile(Request $request)
    // {
    //     $request->validate(
    //         [
    //             'first_name' => 'nullable',
    //             'last_name' => 'nullable',
    //             'token' => 'nullable',
    //             'email' => 'nullable|email',
    //             'nationality' => 'nullable|exists:nationalities,id',
    //             'birthdate' => 'nullable|date',
    //             'notifications' => 'nullable|boolean',
    //             'offers' => 'nullable|boolean',
    //             'image' => 'nullable|mimes:' . config('services.allowed_file_extensions.images'),
    //             // 'mobile' => 'nullable|integer|unique:drivers,mobile',
    //         ]
    //     );

    //     if ($request->first_name) {
    //         $user = auth()->user();
    //         $user->first_name = $request->first_name;
    //         $user->save();
    //     }

    //     if ($request->last_name) {
    //         $user = auth()->user();
    //         $user->last_name = $request->last_name;
    //         $user->save();
    //     }

    //     if ($request->token) {
    //         $user = auth()->user();
    //         $user->fcm_token = $request->token;
    //         $user->save();
    //     }

    //     if ($request->email) {
    //         $user = auth()->user();
    //         $user->email = trim($request->email);
    //         $user->save();
    //     }

    //     if ($request->nationality) {
    //         $user = auth()->user();
    //         $user->nationality_id = $request->nationality;
    //         $user->save();
    //     }

    //     if ($request->birthdate) {
    //         $user = auth()->user();
    //         $user->birthdate = $request->birthdate;
    //         $user->save();
    //     }

    //     if ($request->has('notifications')) {
    //         $user = auth()->user();
    //         $settings = json_decode($user->settings);
    //         $settings->notifications = (bool) $request->notifications;
    //         $user->settings = json_encode($settings);
    //         $user->save();
    //     }

    //     if ($request->has('offers')) {
    //         $user = auth()->user();
    //         $settings = json_decode($user->settings);
    //         $settings->offers = (bool)$request->offers;
    //         $user->settings = json_encode($settings);
    //         $user->save();
    //     }

    //     if ($request->hasFile('image')) {
    //         try {
    //             $user = auth()->user();

    //             $driverFilePath = public_path('storage/customer');
    //             if (!File::exists($driverFilePath)) {
    //                 File::makeDirectory($driverFilePath, 0777, true);
    //             }

    //             $oldImagePath = $user->image;
    //             $image = $request->file('image');
    //             $name = uniqid() . '-' . time() . '.' . $image->getClientOriginalExtension();
    //             $image = Image::make($request->file('image'))->save($driverFilePath . '/' . $name);
    //             $user->image = 'customer/' . $name;
    //             $user->save();
    //             Storage::delete('public/' . $oldImagePath);
    //         } catch (\Exception $e) {
    //             //print_r($e->getMessage());
    //             return $this->errorResponse($e->getCode(), $e->getMessage(), 200);
    //         }
    //     }

    //     return $this->successResponse(200, trans('api.public.done'), 200, new ResourcesCustomer($user));
    // }

    // public function updatePhoneNumber(Request $request)
    // {
    //     $request->validate([
    //         'mobile' => 'required|integer|unique:customers,mobile',
    //     ]);
    //     $customer = auth()->user();

    //     $verification = app()->makeWith(Verification::class, [
    //         'user' => $customer,
    //         'user_type' => 'customer',
    //         'verification_type' => VerificationTypes::fromValue(VerificationTypes::UpdatePhoneNumber),
    //         'verify_using' => VerificationService::fromValue(VerificationService::SMS),
    //         'send_to' => $request->mobile,
    //     ]);
    //     $code = $verification->process();

    //     return $this->successResponse(200, trans('api.auth.code_sent_successfully'), 200, []);
    // }

    // public function verifySMSForUpdatePhone(Request $request)
    // {
    //     $request->validate([
    //         'old_mobile' => 'required|integer',
    //         'new_mobile' => 'required|integer',
    //         'verification_code' => 'required|string',
    //     ]);

    //     $customer = Customer::where('mobile', $request->old_mobile)->first();
    //     if (is_null($customer)) {
    //         return $this->errorResponse(401, trans('api.customer.not_found'), 401);
    //     }

    //     $verifications_row = $customer->verifications->where('code', $request->verification_code)
    //         ->where('type', VerificationTypes::UpdatePhoneNumber)
    //         ->where('service', VerificationService::SMS)
    //         ->where('status', 0)
    //         ->first();

    //     if (is_null($verifications_row)) {
    //         return $this->errorResponse(401, trans('api.verification.invalid'), 401);
    //     }

    //     $customer->mobile = $request->new_mobile;
    //     $customer->verified_mobile_at = date('Y-m-d H:i:s');
    //     $customer->save();

    //     $verifications_row->status = true;
    //     $verifications_row->save();

    //     return $this->successResponse(200, trans('api.auth.verify_SMS_done'), 200, []);
    // }

    // public function resendSMSForUpdatePhone(Request $request)
    // {
    //     $request->validate([
    //         'new_mobile' => 'required|string',
    //     ]);
    //     $customer = auth()->user();
    //     $customer->verifications()->where('service', VerificationService::SMS)
    //         ->where('status', 0)->update(['status' => true]);

    //     $verification = app()->makeWith(Verification::class, [
    //         'user' => $customer,
    //         'user_type' => 'customer',
    //         'verification_type' => VerificationTypes::fromValue(VerificationTypes::Resend),
    //         'verify_using' => VerificationService::fromValue(VerificationService::SMS),
    //         'send_to' => $request->new_mobile,
    //     ]);
    //     $code = $verification->process();

    //     return $this->successResponse(200, trans('api.auth.resent_SMS_done'), 200, []);
    // }
}
