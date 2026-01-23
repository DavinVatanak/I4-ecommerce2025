<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    // Allow mass assignment for these fields
    protected $fillable = ['title', 'status', 'project_id', 'user_id'];

    /**
     * Get the project that owns the task.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the staff user assigned to the task.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
