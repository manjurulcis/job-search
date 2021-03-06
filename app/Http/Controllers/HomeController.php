<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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
        $format = $request->input('format');
        $jobs = $query 
            ? Job::search($query, null, true)->sortable()->paginate(5) 
            : Job::sortable()->paginate(10);

        if ($format == 'JSON') return response()->json($jobs);    
        return view('jobs', ['jobs' => $jobs]);
    }

    /**
     * A simple route to get the job from the API
     */
    public function refresh_jobs()
    {
        $response = Http::get('https://paikat.te-palvelut.fi/tpt-api/tyopaikat?englanti=true');

        if ($response->ok()) {

            $result = $response->json()['response'];
            $jobs = $result['docs'];
            
            foreach($jobs as $job) {
                $job_key_renamed = [
                    'title' => $job['otsikko'],
                    'description' => $job['kuvausteksti'],
                    'company' => $job['tyonantajanNimi'],
                    'created_at' => new Carbon($job['ilmoituspaivamaara']),
                    'update_at' => new Carbon(now())
                ];
                Job::create($job_key_renamed);
            } 
        }
        return redirect()->action([HomeController::class, 'index']);
    }

    /**
     * Job list using vue
     */
    public function job_list_using_vue()
    {
        return view('jobswithvue', []);
    }
}