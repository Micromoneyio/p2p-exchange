<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Asset
 * @package App
 */
class Asset extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'asset_type_id',
        'user_id',
        'currency_id',
        'bank_id',
        'name',
        'address',
        'key',
        'default',
        'notes',
    ];

    /**
     * @var array
     */
    protected $hidden = ['password'];

    /**
     * @return BelongsTo
     */
    public function asset_type():BelongsTo {
        return $this->belongsTo('App\AssetType');
    }

    /**
     * @return BelongsTo
     */
    public function user():BelongsTo {
        return $this->belongsTo('App\User');
    }

    /**
     * @return BelongsTo
     */
    public function currency():BelongsTo {
        return $this->belongsTo('App\Currency');
    }

    /**
     * @return BelongsTo
     */
    public function bank():BelongsTo {
        return $this->belongsTo('App\Bank');
    }

    /**
     * @return Currency
     */
    public function crypto():Currency {
        return Currency::find($this->currency_id)->crypto;
    }

    /**
     * @return Currency
     */
    public function fiat():Currency {
        return !Currency::find($this->currency_id)->crypto;
    }


}
