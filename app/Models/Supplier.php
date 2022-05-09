<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'suppliers';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'user_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function products(){
        return $this->belongsToMany(Product::class);
    }

    public function purchases(){
        return $this->hasMany(Purchase::class);
    }
    

    public function scopeSearch($query, $request)
    {
        if ($request->has('q')) {
            $query
                ->where('name', 'LIKE', '%'.$request->q.'%')
                ->orWhere('phone', 'LIKE', '%'.$request->q.'%')
                ->orWhere('email', 'LIKE', '%'.$request->q.'%')
                ->orderBy('created_at', 'DESC');
        }

        return $query;
    }
}
