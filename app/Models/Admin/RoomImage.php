<?php

namespace App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomImage extends Model
{
    use HasFactory;
    protected $fillable = ['room_id', 'image_path'];
    public function product()
    {
        return $this->belongsTo('App\Models\Admin\Room','room_id');
    }
}
