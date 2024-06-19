<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function index(){
        $statuses = Status::get();
        return view('settings.adminSetting', compact('statuses'));
    }

    public function show(){

        return view('settings.adminSetting');

    }
}
