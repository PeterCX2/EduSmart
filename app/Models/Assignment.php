<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Assignment extends Model
{
    protected $table = "assignments";

    protected $fillable = [
        'name',
        'description',
        'subject_id',
        'deadline',
        'created_by'
    ];

    public function submissions(): HasMany {
        return $this->hasMany(Submission::class);
    }

    public function subject(): BelongsTo {
        return $this->belongsTo(Subject::class);
    }
}
