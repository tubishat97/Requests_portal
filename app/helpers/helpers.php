<?php

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
