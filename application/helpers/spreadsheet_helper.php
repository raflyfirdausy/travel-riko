<?php

if (!function_exists('getColumnFromNumber')) {
    function getColumnFromNumber($num)
    {
        //? 1 == A , 2 == B , 27 == AA
        $numeric = ($num - 1) % 26;
        $letter = chr(65 + $numeric);
        $num2 = intval(($num - 1) / 26);
        if ($num2 > 0) {
            return getColumnFromNumber($num2) . $letter;
        } else {
            return $letter;
        }
    }
}

