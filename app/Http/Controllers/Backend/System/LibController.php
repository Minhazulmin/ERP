<?php

namespace App\Http\Controllers\Backend\System;

use Auth;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;

class LibController extends Controller
{
    private $variable = [];

    private function index()
    {
        return [
            'variable' => $this->variable
        ];
    }

    /**
     * SYSTEMS DATA RETURN
     */ 
    public function systems()
    {
        return [
            "global"        => $this->index(),
            "profile"       => Auth::guard('admin')->user()->profile ?? '',
            "permissions"   => App::make('premitedMenuArr'),
            "site"          => App::make('siteSettingObj'),
            "menus"         => App::make('sideMenus')
        ];
    }
}
