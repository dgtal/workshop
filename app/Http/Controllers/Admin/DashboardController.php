<?php

namespace App\Http\Controllers\Admin;
use Backpack\Base\app\Http\Controllers\Controller;

class DashboardController extends Controller
{
    protected $data = []; // the information we send to the view

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['title'] = trans('backpack::base.dashboard'); // set the page title

        return view('backpack::dashboard', $this->data);
    }
}