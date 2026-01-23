<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    // Allows these fields to be filled by a form
    protected $fillable = ['title', 'description', 'manager_id'];

    // Link back to the User (Manager)
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }
}
