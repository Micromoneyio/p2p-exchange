<?php

namespace App\Jobs;

use App\SyncModule;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SyncRequestJob implements ShouldQueue
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
    public function handle(string $entity, $model)
    {
        $module = new SyncModule();
        switch ($entity) {
            case 'user':  $module->contact($model); break;
            case 'order': $module->order($model);   break;
        }
    }
}
