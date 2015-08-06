<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class PanelController extends Controller
{
    public function index(){
        return view('admin.panel');
    }
}