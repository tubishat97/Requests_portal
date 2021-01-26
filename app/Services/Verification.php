<?php

namespace App\Services;

use App\Enums\VerificationService;
use App\Enums\VerificationTypes;
use Multicaret\Unifonic\UnifonicFacade as Unifonic;
use Illuminate\Support\Facades\URL;
use Mail;

class Verification
{
    protected $user;
    protected $user_type;
    protected $verification_type;
    protected $verify_using;
    protected $send_to;

    public function __construct($user, VerificationTypes $verification_type, VerificationService $verify_using, string $send_to = '', string $user_type = 'user')
    {
        $this->user = $user;
        $this->user_type = $user_type;
        $this->verification_type = $verification_type;
        $this->verify_using = $verify_using;
        $this->send_to = $send_to;
    }

    public function process()
    {
        $code = rand(pow(10, 4 - 1), pow(10, 4) - 1);

        switch ($this->verify_using) {
            case VerificationService::fromValue(VerificationService::Mail):
                if (VerificationTypes::fromValue(VerificationTypes::Register)) {
                    // Generate Signed Route
                    $url_params = [
                        'type' => $this->user_type,
                        'email' => $this->send_to,
                        'user' => $this->user->id,
                        'code' => $code,
                    ];
                    $url = URL::signedRoute('verifyMail', $url_params);

                    $parts = parse_url($url);
                    parse_str($parts['query'], $query);
                    $url_params['signature'] = $query['signature'];

                    Mail::send(
                        'mail.register',
                        [
                            'name' => trim($this->user->fullname),
                            'link' => config('services.front_end.homepage') . 'verify-mail?' . http_build_query($url_params),
                        ],
                        function ($message) {
                            $message->to([$this->send_to])
                                ->subject('Confirmation Email');
                        }
                    );
                    $this->user->verifications()->create([
                        'code' => $code,
                        'type' => $this->verification_type->value,
                        'service' => VerificationService::Mail,
                        'status' => false,
                        'account_id' => $this->user->id,
                    ]);
                }
                if (VerificationTypes::fromValue(VerificationTypes::ForgetPassword)) {
                    # code...
                }
                if (VerificationTypes::fromValue(VerificationTypes::Resend)) {
                    # code...
                }
                if (VerificationTypes::fromValue(VerificationTypes::UpdatePhoneNumber)) {
                    # code...
                }
                break;
            case VerificationService::fromValue(VerificationService::SMS):
                if (VerificationTypes::fromValue(VerificationTypes::Register)) {
                    $this->user->verifications()->create([
                        'code' => $code,
                        'type' => $this->verification_type->value,
                        'service' => VerificationService::SMS,
                        'status' => false,
                        'account_id' => $this->user->id,
                    ]);
                    if ($this->send_to == 0) {
                        $this->send_to = $this->user->mobile;
                    }
                    Unifonic::send($this->send_to, 'Your verification code is: ' . $code);
                }
                if (VerificationTypes::fromValue(VerificationTypes::ForgetPassword)) {
                    # code...
                }
                if (VerificationTypes::fromValue(VerificationTypes::Resend)) {
                    # code...
                }
                if (VerificationTypes::fromValue(VerificationTypes::UpdatePhoneNumber)) {
                    # code...
                }
                break;
        }
        return $code;
    }
}
