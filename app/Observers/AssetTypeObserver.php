<?php

namespace App\Observers;

use App\AssetType;
use App\Jobs\BpmRequestJob;

class AssetTypeObserver
{
    /**
     * Handle to the asset type "created" event.
     *
     * @param  \App\AssetType  $assetType
     * @return void
     */
    public function created(AssetType $assetType)
    {
        BpmRequestJob::dispatch($assetType->id, 'AssetType');
    }

    /**
     * Handle the asset type "updated" event.
     *
     * @param  \App\AssetType  $assetType
     * @return void
     */
    public function updated(AssetType $assetType)
    {
        BpmRequestJob::dispatch($assetType->id, 'AssetType');
    }

    /**
     * Handle the asset type "deleted" event.
     *
     * @param  \App\AssetType  $assetType
     * @return void
     */
    public function deleted(AssetType $assetType)
    {
        //
    }
}
