<?php
namespace App\Http\Controllers;
use App\Models\JobListing;
use App\Models\Notification;
use Illuminate\Http\Request;
class AdminController extends Controller
{
    public function index(){
        $pendingJobs = JobListing::where('status', 'pending')->latest()->get();
        $approvedJobs = JobListing::where('status', 'approved')->latest()->get();
        $rejectedJobs = JobListing::where('status', 'rejected')->latest()->get();
        return view('admin.dashboard', compact('pendingJobs', 'approvedJobs', 'rejectedJobs'));
    }

    public function moderateJob(Request $request, $id){
        $job = JobListing::findOrFail($id);
        $request->validate([
            'decision' => ['required', 'in:approved,rejected']
        ]);
        $job->update(['status' => $request->decision]);
        Notification::create([
            'user_id' => $job->employer_id,
            'message' => "Your job posting \"{$job->title}\" was {$request->decision} by an admin.",
            'link' => route('jobs.show', $job->id)
        ]);
        return redirect()->route('admin.dashboard');
    }
}
