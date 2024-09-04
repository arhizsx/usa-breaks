<?php

namespace App\Observers;

use App\Models\Scraper;
use App\Models\Orders;

class ScraperObserver
{
    /**
     * Handle the Scraper "created" event.
     */
    public function created(Scraper $scraper): void
    {
        //
    }

    /**
     * Handle the Scraper "updated" event.
     */
    public function updated(Scraper $scraper): void
    {


    }

    /**
     * Handle the Scraper "deleted" event.
     */
    public function deleted(Scraper $scraper): void
    {
        //
    }

    /**
     * Handle the Scraper "restored" event.
     */
    public function restored(Scraper $scraper): void
    {
        //
    }

    /**
     * Handle the Scraper "force deleted" event.
     */
    public function forceDeleted(Scraper $scraper): void
    {
        //
    }
}
