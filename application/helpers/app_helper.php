<?php

define("VERSION",                       "0.1.0");
define("SESSION",                       "SIPEGIAT-SESSION");
define("NO_IMAGE",                      base_url("assets/img/app/no-image.jpg"));
define("NO_COVER",                      base_url("assets/img/app/no-cover.jpg"));
define("NO_DATA",                       base_url("assets/img/app/no-data.jpg"));

//! FOR LOKASI
define("LOKASI_PENGATURAN",             "assets/upload/config/");
define("LOKASI_REKENING",               "assets/upload/rekening/");
define("LOKASI_ARMADA",                 "assets/upload/armada/");
define("LOKASI_TRANSFER",               "assets/upload/bukti-transfer/");

//! FOR ROLES
define("SUPER_ADMIN",                   "SUPER_ADMIN");
define("ADMIN",                         "ADMIN");
define("USER",                          "USER");

//! FOR STATUS USER
define("MENUNGGU",                      "MENUNGGU");
define("DITERIMA",                      "DITERIMA");
define("DITOLAK",                       "DITOLAK");
define("BLOCK",                         "BLOCK");

//! FOR GENDER
define("LAKI_LAKI",                     "LAKI-LAKI");
define("PEREMPUAN",                     "PEREMPUAN");

//!TODO : CHECK DIRECTORY IS EXIST OR NOT
$listDirectoryCheck  = [
    LOKASI_PENGATURAN,
    LOKASI_REKENING,
    LOKASI_ARMADA,
    LOKASI_TRANSFER
];

foreach ($listDirectoryCheck as $list) {
    if (!file_exists($list)) {
        mkdir($list, 0777, TRUE);
    }
}

if (!function_exists("getApiKey")) {
    function getApiKey()
    {
        $CI                 = &get_instance();
        $api_key_variable   = $CI->config->item('rest_key_name');
        $key_name           = 'HTTP_' . strtoupper(str_replace('-', '_', $api_key_variable));
        $apiKey             = $CI->input->server($key_name);
        return $apiKey;
    }
}

if (!function_exists('getSocketUrl')) {
    function getSocketUrl()
    {
        return env("APP_ENV") === "production" ? env("SOCKET_SERVER") : env("SOCKET_SERVER_DEV");
    }
}

if (!function_exists('logo_aplikasi')) {
    function logo_aplikasi()
    {
        return asset("img/app/favico.png");
    }
}

if (!function_exists('base_docker')) {
    function base_docker($path = NULL)
    {
        return "http://host.docker.internal:" . env("PORT_NGINX_CONTAINER") . "/" . $path;
    }
}

if (!function_exists('base_api')) {
    function base_api($path = NULL)
    {
        return base_docker("api/" . env("API_VERSION", "v1") . "/" . $path);
    }
}
