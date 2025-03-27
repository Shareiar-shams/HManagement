<?php

namespace App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Category;

class Room extends Model
{
    use HasFactory;

    protected $fillable = ['name','slug','SKU','featured_image','gallery_image','short_description','description','floor_id','category_id','tags','adult_capacity','child_capacity','booked','price','special_price','status'];


    public function getRouteKeyName()
    {
        return 'slug';
    }


    //Primary Key

    public $primaryKey = 'id';


    //Timestamps

    public $timestamps = true;
    
    public function floor() {
        return $this->belongsTo('App\Models\Admin\Floor');
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }


    public function images()
    {
        return $this->hasMany('App\Models\Admin\RoomImage');
    }
}
