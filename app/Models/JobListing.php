<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobListing extends Model
{
    use HasFactory;

    protected $fillable = [
        'employer_id', 
        'title', 'description', 'requirements',
        'company', 'location',
        'salary_min', 'salary_max',
        'type', 'experience_level',
        'status', 'posting_status'
    ];

    public function employer(){
        return $this->belongsTo(User::class, 'employer_id');
    }

    public function applications(){
        return $this->hasMany(Application::class, 'job_listing_id');
    }

}
