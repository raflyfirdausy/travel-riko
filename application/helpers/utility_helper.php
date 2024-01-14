<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists("env")) {
    function env($key = "", $default = NULL)
    {
        return isset($_ENV[$key]) ? $_ENV[$key] : $default;
    }
}

if (!function_exists("uuid")) {
    function uuid()
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
    }
}

if (!function_exists("validationError")) {
    function validationError($error, $oneLine = TRUE)
    {
        $separator = "<br>";
        if ($oneLine) {
            $separator = ", ";
        }
        $message = implode($separator, array_map(
            function ($v, $k) {
                if (is_array($v)) {
                    return $k . '[]=' . implode('&' . $k . '[]=', $v);
                } else {
                    // return $k . ' : ' . $v;
                    return $v;
                }
            },
            $error,
            array_keys($error)
        ));
        return $message;
    }
}

if (!function_exists('validationError')) {
    function validationError($error)
    {
        $message = implode('<br>', array_map(
            function ($v, $k) {
                if (is_array($v)) {
                    return $k . '[]=' . implode('&' . $k . '[]=', $v);
                } else {
                    return $k . ' : ' . $v;
                }
            },
            $error,
            array_keys($error)
        ));

        return $message;
    }
}

if (!function_exists('get_external_ip')) {
    function get_external_ip()
    {
        // Batasi waktu mencoba
        $options = stream_context_create(array(
            'http' =>
            array(
                'timeout' => 2 //2 seconds
            )
        ));
        $externalContent = file_get_contents('http://checkip.dyndns.com/', false, $options);
        preg_match('/\b(?:\d{1,3}\.){3}\d{1,3}\b/', $externalContent, $m);
        $externalIp = $m[0];
        return $externalIp;
    }
}

if (!function_exists('ej')) {
    function ej($x)
    {
        echo json_encode($x);
    }
}

if (!function_exists('d')) {
    function d($x)
    {
        return die(json_encode($x));
    }
}

if (!function_exists('debuging')) {
    function debuging($x)
    {
        echo "<pre>";
        print_r($x);
        echo "</pre>";
        exit;
    }
}

if (!function_exists('currency')) {
    function currency($x)
    {
        return number_format($x, 0, ',', '.');
    }
}

//FUNCTION INI BELUM BERJALAN DENGAN BAIK
if (!function_exists('e')) {
    function e($data)
    {
        return isset($data) ? $data : "";
    }
}

if (!function_exists('generator')) {
    function generator($length = 7)
    {
        return substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    }
}

if (!function_exists('replace_lower')) {
    function replace_lower($string = "")
    {
        preg_replace("/[^A-Za-z0-9]/", "_", strtolower($string));
    }
}

if (!function_exists('ce')) {
    function ce($string = "")
    {
        return ucwords(strtolower($string));
    }
}

if (!function_exists('sc')) {
    function sc($string = "")
    {
        return ucfirst(strtolower($string));
    }
}

if (!function_exists("set")) {
    function set(&$string)
    {
        return isset($string) ? $string : FALSE;
    }
}

if (!function_exists('tanggal_tampil')) {
    function tanggal_tampil($tanggal = "")
    {
        $originalDate = $tanggal;
        $newDate = date("m/d/Y", strtotime($originalDate));
        return $newDate;
    }
}

if (!function_exists('insert_tanggal')) {
    function insert_tanggal($tanggal = "")
    {
        $newDate = date("Y-m-d", strtotime($tanggal));
        return $newDate;
    }
}

if (!function_exists('alphanumspace')) {
    function alphanumspace($string = "")
    {
        return preg_replace("/[^a-zA-Z0-9 ]+/", "", remove_duplicate_space($string));
    }
}

if (!function_exists('alphanum')) {
    function alphanum($string = "")
    {
        return preg_replace("/[^a-zA-Z0-9_]+/", "", remove_duplicate_space($string));
    }
}

if (!function_exists("remove_duplicate_space")) {
    function remove_duplicate_space($string = "")
    {
        return preg_replace('/\s+/', ' ', $string);
    }
}

if (!function_exists("dash")) {
    function dash($string = "")
    {
        return str_replace(" ", "-", $string);
    }
}

if (!function_exists("slug")) {
    function slug($string = "")
    {
        return strtolower(dash(remove_duplicate_space(alphanumspace($string))));
    }
}

if (!function_exists("remove_line_break")) {
    function remove_line_break($string = "")
    {
        return preg_replace("/\r|\n/", "", $string);
    }
}

if (!function_exists("validasi_input_artikel")) {
    function validasi_input_artikel($string = "")
    {
        return str_replace("'", "", remove_line_break($string));
    }
}

if (!function_exists('back')) {
    function back()
    {
        if (!empty($_SERVER['HTTP_REFERER'])) {
            return $_SERVER['HTTP_REFERER'];
        } else {
            return base_url();
        }
        // return base_url();
    }
}



if (!function_exists("d_success")) {
    function d_success($data)
    {
        d([
            "code"      => 200,
            "message"   => $data["message"],
            "data"      => $data["data"],
        ]);
    }
}


if (!function_exists("d_error")) {
    function d_error($data)
    {
        d([
            "code"      => 201,
            "message"   => $data["message"],
            "data"      => $data["data"],
        ]);
    }
}

