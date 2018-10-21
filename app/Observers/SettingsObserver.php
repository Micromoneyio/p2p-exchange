<?php

namespace App\Observers;

use App\Jobs\BpmRequestJob;
use App\Settings;

class SettingsObserver
{
    /**
     * Handle to the settings "created" event.
     *
     * @param  \App\Settings  $settings
     * @return void
     */
    public function created(Settings $settings)
    {
        BpmRequestJob::dispatch($settings->id, 'Settings');
    }

    /**
     * Handle the settings "updated" event.
     *
     * @param  \App\Settings  $settings
     * @return void
     */
    public function updated(Settings $settings)
    {
        BpmRequestJob::dispatch($settings->id, 'Settings');
    }

    /**
     * Handle the settings "deleted" event.
     *
     * @param  \App\Settings  $settings
     * @return void
     */
    public function deleted(Settings $settings)
    {
        //
    }
}
