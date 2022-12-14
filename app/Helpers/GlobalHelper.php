<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Model;
use Auth;

class GlobalHelper extends Model
{
    public static function get_guard()
    {
        if (Auth::guard('admin')->check()) {
            return "admin";
        } else if (Auth::guard('web')->check()) {
            return "user";
        } else {
            return null;
        }
    }
}