if (!function_exists('Rupiah')) {
    function Rupiah($nil = 0)
    {
        $nil = $nil + 0;
        if (($nil * 100) % 100 == 0) {
            $nil = $nil . ".00";
        } elseif (($nil * 100) % 10 == 0) {
            $nil = $nil . "0";
        }
        $nil = str_replace('.', ',', $nil);
        $str1 = $nil;
        $str2 = "";
        $dot = "";
        $str = strrev($str1);
        $arr = str_split($str, 3);
        $i = 0;
        foreach ($arr as $str) {
            $str2 = $str2 . $dot . $str;
            if (strlen($str) == 3 and $i > 0) $dot = '.';
            $i++;
        }
        $rp = strrev($str2);
        if ($rp != "" and $rp > 0) {
            return "Rp $rp";
        } else {
            return "Rp 0,00";
        }
    }
}

if (!function_exists('Rupiah2')) {
    function Rupiah2($nil = 0)
    {
        $nil = $nil + 0;
        if (($nil * 100) % 100 == 0) {
            $nil = $nil . ".00";
        } elseif (($nil * 100) % 10 == 0) {
            $nil = $nil . "0";
        }
        $nil = str_replace('.', ',', $nil);
        $str1 = $nil;
        $str2 = "";
        $dot = "";
        $str = strrev($str1);
        $arr = str_split($str, 3);
        $i = 0;
        foreach ($arr as $str) {
            $str2 = $str2 . $dot . $str;
            if (strlen($str) == 3 and $i > 0) $dot = '.';
            $i++;
        }
        $rp = strrev($str2);
        if ($rp != "" and $rp > 0) {
            return "Rp.$rp";
        } else {
            return "-";
        }
    }
}

if (!function_exists('Rupiah3')) {
    function Rupiah3($nil = 0)
    {
        $nil = $nil + 0;
        if (($nil * 100) % 100 == 0) {
            $nil = $nil . ".00";
        } elseif (($nil * 100) % 10 == 0) {
            $nil = $nil . "0";
        }
        $nil = str_replace('.', ',', $nil);
        $str1 = $nil;
        $str2 = "";
        $dot = "";
        $str = strrev($str1);
        $arr = str_split($str, 3);
        $i = 0;
        foreach ($arr as $str) {
            $str2 = $str2 . $dot . $str;
            if (strlen($str) == 3 and $i > 0) $dot = '.';
            $i++;
        }
        $rp = strrev($str2);
        if ($rp != 0) {
            return "$rp";
        } else {
            return "-";
        }
    }
}

if (!function_exists('to_rupiah')) {
    function to_rupiah($inp = '')
    {
        $outp = str_replace('.', '', $inp);
        $outp = str_replace(',', '.', $outp);
        return $outp;
    }
}


if (!function_exists('template_nice_admin')) {
    function template_nice_admin($path = "")
    {
        return base_url("assets/nice_admin/$path");
    }
}

if (!function_exists('asset_ng')) {
    function asset_ng($path = "")
    {
        return base_url("assets/next_generation/$path");
    }
}

if (!function_exists("agama")) {
    function agama()
    {
        return [
            "ISLAM",
            "KRISTEN",
            "KATOLIK",
            "HINDU",
            "BUDHA",
            "KONGHUCU"
        ];
    }
}

if (!function_exists("generateAcceptFiles")) {
    function generateAcceptFiles($accept)
    {
        $mimesExplode   = explode("|", $accept);
        $mimesConfig    = get_mimes();
        $resultMime     = [];
        foreach ($mimesExplode as $me) {
            if (isset($mimesConfig[$me])) {
                if (is_array($mimesConfig[$me])) {
                    foreach ($mimesConfig[$me] as $mce) {
                        $resultMime[] = $mce;
                    }
                } else {
                    $resultMime[] = $mimesConfig[$me];
                }
            }
        }
        return implode(",", $resultMime);
    }
}

if (!function_exists("formatBytes")) {
    function formatBytes($bytes, $precision = 2)
    {
        $bytes      *= 1024;
        $suffixes   = array('B', 'KB', 'MB', 'GB', 'TB');
        $base       = log($bytes, 1024);

        return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)];
    }
}

if (!function_exists("makeReadMore")) {
    function makeReadMore($text, $length = 100)
    {
        return strlen($text) > $length ? (substr($text, 0, $length) . "...") : $text;
    }
}

if (!function_exists('setImage')) {
    function setImage($pathDirectory, $fileName, $imageOnError = NO_IMAGE)
    {
        $lokasiImage = $pathDirectory . $fileName;
        return !is_file($lokasiImage) ? $imageOnError : base_url($lokasiImage);
    }
}

if (!function_exists('getFavicon')) {
    function getFavicon()
    {
        $favicoLogo = getSetting("FAVICO_WEBSITE");
        return setImage(LOKASI_PENGATURAN, $favicoLogo, NO_IMAGE);
    }
}

if (!function_exists('getLogo')) {
    function getLogo()
    {
        $logo = getSetting("LOGO_WEBSITE");
        return setImage(LOKASI_PENGATURAN, $logo, NO_IMAGE);
    }
}

if (!function_exists('getSetting')) {
    function getSetting($key = NULL, $defaultValue = NULL)
    {
        $CI = &get_instance();
        $CI->load->model(["Setting_model"     => "setting"]);

        $data = $CI->setting->where(["key" => $key])->get();
        return $data ? $data["value"] : $defaultValue;
    }
}
