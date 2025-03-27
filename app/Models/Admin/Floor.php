<?php

namespace App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Floor extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function rooms()
    {
        return $this->hasMany('App\Models\Admin\Room', 'floor_id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
