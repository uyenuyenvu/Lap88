<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'slug',
        'quantity',
        'origin_price',
        'sale_price',
        'discount_percent',
        'content',
        'content_more',
        'user_id',
        'category_id',
        'trademark_id',
        'status'
    ];

    const STATUS_INIT   = 0;
    const STATUS_BUY    = 1;
    const STATUS_STOP   = 2;

    public static $status_text = [
        self::STATUS_INIT   => 'Thử nghiệm',
        self::STATUS_BUY    => 'Đang bán',
        self::STATUS_STOP   => 'Dừng bán'
    ];

    public function getStatusTextAttribute()
    {
        if ($this->status == 0) {
            return 'Thử nghiệm';
        } elseif ($this->status == 1) {
            return 'Đang bán';
        } else {
            return 'Dừng bán';
        }
    }

    public function getContentMoreJsonAttribute(){
        $content_json = json_decode($this->content_more, true);
        return $content_json;
    }

    protected $casts = [
//        'content_more' => 'array'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function trademark()
    {
        return $this->belongsTo(Trademark::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }

    public function warehouses(){
        return $this->hasMany(Warehouse::class);
    }

    public function suppliers(){
        return $this->belongsToMany(Supplier::class);
    }

    public function purchases(){
        return $this->belongsToMany(Purchase::class);
    }

    public function order_product(){
        return $this->hasMany(Order_Product::class);
    }
}
