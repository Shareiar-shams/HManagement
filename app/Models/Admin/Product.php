<?php

namespace App\Models\Admin;

use App\Models\Admin\Attribute;
use App\Models\Admin\AttributeOption;
use App\Models\Admin\CustomizeProductOption;
use App\Models\Admin\Mlmuser;
use App\Models\Admin\Offer;
use App\Models\Admin\OfferProduct;
use App\Models\Admin\ProductCategory;
use App\Models\User\MlmuserProduct;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name','slug','SKU','affiliate_link','featured_image','gallery_image','short_description','description','productType','tags','specifications','specification_name','specification_description','stock','type_id','category_id','subcategory_id','price','special_price','video_link','meta_keywords','meta_descriptions','customize_charge','status'];


    public function getRouteKeyName()
    {
        return 'slug';
    }


    //Primary Key

    public $primaryKey = 'id';


    //Timestamps

    public $timestamps = true;
    
    public function type() {
        return $this->belongsTo('App\Models\Admin\ProductType');
    }

    public function category() {
        return $this->belongsTo(ProductCategory::class);
    }


    public function images()
    {
        return $this->hasMany('App\Models\Admin\ProductImage');
    }

}
