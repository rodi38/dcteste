<?php

namespace App\Common;

class Helpers
{

    public static function redirectWith($type, $address, $message)
    {
        return redirect()->route($address)->with($type, $message);
    }
}
