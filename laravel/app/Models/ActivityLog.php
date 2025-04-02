<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = ['user_id', 'date', 'steps', 'distance_km', 'active_minutes'];
    //

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
