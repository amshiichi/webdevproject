<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    //index: Displays the applicant home page.

    // show: Views a specific job details.

    // create / store / edit / update / destroy: Handled here but restricted to Employers via middleware.

    public function index(Request $request){
        if(Auth::check() && Auth::user()->role === 'employer'){
            return redirect()->route('employer.home');
        }

        $query = JobListing::where('status', 'approved');

        //search filter
        if ($request->filled('keyword')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->keyword . '%')
                  ->orWhere('company', 'like', '%' . $request->keyword . '%');
            });
        }

        if($request->filled('location')){
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('experience_level')) {
            $query->where('experience_level', $request->experience_level);
        }

        $jobs = $query->latest()->get();

        return view('jobs.index', compact('jobs'));
    }

    //show the jobs listed by the logged in employer
    public function hub(){
        $jobs = JobListing::where('employer_id', Auth::id())->latest()->get();
        
        return view('employer.hub', compact('jobs'));
    }

    public function show($id){
        $job = JobListing::findOrFail($id);
        return view('jobs.show', compact('job'));
    }

    //crud's  restricted to employers only
    public function create(){
        $mode = 'create';
        return view('jobs.form', compact('mode'));
    }

    public function store(Request $request){
        $validated = $this->validateJob($request);

        JobListing::create([
            'employer_id' => Auth::id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'requirements' => $validated['requirements'] ?? null,
            'company' => $validated['company'],
            'location' => $validated['location'],
            'salary_min' => $validated['salary_min'] ?? null,
            'salary_max' => $validated['salary_max'] ?? null,
            'type' => $validated['type'],
            'experience_level' => $validated['experience_level'],
            'status' => 'pending' //admin must approve first (safe from job scams but can be annoying to employers)
        ]);

        return redirect()->route('jobs.index');
    }

    public function edit($id){
        $job = JobListing::findOrFail($id);

        $this->authorizeOwner($job);

        $mode = 'edit';

        return view('jobs.form', compact('mode', 'job'));
    }

    public function update(Request $request, $id){
        $job = JobListing::findOrFail($id);

        $this->authorizeOwner($job);

        $validated = $this->validateJob($request);

        $job->update($validated);

        return redirect()->route('jobs.show', $id);
    }

    public function destroy($id){
        $job = JobListing::findOrFail($id);

        $this->authorizeOwner($job);

        $job->delete();

        return redirect()->route('jobs.index');
    }

    private function validateJob(Request $request): array{
        return $request->validate([
            'title' => ['required', 'string', 'max:50'],
            'description' => ['required', 'string'],
            'requirements' => ['nullable', 'string'],
            'company' => ['required', 'string', 'max:50'],
            'location' => ['required', 'string', 'max:50'],
            'salary_min' => ['nullable', 'numeric', 'min:0'],
            'salary_max' => ['nullable', 'numeric', 'min:0'],
            'type' => ['required', 'in:full-time,part-time,contract,internship'],
            'experience_level' => ['required', 'in:entry,mid,senior'],
        ]);
    }

    private function authorizeOwner(JobListing $job): void{
        if ($job->employer_id !== Auth::id()){
            abort(403, 'Forbidden:: You are not authorized to modify this job listing.');
        }
    }
}