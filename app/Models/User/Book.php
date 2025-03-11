<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use App\Models\User\Transaction;
use App\Models\Admin\Product;
use App\Models\User;

class Book extends Model
{
    public function transactions()
    {
        return $this->hasOne(Transaction::class);
    }

    public function product()
    {
        return $this->hasOne(Product::class, 'id','product_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
