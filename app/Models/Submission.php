<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $fillable = [
        'assignment_id',
        'user_id',
        'files',
        'submitted_at',
        'status',
        'grade',
    ];

    protected $casts = [
        'files' => 'array',
        'submitted_at' => 'date',
        'grade' => 'decimal:2',
    ];

    protected $appends = ['file_urls'];

    public function getFileUrlsAttribute()
    {
        return collect($this->files)->map(function ($file) {
            return [
                'url' => asset('storage/' . $file['path']),
                'original_name' => $file['original_name'],
            ];
        });
    }


     public function assignment(){
        return $this->belongsTo(Assignment::class);
    }


    public function user(){
        return $this->belongsTo(User::class);
    }
}
