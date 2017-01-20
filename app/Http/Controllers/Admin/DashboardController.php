<?php

namespace App\Http\Controllers\Admin;
use Backpack\Base\app\Http\Controllers\Controller;

class DashboardController extends Controller
{
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
        $data = [];
        // $this->data['stats']['customers'] = (new Customer)

        return view('backpack::dashboard', $data);
    }
}