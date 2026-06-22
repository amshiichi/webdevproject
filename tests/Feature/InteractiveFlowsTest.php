<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\JobListing;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InteractiveFlowsTest extends TestCase
{
    use RefreshDatabase;

    public function test_applicant_pages_render()
    {
        $applicant = User::factory()->create(['role' => 'applicant', 'account_status' => 'approved']);

        $this->actingAs($applicant)
            ->get(route('profile.edit'))
            ->assertStatus(200);

        $this->actingAs($applicant)
            ->get(route('applications.index'))
            ->assertStatus(200);
    }

    public function test_employer_pages_render_and_crud_forms()
    {
        $employer = User::factory()->create(['role' => 'employer', 'account_status' => 'approved']);

        $this->actingAs($employer)
            ->get(route('jobs.hub'))
            ->assertStatus(200);

        $this->actingAs($employer)
            ->get(route('jobs.create'))
            ->assertStatus(200);
    }

    public function test_admin_pages_render()
    {
        $admin = User::factory()->create(['role' => 'admin', 'account_status' => 'approved']);

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertStatus(200);
    }
}
