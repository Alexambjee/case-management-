<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UniqueNumController extends Controller
{
    //Generate Unique Number
    function generateUniqueNum($c, $l, $u = FALSE)
    {
        if (!$u) for ($s = '', $i = 0, $z = strlen($c) - 1; $i < $l; $x = rand(0, $z), $s .= $c[$x], $i++);
        else for ($i = 0, $z = strlen($c) - 1, $s = $c[rand(0, $z)], $i = 1; $i != $l; $x = rand(0, $z), $s .= $c[$x], $s = ($s[$i] == $s[$i - 1] ? substr($s, 0, -1) : $s), $i = strlen($s));
        return $s;
    }
}
