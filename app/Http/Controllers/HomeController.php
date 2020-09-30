<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Models\Job;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
    * Show all the jobs
    *
    * @return View
    */
    public function index(Request $request)
    {
        $query = $request->input('search');
        $jobs = $query ? Job::search($query, null, true)->sortable()->paginate(5) : Job::sortable()->paginate(10);
        return view('jobs', ['jobs' => $jobs]);
    }

    /**
     * A simple route to get the job from the API
     */
    public function refreshJobs()
    {
        $response = Http::get('https://paikat.te-palvelut.fi/tpt-api/tyopaikat?englanti=true');

        if ($response->ok()) {

            $result = $response->json()['response'];
            $jobs = $result['docs'];
            
            foreach($jobs as $job) {
                DB::table('jobs')->insert([
                    'title' => $job['otsikko'],
                    'description' => $job['kuvausteksti'],
                    'company' => $job['tyonantajanNimi'],
                    'created_at' => new Carbon($job['ilmoituspaivamaara']),
                ]);
            } 
        }
        return redirect()->action([HomeController::class, 'index']);
    }
}