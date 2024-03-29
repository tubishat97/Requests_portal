<?php

use Illuminate\Support\Facades\Session;

if (!function_exists('getHeaderLang')) {
    /**
     * Read HTTP_ACCEPT_LANGUAGE from header
     *
     * @return string
     */
    function getHeaderLang()
    {
        !empty(request()->server('HTTP_ACCEPT_LANGUAGE')) ? $lang = request()->server('HTTP_ACCEPT_LANGUAGE') : $lang = 'en';
        return $lang;
    }
}

if (!function_exists('slugify')) {
    function slugify($text, string $divider = '_')
    {
        // replace non letter or digits by divider
        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, $divider);

        // remove duplicate divider
        $text = preg_replace('~-+~', $divider, $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }
}

if (!function_exists('crmCall')) {
    function crmCall($params, $method)
    {
        $url =  env("JI_URL") . "/service/v4_1/rest.php";
        $jsonEncodedData = json_encode($params);
        $fields = array(
            "method" => $method,
            "input_type" => "JSON",
            "response_type" => "JSON",
            "rest_data" => $jsonEncodedData
        );
        ob_start();
        $curl_request = curl_init();
        curl_setopt($curl_request, CURLOPT_URL, $url);
        curl_setopt($curl_request, CURLOPT_POST, 1);
        curl_setopt($curl_request, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        curl_setopt($curl_request, CURLOPT_HEADER, 1);
        curl_setopt($curl_request, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl_request, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_request, CURLOPT_FOLLOWLOCATION, 0);
        curl_setopt($curl_request, CURLOPT_POSTFIELDS, $fields);
        $result = curl_exec($curl_request);
        $result = explode("\r\n\r\n", $result, 2);
        curl_close($curl_request);
        $response = json_decode($result[1]);
        ob_end_flush();
        return $response;
    }
}

if (!function_exists('crmLoginParams')) {
    function crmLoginParams($username, $password)
    {
        return  [
            "user_auth" => [
                "user_name" => $username,
                "password" => md5($password),
                "version" => "1"
            ],
            "application_name" => "JI",
            "name_value_list" => [],
        ];
    }
}

if (!function_exists('crmLoginParams')) {
    function crmLoginParams($username, $password)
    {
        return  [
            "user_auth" => [
                "user_name" => $username,
                "password" => md5($password),
                "version" => "1"
            ],
            "application_name" => "JI",
            "name_value_list" => [],
        ];
    }
}

if (!function_exists('putAuthSessions')) {
    function putAuthSessions($user)
    {
        Session::put('auth', true);
        Session::put('user', $user);
    }
}

if (!function_exists('forgetAuthSessions')) {
    function forgetAuthSessions($request)
    {
        $request->session()->forget('auth');
        $request->session()->forget('user');
        $request->session()->invalidate();
    }
}

if (!function_exists('getUploadedDocs')) {
    function getUploadedDocs($request)
    {
        $docs = $request->all();

        $result = [];

        foreach ($docs as $key => $doc) {
            if (is_array($doc) && $key != 'loans') {
                foreach ($doc as $singleFromMulti) {
                    $result[] = [
                        'file' => $singleFromMulti,
                        'key' => $key,
                        'description' => trans('admin-content.' . $key, [], 'ar'),
                        'path' => $singleFromMulti->getPathName(),
                    ];
                }

                continue;
            }

            if ($request->hasFile($key)) {
                $result[] = [
                    'file' => $doc,
                    'key' => $key,
                    'description' => trans('admin-content.' . $key, [], 'ar'),
                    'path' => $doc->getPathName(),
                ];
            }
        }

        return $result;
    }
}

if (!function_exists('array_sort_by_column')) {
    function array_sort_by_column(&$array, $direction = SORT_ASC)
    {
        $reference_array = [];

        foreach ($array as $key => $row) {
            $reference_array[$key] = $row->date_entered;
        }

        array_multisort($reference_array, $direction, $array);

        return $reference_array;
    }
}


if (!function_exists('claimsStatusesArray')) {
    function claimsStatusesArray()
    {
        return [
            'open',
            'initiated',
            'assigned',
            'undervaluation',
            'provide_feedback',
            'above_authority',
            'proceed',
            'feedback_provided'
        ];
    }
}


if (!function_exists('getClaimStatusCondition')) {
    function getClaimStatusCondition($type)
    {
        $conditionType = [
            'open' => "sts_claiming_loans.status IN ('initiated', 'assigned', 'undervaluation' , 'above_authority', 'feedback_provided')",
            'provide_feedback' => "sts_claiming_loans.status = 'provide_feedback'",
            'proceed' => "sts_claiming_loans.status = 'proceed'"
        ];

        return $conditionType[$type];
    }
}

if (!function_exists('modify')) {
    function modify($str)
    {
        return ucwords(str_replace("_", " ", $str));
    }
}
