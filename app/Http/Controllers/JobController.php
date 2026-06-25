<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use App\Models\User;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    //publicJobs: Displays approved jobs for public browsing (unauthenticated or non-applicants)
    
    //crud is handled here but restricted to employers only via middleware

    public function publicJobs(Request $request){
        $query = JobListing::where('status', 'approved');

        //search filter
        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->q . '%')
                  ->orWhere('company', 'like', '%' . $request->q . '%');
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

        return view('jobs.public', compact('jobs'));
    }

    public function applicantJobs(Request $request){
        if(Auth::check() && Auth::user()->role !== 'applicant'){
            abort(403, 'Forbidden: Only applicants can access this page.');
        }

        $query = JobListing::where('status', 'approved');

        //search filter
        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->q . '%')
                  ->orWhere('company', 'like', '%' . $request->q . '%');
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

        $applicationsCount = Application::where(
            'applicant_id',
            Auth::id()
        )->count();

        $pendingCount = Application::where(
            'applicant_id',
            Auth::id()
        )->where(
            'status',
            'pending'
        )->count();

        $interviewCount = Application::where(
            'applicant_id',
            Auth::id()
        )->where(
            'status',
            'interview'
        )->count();

        $availableJobs = $jobs->count();

        return view('jobs.applicant', compact('jobs','applicationsCount','pendingCount','interviewCount','availableJobs'));
    }

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

        if ($request->filled('type')){
            $query->where('type', $request->type);
        }

        $jobs = $query->latest()->get();

        if(Auth::check() && Auth::user()->role === 'applicant'){
            /** @var User $user */
            $user = Auth::user();
            $applications = $user->applications()->with('jobListing')->latest()->get();
            $applicationsCount = $applications->count();
            $interviewCount = $applications->where('status', 'interview')->count();
            $notificationCount = $user->alerts()->count();

            $recommended = JobListing::where('status', 'approved')->inRandomOrder()->take(rand(1, 2))->get();
            return view('applicant.home', compact('jobs', 'applicationsCount', 'interviewCount', 'notificationCount', 'recommended'));
        }

        return view('jobs.index', compact('jobs'));
    }

    //show the jobs listed by the logged in employer
    public function hub(){
        $jobs = JobListing::where('employer_id', Auth::id())->latest()->get();
        
        return view('employer.hub', compact('jobs'));
    }

    public function employerHome(){
        $user = Auth::user();
        $jobIds = JobListing::where('employer_id', $user->id)->pluck('id');

        $totalJobs = $jobIds->count();
        $pendingJobs = JobListing::whereIn('id', $jobIds)->where('status', 'pending')->count();
        $approvedJobs = JobListing::whereIn('id', $jobIds)->where('status', 'approved')->count();
        $applications = Application::whereIn('job_listing_id', $jobIds)->count();
        $pendingApplications = Application::whereIn('job_listing_id', $jobIds)->where('status', 'pending')->count();

        return view('employer.home', compact('totalJobs', 'pendingJobs', 'approvedJobs', 'applications', 'pendingApplications'));
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

        return redirect()->route('jobs.hub')->with('success', 'Job posted and awaiting admin approval.');
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

        return redirect()->route('jobs.hub')->with('success', 'Job updated successfully.');
    }

    public function destroy($id){
        $job = JobListing::findOrFail($id);

        $this->authorizeOwner($job);

        $job->delete();

        return redirect()->route('jobs.hub')->with('success', 'Job deleted successfully.');
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