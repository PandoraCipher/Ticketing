<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Models\Department;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function index(){
        $statuses = Status::get();
        $categories = Category::get();
        $departments = Department::all();
        return view('settings.adminSetting', compact('statuses', 'categories', 'departments'));
    }

    public function show(){

        return view('settings.adminSetting');

    }
}
