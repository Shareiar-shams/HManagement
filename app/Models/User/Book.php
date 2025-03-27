<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use App\Models\User\Transaction;
use App\Models\Admin\Room;
use App\Models\User;

class Book extends Model
{
    public function transactions()
    {
        return $this->hasOne(Transaction::class);
    }

    public function room()
    {
        return $this->hasOne(Room::class, 'id','room_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
