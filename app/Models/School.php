<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class School extends Model
{
    protected $table = "schools";

    protected $fillable = [
        'name',
    ];

    public function subjects(): HasMany
    {
        return $this->hasMany(Subject::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_schools');
    }
}
