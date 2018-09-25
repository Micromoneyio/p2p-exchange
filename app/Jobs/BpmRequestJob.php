<?php

namespace App\Jobs;

use App\BpmModule;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class BpmRequestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @param  string $entity
     * @return void
     */
    public function handle(int $modelId, string $modelClass)
    {
        $model = null;
        $module = new BpmModule();
        switch ($modelClass) {
            case 'Currency':
                $model = Currency::find($modelId); break;
            case 'DealStage':
                $model = DealStage::find($modelId); break;
            case 'Order':
                $model = Order::find($modelId); break;
            case 'User':
                $model = User::find($modelId); break;
            case 'Bank':
                $model = Bank::find($modelId); break;
            default:
                return null;
        }
        if (!empty($model))
        {
            $module->save($model);
        }
    }
}
