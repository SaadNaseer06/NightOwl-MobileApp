<?php

namespace App\Listeners;

use App\Events\BarTypeDeleting;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class BarTypeDeletingListener
{
    /**
     * Handle the event.
     *
     * @param  BarTypeDeleting  $event
     * @return void
     */
    public function handle(BarTypeDeleting $event)
    {
        $barType = $event->barType;

        // Accessing the specifications relationship of the BarType model
        $specifications = $barType->specifications();

        // Delete associated specifications
        $specifications->delete();

        // Delete associated bar visits
        $barType->barVisit()->delete();
        
        $barType->bookmark()->delete();
        
        $barType->reviews()->delete();
    }
}
?>