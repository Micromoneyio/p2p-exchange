<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //  belongs_to :source_currency,      class_name: 'Currency', foreign_key: 'source_currency_id'
    //  belongs_to :destination_currency, class_name: 'Currency', foreign_key: 'destination_currency_id'
    //  belongs_to :source_asset,         class_name: 'Asset',    foreign_key: 'source_asset_id'
    //  belongs_to :destination_asset,    class_name: 'Asset',    foreign_key: 'destination_asset_id'
    //
    //  has_many :deals
    //
    //  validates :user_id,                 presence: true
    //  validates :source_currency_id,      presence: true
    //  validates :destination_currency_id, presence: true
    //  validates :source_asset_id,         presence: true
    //  validates :destination_asset_id,    presence: true
    //
    //  def type
    //    if source_currency.crypto && !destination_currency.crypto
    //      :crypto_to_fiat
    //    else
    //      :fiat_to_crypto
    //    end
    //  end
    //
    //  def price
    //    if fix_price
    //      fix_price
    //    elsif source_price_index
    //      history_params = { rate_source: rate_source }
    //      case type
    //      when :crypto_to_fiat
    //        history_params[:currency]      = source_currency
    //        history_params[:unit_currency] = destination_currency
    //      when :fiat_to_crypto
    //        history_params[:currency]      = destination_currency
    //        history_params[:unit_currency] = source_currency
    //      end
    //      market_history = MarketHistory.order(created_at: :asc).find_by(history_params)
    //      if market_history
    //        market_history.price + (market_history.price * source_price_index / 100)
    //      else
    //        0
    //      end
    //    end
    //  end
    //
    //  def favorite?(user)
    //    return false if id.nil?
    //    user.favorite_orders.exists?(order_id: id)
    //  end

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function rate_source() {
        return $this->belongsTo('App\RateSource');
    }
}
