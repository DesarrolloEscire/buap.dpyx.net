<?php

namespace App\Listeners;

use App\Models\User;
use App\Notifications\EvaluationFinishedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RequestEvaluatorListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {


        $evaluator = $event->evaluation->evaluator;
        $evaluator->notify(new EvaluationFinishedNotification($event->evaluation));

    }

}
