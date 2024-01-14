<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists("nice")) {
    function nice($path = NULL)
    {
        return base_url("assets/nice/$path");
    }
}

if (!function_exists("great")) {
    function great($path = NULL)
    {
        return nice($path);
    }
}
