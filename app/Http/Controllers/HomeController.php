<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Job;

class HomeController extends Controller
{
    /**
    * Show all the jobs
    *
    * @return View
    */
    public function index()
    {
        $jobs = Job::sortable()->paginate(10);
        return view('jobs', ['jobs' => $jobs]);
    }
}