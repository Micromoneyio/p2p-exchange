<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

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
    protected $fillable = ['email', 'password', 'is_verified','name','default_currency_id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

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

    /**
     * Notifications relationship
     *
     * @return Illuminate\Support\Collection
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * Assets relationship
     *
     * @return Illuminate\Support\Collection
     */
    public function assets()
    {
        return $this->hasMany(Asset::class);
    }

    /**
     * Orders relationship
     *
     * @return Illuminate\Support\Collection
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Favorite orders relationship
     *
     * @return Illuminate\Support\Collection
     */
    public function favoriteOrders()
    {
        return $this->hasMany(FavoriteOrder::class);
    }

    /**
     * Callbacks relationship
     *
     * @return Illuminate\Support\Collection
     */
    public function callbacks()
    {
        return $this->hasMany(Callback::class);
    }
    
        /**
     * Deakl relationship
     *
     * @return Illuminate\Support\Collection
     */
    public function deals()
    {
        return $this->hasMany(Deal::class);
    }

    public function defaultCurrency()
    {
        return $this->belongsTo(Currency::class);
    }
}
