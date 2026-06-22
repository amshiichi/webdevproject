<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use App\Models\Notification;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // admin: The master moderation dashboard.

    // update: Approving/rejecting jobs or moderating users.

    public function index() { return view('admin.dashboard'); }
    public function moderateJob(Request $request, $id){
        $job = JobListing::findOrFail($id);

        $request->validate(['decision' => ['required', 'in:approved,rejected']]);

        $job->update(['status' => $request->decision]);

        Notification::create([
            'user_id' => $job->employer_id,
            'message' => "Your job posting \"{$job->title}\" was {$request->decision} by an admin.",
            'link' => route('jobs.show', $job->id)
        ]);
        
        return redirect()->route('admin.dashboard'); }
}