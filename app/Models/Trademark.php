<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trademark extends Model
{
    use HasFactory;

    protected $table = 'trademarks';

    protected $fillable = [
        'name',
        'slug',
        'user_id',
    ];

    public function products(){
        return $this->hasMany(Product::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function categories(){
        return $this->belongsToMany(Category::class);
    }
}
