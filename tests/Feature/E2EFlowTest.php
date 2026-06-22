<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\JobListing;
use App\Models\Application;
use App\Models\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class E2EFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_full_employer_applicant_admin_flow()
    {
        Storage::fake('public');

        // create users
        $admin = User::factory()->create(['role' => 'admin', 'account_status' => 'approved']);
        $employer = User::factory()->create(['role' => 'employer', 'account_status' => 'approved']);
        $applicant = User::factory()->create(['role' => 'applicant', 'account_status' => 'approved']);

        // Employer creates a job
        $this->actingAs($employer)
            ->post(route('jobs.store'), [
                'title' => 'Senior Developer',
                'description' => 'Do great things',
                'company' => 'Acme',
                'location' => 'Manila',
                'type' => 'full-time',
                'experience_level' => 'senior'
            ])
            ->assertRedirect(route('jobs.hub'));

        $job = JobListing::first();
        $this->assertNotNull($job);

        // Admin approves the job
        $this->actingAs($admin)
            ->post(route('admin.jobs.moderate', $job->id), ['decision' => 'approved'])
            ->assertRedirect(route('admin.dashboard'));

        $this->assertDatabaseHas('job_listings', ['id' => $job->id, 'status' => 'approved']);

        // Applicant uploads resume
        $this->actingAs($applicant);
        $file = UploadedFile::fake()->create('resume.pdf', 100, 'application/pdf');

        $this->post(route('profile.update'), [
            'name' => $applicant->name,
            'email' => $applicant->email,
            'resume' => $file,
        ])->assertRedirect(route('profile.show'));

        $applicant->refresh();
        $this->assertNotNull($applicant->resume_path);
        Storage::disk('public')->assertExists($applicant->resume_path);

        // Applicant applies to the job
        $this->actingAs($applicant)
            ->post(route('applications.store', $job->id))
            ->assertRedirect(route('applications.index'));

        $this->assertDatabaseHas('applications', ['applicant_id' => $applicant->id, 'job_listing_id' => $job->id]);

        // Employer reviews applicants and updates status
        $application = Application::first();

        $this->actingAs($employer)
            ->post(route('applications.applicant.updateStatus', ['jobId' => $job->id, 'applicantId' => $applicant->id]), ['status' => 'interview'])
            ->assertSessionHas('success');

        $this->assertDatabaseHas('applications', ['id' => $application->id, 'status' => 'interview']);

        // Ensure notifications were created
        $this->assertDatabaseHas('notifications', ['user_id' => $employer->id]);
        $this->assertDatabaseHas('notifications', ['user_id' => $applicant->id]);
    }
}
