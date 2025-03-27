<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Restaurant extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
