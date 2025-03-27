<?php

namespace App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $fillable = ['parent_id', 'name','slug'];


    public function Rooms()
    {
        return $this->hasMany('App\Models\Admin\Room', 'category_id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
