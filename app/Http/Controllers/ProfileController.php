<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\ApplicantProfile;
use App\Models\EmployerProfile;

class ProfileController extends Controller
{
    public function show(){
        return view('profiles.showprof', ['user' => Auth::user()]);
    }

    public function edit(){
        return view('profiles.editprof', ['user' => Auth::user()]);
    }

    public function update(Request $request){
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:50', 'unique:users,email,' . $user->id],
            'bio' => ['nullable', 'string', 'max:250'],
            'phone' => ['nullable', 'string', 'max:20'],
            'location' => ['nullable', 'string', 'max:250'],
            'education' => ['nullable', 'string', 'max:50'],
            'experience' => ['nullable', 'string', 'max:50'],
            'skills' => ['nullable', 'string', 'max:250'],
            'resume' => ['nullable', 'file', 'mimes:pdf', 'max:5120'], //maximum of 5MB for resume upload
        ]);

        // name and email live on the shared users table
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->save();

        // everything else lives on the role-specific profile table
        if($user->role === 'employer'){
            $profile = $user->employerProfile ?? new EmployerProfile(['user_id' => $user->id]);
            $profile->bio = $validated['bio'] ?? null;
            $profile->phone = $validated['phone'] ?? null;
            $profile->location = $validated['location'] ?? null;
            $profile->save();
        } else {
            $profile = $user->applicantProfile ?? new ApplicantProfile(['user_id' => $user->id]);
            $profile->bio = $validated['bio'] ?? null;
            $profile->phone = $validated['phone'] ?? null;
            $profile->location = $validated['location'] ?? null;
            $profile->education = $validated['education'] ?? null;
            $profile->experience = $validated['experience'] ?? null;
            $profile->skills = $validated['skills'] ?? null;

            if ($request->hasFile('resume')){
                if ($profile->resume_path) {
                    Storage::disk('public')->delete($profile->resume_path);
                }

                $profile->resume_path = $request->file('resume')->store('resumes', 'public');
            }

            $profile->save();
        }

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully!');
    }

    public function downloadResume(){
        $user = Auth::user();
        $profile = $user->applicantProfile;

        if(!$profile || !$profile->resume_path || !Storage::disk('public')->exists($profile->resume_path)){
            abort(404, 'Resume not found.');
        }

        $filename = str_replace(' ', '-', $user->name) . '-Resume.pdf';
        return response()->download(storage_path('app/public/' . $profile->resume_path), $filename);
    }

    public function previewResume(){
        $user = Auth::user();
        $profile = $user->applicantProfile;

        if (!$profile || !$profile->resume_path || !Storage::disk('public')->exists($profile->resume_path)){
            abort(404, 'Resume not found.');
        }

        $path = storage_path('app/public/' . $profile->resume_path);
        return response()->file($path, ['Content-Type' => 'application/pdf']);
    }

}
