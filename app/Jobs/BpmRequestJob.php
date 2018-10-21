<?php

namespace App\Jobs;

use App\Asset;
use App\AssetType;
use App\Bank;
use App\BpmModule;
use App\Currency;
use App\DealHistory;
use App\DealStage;
use App\MarketHistory;
use App\Order;
use App\RateSource;
use App\Settings;
use App\User;
use App\Deal;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class BpmRequestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $modelId, $modelClass;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $modelId, string $modelClass)
    {
        $this->modelId = $modelId;
        $this->modelClass = $modelClass;
    }

    /**
     * Execute the job.
     *
     * @param  string $entity
     * @return void
     */
    public function handle()
    {
        $model = null;
        $module = new BpmModule();
        switch ($this->modelClass) {
            case 'Currency':
                $model = Currency::find($this->modelId); break;
            case 'DealStage':
                $model = DealStage::find($this->modelId); break;
            case 'Order':
                $model = Order::find($this->modelId); break;
            case 'User':
                $model = User::find($this->modelId); break;
            case 'Bank':
                $model = Bank::find($this->modelId); break;
            case 'RateSource':
                $model = RateSource::find($this->modelId); break;
            case 'AssetType':
                $model = AssetType::find($this->modelId); break;
            case 'Deal':
                $model = Deal::find($this->modelId); break;
            case 'Asset':
                $model = Asset::find($this->modelId); break;
            case 'DealHistory':
                $model = DealHistory::find($this->modelId); break;
            case 'MarketHistory':
                $model = MarketHistory::find($this->modelId); break;
            case 'Settings':
                $model = Settings::find($this->modelId); break;
            default:
                return null;
        }
        $module->save($model);
    }
}
