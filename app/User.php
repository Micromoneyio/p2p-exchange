<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
/**
 * @SWG\Definition(
 *     definition="User",
 *      required={"email","password", "password_confirmation"},
 *     @SWG\Property(
 *     property="id",
 *     description="id",
 *      type="integer",
 *      format="int32"
 *      ),
 *     @SWG\Property(
 *     property="email",
 *     description="email",
 *      type="string",
 *      ),
 *      @SWG\Property(
 *     property="password",
 *     description="password",
 *      type="string",
 *      ),
 * )
 */

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'is_verified','name','default_currency_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
    public function notifications() {
        return $this->hasMany('App\Notification');
    }

    public function assets() {
        return $this->hasMany('App\Asset');
    }

    public function orders() {
        return $this->hasMany('App\Order');
    }
    public function favorite_orders(){
        return $this->hasMany(FavoriteOrder::class);
    }

    public function callbacks()
    {
        return $this->hasMany('App\Callback');
    }
}
