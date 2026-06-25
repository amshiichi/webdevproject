<?php
namespace App\Http\Controllers;
use App\Models\Application;
use App\Models\JobListing;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
class ApplicationController extends Controller
{
    public function index(){
        $user = Auth::user();
        if($user->role === 'employer'){
            $jobs = JobListing::where('employer_id', $user->id)
                ->withCount('applications')
                ->latest()
                ->get();
            $totalApplications = $jobs->sum('applications_count');
            $shortlistedCount = Application::whereIn('job_listing_id', $jobs->pluck('id'))
                ->where('status', 'interview')
                ->count();
            $hiredCount = Application::whereIn('job_listing_id', $jobs->pluck('id'))
                ->where('status', 'hired')
                ->count();
            return view('employer.dashboard', compact('jobs', 'totalApplications', 'shortlistedCount', 'hiredCount'));
        }
        $applications = Application::where('applicant_id', $user->id)
            ->with('jobListing')
            ->latest()
            ->get();
        return view('applications.applications', compact('applications'));
    }

    public function store(Request $request, $id){
        $job = JobListing::findOrFail($id);
        $user = Auth::user();
        if($user->role !== 'applicant'){
            abort(403, 'Forbidden: Only applicants can apply to the jobs posted.');
        }
        if(!$user->resume_path){
            return back()->withErrors(['resume' => 'Please upload a resume to your profile before applying.']);
        }
        $alreadyApplied = Application::where('applicant_id', $user->id)
            ->where('job_listing_id', $job->id)
            ->exists();
        if($alreadyApplied){
            return back()->withErrors(['application' => 'You have already applied to this job.']);
        }
        Application::create([
            'applicant_id' => $user->id,
            'job_listing_id' => $job->id,
            'status' => 'pending'
        ]);
        Notification::create([
            'user_id' => $job->employer_id,
            'message' => "{$user->name} applied to your job posting \"{$job->title}\".",
            'link' => route('applications.review', $job->id)
        ]);
        return redirect()->route('applications.index');
    }

    public function review($id){
        $job = JobListing::withCount('applications')->findOrFail($id);
        $this->authorizeEmployerOwnsJob($job);
        $shortlistedCount = Application::where('job_listing_id', $job->id)
            ->where('status', 'interview')
            ->count();
        $applications = Application::where('job_listing_id', $job->id)
            ->with('applicant')
            ->latest()
            ->get();
        return view('employer.review', compact('job', 'applications', 'shortlistedCount'));
    }

    public function applicant($jobId, $applicantId){
        $job = JobListing::findOrFail($jobId);
        $this->authorizeEmployerOwnsJob($job);
        $applicant = User::where('id', $applicantId)->where('role', 'applicant')->firstOrFail();
        $application = Application::where('job_listing_id', $job->id)
            ->where('applicant_id', $applicant->id)
            ->firstOrFail();
        return view('applications.applicant-detail', compact('job', 'applicant', 'application'));
    }

    public function resume($jobId, $applicantId){
        $job = JobListing::findOrFail($jobId);
        $this->authorizeEmployerOwnsJob($job);
        $applicant = User::where('id', $applicantId)->where('role', 'applicant')->firstOrFail();
        if(!$applicant->resume_path || !Storage::disk('public')->exists($applicant->resume_path)){
            abort(404, 'Resume not found.');
        }
        $filename = str_replace(' ', '-', $applicant->name) . '-Resume.pdf';
        return response()->download(storage_path('app/public/' . $applicant->resume_path), $filename);
    }

    public function previewResume($jobId, $applicantId){
        $job = JobListing::findOrFail($jobId);
        $this->authorizeEmployerOwnsJob($job);
        $applicant = User::where('id', $applicantId)->where('role', 'applicant')->firstOrFail();
        if(!$applicant->resume_path || !Storage::disk('public')->exists($applicant->resume_path)){
            abort(404, 'Resume not found.');
        }
        $path = storage_path('app/public/' . $applicant->resume_path);
        return response()->file($path, ['Content-Type' => 'application/pdf']);
    }

    public function updateStatus(Request $request, $id){
        $job = JobListing::findOrFail($id);
        $this->authorizeEmployerOwnsJob($job);
        $request->validate([
            'status' => ['required', 'in:live,screening,closed']
        ]);
        $job->update(['posting_status' => $request->status]);
        return redirect()->route('applications.review', $job->id)->with('success', 'Posting status updated.');
    }

    public function updateApplicantStatus(Request $request, $jobId, $applicantId){
        $job = JobListing::findOrFail($jobId);
        $this->authorizeEmployerOwnsJob($job);
        $application = Application::where('job_listing_id', $jobId)
            ->where('applicant_id', $applicantId)
            ->firstOrFail();
        $request->validate([
            'status' => ['required', 'in:pending,interview,hired,rejected']
        ]);
        if($application->status === $request->status){
            return back()->with('success', 'No changes made — status is already ' . ucfirst($request->status) . '.');
        }
        $application->update(['status' => $request->status]);
        Notification::create([
            'user_id' => $application->applicant_id,
            'message' => "Your application for \"{$job->title}\" was updated to: " . ucfirst($request->status),
            'link' => route('applications.index')
        ]);
        return back()->with('success', 'Applicant status updated.');
    }

    public function emailApplicant(Request $request, $jobId, $applicantId){
        $job = JobListing::findOrFail($jobId);
        $this->authorizeEmployerOwnsJob($job);
        $applicant = User::where('id', $applicantId)->where('role', 'applicant')->firstOrFail();
        $employer = Auth::user();
        $request->validate([
            'subject' => ['required', 'string', 'max:150'],
            'body'    => ['required', 'string'],
        ]);
        Mail::raw($request->body, function($message) use ($request, $applicant, $employer){
            $message->to($applicant->email, $applicant->name)
                    ->subject($request->subject)
                    ->from($employer->email, $employer->name);
        });
        Notification::create([
            'user_id' => $applicant->id,
            'message' => json_encode([
                'type'    => 'email',
                'preview' => "Email from {$employer->name} regarding \"{$job->title}\"",
                'subject' => $request->subject,
                'from'    => $employer->name,
                'body'    => $request->body,
            ]),
            'link' => null,
        ]);
        return back()->with('success', 'Email sent to ' . $applicant->name . '.');
    }

    private function authorizeEmployerOwnsJob(JobListing $job){
        if($job->employer_id !== Auth::id()){
            abort(403, 'Forbidden: You are not authorized to view this.');
        }
    }
}
