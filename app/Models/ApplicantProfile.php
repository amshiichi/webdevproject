<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicantProfile extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'bio', 'phone', 'location',
        'education', 'experience',
        'skills', 'resume_path',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
