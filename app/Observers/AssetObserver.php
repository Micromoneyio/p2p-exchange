<?php

namespace App\Observers;

use App\Asset;
use App\Jobs\BpmRequestJob;

class AssetObserver
{
    /**
     * Handle to the asset "created" event.
     *
     * @param  \App\Asset  $asset
     * @return void
     */
    public function created(Asset $asset)
    {
        BpmRequestJob::dispatch($asset->id, 'Asset');
    }

    /**
     * Handle the asset "updated" event.
     *
     * @param  \App\Asset  $asset
     * @return void
     */
    public function updated(Asset $asset)
    {
        BpmRequestJob::dispatch($asset->id, 'Asset');
    }

    /**
     * Handle the asset "deleted" event.
     *
     * @param  \App\Asset  $asset
     * @return void
     */
    public function deleted(Asset $asset)
    {
        //
    }
}
