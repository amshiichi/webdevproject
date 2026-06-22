<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JobController extends Controller
{
    //index: Displays the applicant home page.

    // show: Views a specific job details.

    // create / store / edit / update / destroy: Handled here but restricted to Employers via middleware.

    private function existingJob($id): object
    {
        return (object) [
            'id' => $id,
            'title' => 'Senior Frontend Developer',
            'location' => 'Manila, PH',
            'type' => 'full-time',
            'salary' => '₱40,000 – ₱60,000',
            'description' => 'Lead the frontend experience for our product team and ship polished, responsive interfaces.',
            'requirements' => '3+ years of frontend experience, strong HTML/CSS/JavaScript, Laravel or Vue preferred.',
        ];
    }

    private function existingJobs(): array
    {
        // Demo data representing employer-created jobs. Replace with DB query when available.
        return [
            (object) ['id' => 1, 'title' => 'Senior Frontend Developer', 'created_at' => '2026-06-01'],
            (object) ['id' => 2, 'title' => 'Backend Engineer', 'created_at' => '2026-05-18'],
            (object) ['id' => 3, 'title' => 'Product Designer', 'created_at' => '2026-04-22'],
        ];
    }

    public function hub()
    {
        $jobs = $this->existingJobs();
        return view('employer.hub', ['jobs' => $jobs]);
    }

    public function index()
    {
        return session('account_role') === 'employer'
            ? view('employer.home')
            : view('applicant.home');
    }
    public function create() { return view('jobs.form'); }
    public function store(Request $request) { return redirect()->route('jobs.index'); }
    public function show($id)
    {
        if (!session()->has('account_role')) {
            return redirect()->route('login');
        }

        return view('jobs.show');
    }
    public function edit($id) { return view('jobs.form', ['job' => $this->existingJob($id)]); }
    public function update(Request $request, $id) { return redirect()->route('jobs.show', $id); }
    public function destroy($id) { return redirect()->route('jobs.index'); }
}