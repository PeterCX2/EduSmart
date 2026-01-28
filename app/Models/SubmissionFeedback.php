<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubmissionFeedback extends Model
{
    protected $table = "submission_feedbacks";

    protected $fillable = [
        'submission_id',
        'feedback',
    ];

    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }
}
