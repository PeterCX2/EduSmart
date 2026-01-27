<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        'name',
        'description',
        'school_id'
    ];

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
}
