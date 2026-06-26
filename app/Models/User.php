<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name', 'email', 'role',
        'account_status',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function applicantProfile(){
        return $this->hasOne(ApplicantProfile::class, 'user_id');
    }

    public function employerProfile(){
        return $this->hasOne(EmployerProfile::class, 'user_id');
    }

    public function adminProfile(){
        return $this->hasOne(AdminProfile::class, 'user_id');
    }

    public function jobListings(){
        return $this->hasMany(JobListing::class, 'employer_id');
    }

    public function applications(){
        return $this->hasMany(Application::class, 'applicant_id');
    }

    public function alerts(){
        return $this->hasMany(Notification::class, 'user_id');
    }

    public function getProfileAttribute(){
        return match($this->role){
            'applicant' => $this->applicantProfile,
            'employer' => $this->employerProfile,
            'admin' => $this->adminProfile,
            default => null,
        };
    }
}
