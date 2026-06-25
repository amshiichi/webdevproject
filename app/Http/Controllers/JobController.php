<?php
namespace App\Http\Controllers;
use App\Models\JobListing;
use App\Models\User;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class JobController extends Controller
{
    public function publicJobs(Request $request){
        $query = JobListing::where('status', 'approved');
        if($request->filled('q')){
            $query->where(function($q) use ($request){
                $q->where('title', 'like', '%' . $request->q . '%')
                ->orWhere('company', 'like', '%' . $request->q . '%')
                ->orWhere('location', 'like', '%' . $request->q . '%')
                ->orWhere('type', 'like', '%' . $request->q . '%');
            });
        }
        if($request->filled('location')){
            $query->where('location', 'like', '%' . $request->location . '%');
        }
        if($request->filled('type')){
            $query->where('type', $request->type);
        }
        if($request->filled('experience_level')){
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
        if($request->filled('q')){
            $query->where(function($q) use ($request){
                $q->where('title', 'like', '%' . $request->q . '%')
                  ->orWhere('company', 'like', '%' . $request->q . '%');
            });
        }
        if($request->filled('location')){
            $query->where('location', 'like', '%' . $request->location . '%');
        }
        if($request->filled('type')){
            $query->where('type', $request->type);
        }
        if($request->filled('experience_level')){
            $query->where('experience_level', $request->experience_level);
        }
        $jobs = $query->latest()->get();
        $applicationsCount = Application::where('applicant_id', Auth::id())->count();
        $pendingCount = Application::where('applicant_id', Auth::id())->where('status', 'pending')->count();
        $interviewCount = Application::where('applicant_id', Auth::id())->where('status', 'interview')->count();
        $availableJobs = $jobs->count();
        return view('jobs.applicant', compact('jobs', 'applicationsCount', 'pendingCount', 'interviewCount', 'availableJobs'));
    }

    public function index(Request $request){
        if(Auth::check() && Auth::user()->role === 'employer'){
            return redirect()->route('employer.home');
        }
        $query = JobListing::where('status', 'approved');
        if($request->filled('keyword')){
            $query->where(function($q) use ($request){
                $q->where('title', 'like', '%' . $request->keyword . '%')
                  ->orWhere('company', 'like', '%' . $request->keyword . '%');
            });
        }
        if($request->filled('location')){
            $query->where('location', 'like', '%' . $request->location . '%');
        }
        if($request->filled('type')){
            $query->where('type', $request->type);
        }
        $jobs = $query->latest()->get();
        if(Auth::check() && Auth::user()->role === 'applicant'){
            $user = User::find(Auth::id());
            $applicationsCount = Application::where('applicant_id', $user->id)->count();
            $interviewCount = Application::where('applicant_id', $user->id)->where('status', 'interview')->count();
            $notificationCount = $user->alerts()->count();
            $recommended = JobListing::where('status', 'approved')->inRandomOrder()->take(rand(1, 2))->get();
            return view('applicant.home', compact('jobs', 'applicationsCount', 'interviewCount', 'notificationCount', 'recommended'));
        }
        return view('jobs.index', compact('jobs'));
    }

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

    public function create(){
        $mode = 'create';
        return view('jobs.form', compact('mode'));
    }

    public function store(Request $request){
        $request->validate([
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
        JobListing::create([
            'employer_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'requirements' => $request->requirements ?? null,
            'company' => $request->company,
            'location' => $request->location,
            'salary_min' => $request->salary_min ?? null,
            'salary_max' => $request->salary_max ?? null,
            'type' => $request->type,
            'experience_level' => $request->experience_level,
            'status' => 'pending'
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
        $request->validate([
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
        $job->update([
            'title' => $request->title,
            'description' => $request->description,
            'requirements' => $request->requirements ?? null,
            'company' => $request->company,
            'location' => $request->location,
            'salary_min' => $request->salary_min ?? null,
            'salary_max' => $request->salary_max ?? null,
            'type' => $request->type,
            'experience_level' => $request->experience_level,
        ]);
        return redirect()->route('jobs.hub')->with('success', 'Job updated successfully.');
    }

    public function destroy($id){
        $job = JobListing::findOrFail($id);
        $this->authorizeOwner($job);
        $job->delete();
        return redirect()->route('jobs.hub')->with('success', 'Job deleted successfully.');
    }

    private function authorizeOwner(JobListing $job){
        if($job->employer_id !== Auth::id()){
            abort(403, 'Forbidden: You are not authorized to modify this job listing.');
        }
    }
}
