<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $table = 'purchases';

    protected $fillable = [
        'supplier_id',
        'name',
        'phone',
        'address',
        'total_price',
        'status',
    ];

    const ORDER_WAIT        = 0;
    const ORDER_FINISH      = 1;
    const ORDER_RETURN      = 2;

    public static $status_text = [
        self::ORDER_WAIT        => 'Chờ giao hàng',
        self::ORDER_FINISH      => 'Đã nhận hàng',
        self::ORDER_RETURN      => 'Hủy đơn hàng',
    ];

    public function getStatusTextAttribute(){
        if ($this->status == 0){
            return 'Chờ giao hàng';
        } elseif ($this->status == 1){
            return 'Đã nhận hàng';
        } else {
            return 'Hủy đơn hàng';
        }
    }

    public function products(){
        return $this->belongsToMany(Product::class)->withPivot(['price', 'quantity']);
    }

    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }
    
}
