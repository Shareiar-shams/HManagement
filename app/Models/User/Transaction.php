<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use App\Models\User\Book;
use App\Models\User;

class Transaction extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
