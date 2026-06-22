<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    private function applicantRecords(): array
    {
        return [
            1 => (object) [
                'id' => 1,
                'name' => 'Juan Dela Cruz',
                'email' => 'juan@email.com',
                'phone' => '0917 123 4567',
                'location' => 'Manila, Philippines',
                'experience' => '3 years',
                'education' => 'BS Information Technology',
                'summary' => 'Frontend-focused developer with experience in Laravel, Vue, and responsive UI builds.',
                'skills' => ['Laravel', 'Vue.js', 'JavaScript', 'HTML/CSS'],
                'resume_sections' => [
                    'Recent role: Frontend Developer at Pixel Labs',
                    'Built applicant dashboards and admin tools',
                    'Portfolio: clean component-based interfaces and API integration',
                ],
            ],
            2 => (object) [
                'id' => 2,
                'name' => 'Maria Santos',
                'email' => 'maria@email.com',
                'phone' => '0918 234 5678',
                'location' => 'Quezon City, Philippines',
                'experience' => '4 years',
                'education' => 'BS Computer Science',
                'summary' => 'Full-stack applicant with strong product thinking and experience shipping internal tools.',
                'skills' => ['PHP', 'Laravel', 'MySQL', 'Figma'],
                'resume_sections' => [
                    'Recent role: Software Engineer at BrightApps',
                    'Worked on booking, HR, and customer portals',
                    'Strong background in stakeholder collaboration',
                ],
            ],
            3 => (object) [
                'id' => 3,
                'name' => 'Paolo Reyes',
                'email' => 'paolo@email.com',
                'phone' => '0999 345 6789',
                'location' => 'Cebu City, Philippines',
                'experience' => '5 years',
                'education' => 'BS Computer Engineering',
                'summary' => 'Senior web developer with a mix of frontend polish and backend delivery.',
                'skills' => ['React', 'Laravel', 'REST APIs', 'Tailwind CSS'],
                'resume_sections' => [
                    'Recent role: Senior Developer at Northstar',
                    'Led UI redesigns and release planning',
                    'Delivered production-ready features end-to-end',
                ],
            ],
        ];
    }

    private function applicantResumeText(object $applicant, object $job): string
    {
        $skills = implode(', ', $applicant->skills);
        $sections = implode("\n- ", $applicant->resume_sections);

        return trim(<<<TEXT
Resume for {$applicant->name}

Email: {$applicant->email}
Phone: {$applicant->phone}
Location: {$applicant->location}
Experience: {$applicant->experience}
Education: {$applicant->education}
Applied Role: {$job->title}
Company: {$job->company}

Summary:
{$applicant->summary}

Skills:
{$skills}

Resume Highlights:
- {$sections}
TEXT);
    }
    // applications: Lists applied jobs (for Applicants) OR lists applicants for a job (for Employers).

    // store: Submitting an application (Applicant).

    // update: Changing the status of an application (Employer).

    public function index()
    {
        return session('account_role') === 'employer'
            ? view('employer.dashboard')
            : view('applications.applications');
    }
    public function store(Request $request, $id) { return redirect()->route('applications.index'); }
    public function review($id)
    {
        $job = (object) [
            'id' => $id,
            'title' => 'Frontend Developer',
            'company' => 'TechCorp',
            'status' => 'screening',
            'applications_count' => 18,
            'shortlisted_count' => 5,
            'posted_at' => 'Jun 10, 2026',
        ];

        $applicants = [
            (object) ['id' => 1, 'name' => 'Juan Dela Cruz', 'email' => 'juan@email.com', 'experience' => '3 years', 'status' => 'pending'],
            (object) ['id' => 2, 'name' => 'Maria Santos', 'email' => 'maria@email.com', 'experience' => '4 years', 'status' => 'screening'],
            (object) ['id' => 3, 'name' => 'Paolo Reyes', 'email' => 'paolo@email.com', 'experience' => '5 years', 'status' => 'closed'],
        ];

        return view('employer.review', compact('job', 'applicants'));
    }

    public function applicant($jobId, $applicantId)
    {
        $job = (object) [
            'id' => $jobId,
            'title' => 'Frontend Developer',
            'company' => 'TechCorp',
        ];

        $applicants = $this->applicantRecords();

        abort_unless(isset($applicants[$applicantId]), 404);

        $applicant = $applicants[$applicantId];
        $resumeText = $this->applicantResumeText($applicant, $job);

        return view('applications.applicant-detail', compact('job', 'applicant', 'resumeText'));
    }

    public function resume($jobId, $applicantId)
    {
        $job = (object) [
            'id' => $jobId,
            'title' => 'Frontend Developer',
            'company' => 'TechCorp',
        ];

        $applicants = $this->applicantRecords();
        abort_unless(isset($applicants[$applicantId]), 404);

        $applicant = $applicants[$applicantId];
        $resumeText = $this->applicantResumeText($applicant, $job);
        $filename = str_replace(' ', '-', $applicant->name) . '-Resume.txt';

        return response()->streamDownload(function () use ($resumeText) {
            echo $resumeText;
        }, $filename, [
            'Content-Type' => 'text/plain; charset=UTF-8',
        ]);
    }
    public function updateStatus(Request $request, $id) { return redirect()->route('applications.index'); }
}