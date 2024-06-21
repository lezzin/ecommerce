<?php

function url_format($url): string
{
    $decodedUrl = urldecode($url);
    $withoutSpacesUrl = str_replace(' ', '-', $decodedUrl);
    $lowerCaseUrl = strtolower($withoutSpacesUrl);

    $transliterationTable = [
        'á' => 'a', 'ã' => 'a', 'â' => 'a', 'à' => 'a', 'ä' => 'a',
        'é' => 'e', 'ê' => 'e', 'è' => 'e', 'ë' => 'e',
        'í' => 'i', 'î' => 'i', 'ì' => 'i', 'ï' => 'i',
        'ó' => 'o', 'õ' => 'o', 'ô' => 'o', 'ò' => 'o', 'ö' => 'o',
        'ú' => 'u', 'û' => 'u', 'ù' => 'u', 'ü' => 'u',
        'ç' => 'c',
        'Á' => 'a', 'Ã' => 'a', 'Â' => 'a', 'À' => 'a', 'Ä' => 'a',
        'É' => 'e', 'Ê' => 'e', 'È' => 'e', 'Ë' => 'e',
        'Í' => 'i', 'Î' => 'i', 'Ì' => 'i', 'Ï' => 'i',
        'Ó' => 'o', 'Õ' => 'o', 'Ô' => 'o', 'Ò' => 'o', 'Ö' => 'o',
        'Ú' => 'u', 'Û' => 'u', 'Ù' => 'u', 'Ü' => 'u',
        'Ç' => 'c'
    ];

    $formattedUrl = strtr($lowerCaseUrl, $transliterationTable);

    return $formattedUrl;
}

function get_original_url($url)
{
    $withSpaceUrl = str_replace('-', ' ', $url);
    return $withSpaceUrl;
}
