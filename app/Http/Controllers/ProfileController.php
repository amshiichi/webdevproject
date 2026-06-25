<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
class ProfileController extends Controller
{
    public function show(){
        return view('profiles.showprof', ['user' => Auth::user()]);
    }

    public function edit(){
        return view('profiles.editprof', ['user' => Auth::user()]);
    }

    public function update(Request $request){
        $user = User::find(Auth::id());
        $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:50', 'unique:users,email,' . $user->id],
            'bio' => ['nullable', 'string', 'max:250'],
            'phone' => ['nullable', 'string', 'max:20'],
            'location' => ['nullable', 'string', 'max:250'],
            'education' => ['nullable', 'string', 'max:50'],
            'experience' => ['nullable', 'string', 'max:50'],
            'skills' => ['nullable', 'string', 'max:250'],
            'resume' => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
        ]);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->bio = $request->bio ?? null;
        $user->phone = $request->phone ?? null;
        $user->location = $request->location ?? null;
        $user->education = $request->education ?? null;
        $user->experience = $request->experience ?? null;
        $user->skills = $request->skills ?? null;
        if($request->hasFile('resume')){
            if($user->resume_path){
                Storage::disk('public')->delete($user->resume_path);
            }
            $user->resume_path = $request->file('resume')->store('resumes', 'public');
        }
        $user->save();
        return redirect()->route('profile.show')->with('success', 'Profile updated successfully!');
    }

    public function downloadResume(){
        $user = Auth::user();
        if(!$user->resume_path || !Storage::disk('public')->exists($user->resume_path)){
            abort(404, 'Resume not found.');
        }
        $filename = str_replace(' ', '-', $user->name) . '-Resume.pdf';
        return response()->download(storage_path('app/public/' . $user->resume_path), $filename);
    }

    public function previewResume(){
        $user = Auth::user();
        if(!$user->resume_path || !Storage::disk('public')->exists($user->resume_path)){
            abort(404, 'Resume not found.');
        }
        $path = storage_path('app/public/' . $user->resume_path);
        return response()->file($path, ['Content-Type' => 'application/pdf']);
    }
}
