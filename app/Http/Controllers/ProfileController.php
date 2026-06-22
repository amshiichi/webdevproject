<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    //show: Displays the profile/resume.

    // edit / update: Editing profile details or uploading a resume file.

    public function show() { return view('profiles.showprof'); }
    public function edit() { return view('profiles.editprof'); }
    public function update(Request $request)
    {
        if ($request->hasFile('resume')) {
            $path = $request->file('resume')->store('resumes', 'public');

            session([
                'resume_path' => $path,
                'resume_name' => $request->file('resume')->getClientOriginalName(),
                'resume_url' => Storage::disk('public')->url($path),
            ]);
        }

        return redirect()->route('profile.show');
    }
}