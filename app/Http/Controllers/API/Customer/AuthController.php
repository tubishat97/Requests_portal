<?php

namespace App\Http\Controllers\API\Customer;

use App\Models\Customer;
use App\Models\CustomerProfile;
use App\Models\CustomerProvider;
use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\ChangePasswordRequest;
use App\Http\Requests\Customer\ForgetPasswordRequest;
use App\Http\Requests\Customer\LinkSocialRequest;
use App\Http\Requests\Customer\LoginRequest;
use App\Http\Requests\Customer\RegisterRequest;
use App\Http\Requests\Customer\ResendSMSRequest;
use App\Http\Requests\Customer\ResetPasswordRequest;
use App\Http\Requests\Customer\SocialRequest;
use App\Http\Requests\Customer\VerifySMSRequest;
use App\Http\Resources\Customer as ResourcesCustomer;
use App\Traits\ApiResponser;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Twilio\Rest\Client;

class AuthController extends Controller
{
    use ApiResponser;

    public function login(LoginRequest $request)
    {
        $http = new \GuzzleHttp\Client([
            'base_uri' => config('services.guzzle.base_url'),
        ]);
        try {
            $customer = Customer::where('username', $request->username)->whereNull('account_verified_at')->first();
            if ($customer) {
                return $this->errorResponse(205, trans('api.auth.enter_verify_code'), 400);
            }

            $response = $http->request('POST', config('services.passport.login_endpoint'), [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => config('services.passport.client_id'),
                    'client_secret' => config('services.passport.client_secret'),
                    'username' => $request->username,
                    'password' => $request->password,
                    'provider' => 'customers'
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
        $customer = new Customer($request->all());
        $customer->password = bcrypt($request->password);
        $customer->username = $request->username;
        $customer->save();

        $profile = new CustomerProfile();
        $profile->customer_id = $customer->id;
        $profile->fullname = trim($request->fullname);
        $profile->save();

        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_sid = getenv("TWILIO_SID");
        $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
        $twilio = new Client($twilio_sid, $token);
        $twilio->verify->v2->services($twilio_verify_sid)
            ->verifications
            ->create('+' . $customer->username, "sms");

        return $this->successResponse(200, trans('api.auth.register'), 200, []);
    }

    public function verifySMS(VerifySMSRequest $request)
    {
        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_sid = getenv("TWILIO_SID");
        $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
        $twilio = new Client($twilio_sid, $token);
        $verification = $twilio->verify->v2->services($twilio_verify_sid)
            ->verificationChecks
            ->create($request->verification_code, array('to' => '+' . $request->username));

        if ($verification->valid) {
            $customer = tap(Customer::where('username', $request->username))->update(['account_verified_at' => now()]);
            return $this->successResponse(200, trans('api.auth.verify_SMS_done'), 200, []);
        }

        return $this->errorResponse(401, trans('api.verification.invalid'), 401);
    }

    public function verifySMSPhone(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'verification_code' => 'required|string',
            'old_username' => 'required|string',
        ]);

        $customer = Customer::where('username', $request->old_username)->first();

        if (empty($customer)) {
            return $this->errorResponse(401, trans('api.verification.invalid'), 401);
        }

        try {
            $token = getenv("TWILIO_AUTH_TOKEN");
            $twilio_sid = getenv("TWILIO_SID");
            $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
            $twilio = new Client($twilio_sid, $token);
            $verification = $twilio->verify->v2->services($twilio_verify_sid)
                ->verificationChecks
                ->create($request->verification_code, array('to' => '+'. $request->username));

            if ($verification->valid) {
                $customer->account_verified_at = Carbon::now();
                $customer->username =  $request->username;
                $customer->save();
                return $this->successResponse(200, trans('api.auth.verify_SMS_done'), 200, new ResourcesCustomer($customer));
            }
        } catch (\Exception $e) {
            return $this->errorResponse(401, $e->getMessage(), 401);
        }
    }


    public function resendSMS(ResendSMSRequest $request)
    {
        $customer = Customer::where('username', $request->username)->first();

        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_sid = getenv("TWILIO_SID");
        $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
        $twilio = new Client($twilio_sid, $token);
        $twilio->verify->v2->services($twilio_verify_sid)
            ->verifications
            ->create('+' . $customer->username, "sms");

        return $this->successResponse(200, trans('api.auth.resent_SMS_done'), 200, []);
    }

    public function forgetPassword(ForgetPasswordRequest $request)
    {
        $customer = Customer::where('username', $request->username)->first();
        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_sid = getenv("TWILIO_SID");
        $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
        $twilio = new Client($twilio_sid, $token);
        $twilio->verify->v2->services($twilio_verify_sid)
            ->verifications
            ->create('+' . $customer->username, "sms");
        return $this->successResponse(200, trans('api.auth.forget_password_config'), 200, []);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $customer = Customer::where('username', $request->username)->first();
        $customer->password = bcrypt($request->new_password);
        $customer->account_verified_at = date('Y-m-d H:i:s');
        $customer->save();
        return $this->successResponse(200, trans('api.auth.verify_SMS_done'), 200, []);
    }

    public function logout()
    {
        auth()->user()->tokens()->each(function ($token) {
            $token->delete();
        });
        return $this->successResponse(200, trans('api.auth.loggedout'), 200, []);
    }

    public function profile()
    {
        return $this->successResponse(200, trans('api.public.done'), 200, new ResourcesCustomer(auth()->user()));
    }

    public function updateProfile(request $request)
    {
        $customer = auth()->user();

        if ($request->has('username')) {

            $check = Customer::where('username', $request->username)->count();

            if ($check > 0) {
                return $this->errorResponse(403, 'The phone number is already used', 200);
            }
            $rules = [
                'username' => 'required|unique:customers',
            ];

            $request->validate($rules);

            try {
                $token = getenv("TWILIO_AUTH_TOKEN");
                $twilio_sid = getenv("TWILIO_SID");
                $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
                $twilio = new Client($twilio_sid, $token);
                $twilio->verify->v2->services($twilio_verify_sid)
                    ->verifications
                    ->create('+'. $request->username, "sms");
                $customer->account_verified_at = null;
                $customer->save();

                return $this->successResponse(200, trans('api.auth.resent_SMS_done'), 200, []);
            } catch (\Exception $e) {
                return $this->errorResponse(403, $e->getMessage(), 200);
            }
        }

        $rules = [
            'fullname' => 'nullable',
            'image' => 'nullable|mimes:' . config('services.allowed_file_extensions.images'),
        ];
        $request->validate($rules);

        $profile = $customer->profile;

        $profile = is_null($profile) ? new CustomerProfile() : $profile;
        $profile->customer_id = $customer->id;
        $profile->fullname =  $request->fullname ? trim($request->fullname) : $profile->fullname;

        if ($request->hasFile('image')) {
            try {
                $driverFilePath = public_path('storage/customer');
                if (!File::exists($driverFilePath)) {
                    File::makeDirectory($driverFilePath, 0777, true);
                }
                $image = $request->file('image');
                $name = uniqid() . '-' . time() . '.' . $image->getClientOriginalExtension();
                $image = Image::make($request->file('image'))->save($driverFilePath . '/' . $name);
                $profile->image = 'customer/' . $name;
                $profile->save();
            } catch (\Exception $e) {
                return $this->errorResponse($e->getCode(), $e->getMessage(), 200);
            }
        }

        $profile->email = $request->email ? $request->email : $profile->email;
        $profile->mobile = $request->mobile ? $request->mobile : $profile->mobile;
        $profile->birthdate = $request->birthdate ? $request->birthdate : $profile->birthdate;
        $profile->is_active = true;
        $profile->device_id = $request->device_id ? $request->device_id  : $profile->device_id;
        $profile->save();
        $customer->profile = $profile;

        return $this->successResponse(200, trans('api.public.done'), 200, new ResourcesCustomer($customer));
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $customer = auth()->user();
        if (Hash::check($request->old_password, $customer->password)) {
            $customer->password = bcrypt($request->new_password);
            $customer->save();
            return $this->successResponse(200, trans('api.auth.password_updated'), 200, []);
        } else {
            return $this->successResponse(20, trans('api.auth.old_password_incorrect'), 200, []);
        }
    }

    public function socialLogin(SocialRequest $request)
    {
        $provider = CustomerProvider::where('provider_id', $request->provider_id)
            ->where('provider', $request->provider);

        if ($provider->count() > 0) {
            // get first one
            return $this->successResponse(200, trans('api.public.done'), 200, new ResourcesCustomer($provider->first()->customer));
        } else {
            // create new account
            $check_customer = Customer::where('username', '=', $request->username);
            if ($check_customer->count() > 0) {
                return $this->errorResponse(200, trans('api.auth.social_exists'), 200);
            }

            // create account
            $customer = new Customer();
            $customer->username = $request->username;
            $customer->password = bcrypt(Str::random(10));
            $customer->account_verified_at = now();
            $customer->save();

            // link with social
            $provider = new CustomerProvider();
            $provider->customer_id = $customer->id;
            $provider->provider_id = $request->provider_id;
            $provider->provider = $request->provider;
            $provider->save();
            return $this->successResponse(200, trans('api.public.done'), 200, new ResourcesCustomer($customer));
        }
    }

    public function linkSocialAccount(LinkSocialRequest $request)
    {
        $customer = auth()->user();
        $provider = CustomerProvider::where('provider_id', $request->provider_id)
            ->where('provider', $request->provider)
            ->where('customer_id', $customer->id);

        try {
            if ($provider->count() == 0) {
                // link new account
                $provider = new CustomerProvider();
                $provider->customer_id = $customer->id;
                $provider->provider_id = $request->provider_id;
                $provider->provider = $request->provider;
                $provider->save();
            }
            return $this->successResponse(200, trans('api.public.done'), 200, new ResourcesCustomer(auth()->user()));
        } catch (QueryException $e) {
            return $this->errorResponse(200, trans('api.auth.social_exists'), 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getCode(), trans('api.public.server_error'), $e->getCode());
        }
    }
}
