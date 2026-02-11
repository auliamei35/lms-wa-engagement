<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    protected $fillable = ['title', 'deadline'];

    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class);
    }
}