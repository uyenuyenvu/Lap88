<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function getRoleTextAttribute(){
        if($this->role == 0){
            return 'Quản lý';
        } elseif ($this->role == 1){
            return 'Nhân viên';
        } else{
            return 'Khách hàng';
        }
    }

    const ROLE_MANAGE   = 0;
    const ROLE_STAFF    = 1;
    const ROLE_CUSTOMER = 2;

    public static $role_text = [
        self::ROLE_MANAGE   => 'Quản lý',
        self::ROLE_STAFF    => 'Nhân viên',
        self::ROLE_CUSTOMER => 'Khách hàng',
    ];

    public function orders(){
        return $this->hasMany(Order::class);
    }

    public function products(){
        return $this->hasMany(Product::class);
    }

    public function trademarks(){
        return $this->hasMany(Trademark::class);
    }

    public function categories(){
        return $this->hasMany(Category::class);
    }

    public function suppliers(){
        return $this->hasMany(Supplier::class);
    }

    public function scopeSearch($query, $request)
    {
        if ($request->has('q')) {
            $query
                ->where('name', 'LIKE', '%'.$request->q.'%')
                ->orWhere('phone', 'LIKE', '%'.$request->q.'%')
                ->orWhere('email', 'LIKE', '%'.$request->q.'%')
                ->orderBy('role', 'ASC');
        }

        return $query;
    }

    public static function updateAfterDelete($datas){
        foreach ($datas as $data) {
            $data->user_id = 1;
            $data->save();
        }
    }
}
