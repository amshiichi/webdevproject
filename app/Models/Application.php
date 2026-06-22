<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model{
    use HasFactory;

    protected $fillable = ['applicant_id', 'job_listing_id', 'status'];

    public function applicant(){
        return $this->belongsTo(User::class, 'applicant_id');
    }

    public function jobListing(){
        return $this->belongsTo(JobListing::class, 'job_listing_id');
    }
}

