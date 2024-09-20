<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller {
    
    /**
     * Display dashbnoard of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(){
        $title = "Dashboard";
        $description = "Some description for the page";
        return view('pages.dashboard.dashboard',compact('title','description'));
    }
}