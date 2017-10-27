<?php

namespace App\Observers;

use App\Models\Application;
use App\Services\ApplicationService;

class ApplicationObserver
{
    private $applicationService;
    public function __construct(ApplicationService $applicationService)
    {
        $this->applicationService = $applicationService;
    }

    /**
     * Handle the application "created" event.
     *
     * @param \App\Models\Application $application
     * @return void
     */
    public function created(Application $application)
    {
        $contest = $application->content ? true : false;

        $this->applicationService->sendMail(
            $application->email,
            ['id' => $application->id, 'token' => $application->token],
            $contest
        );
    }

    /**
     * Handle the application "updated" event.
     *
     * @param \App\Models\Application $application
     * @return void
     */
    public function updated(Application $application)
    {
        //
    }

    /**
     * Handle the application "deleted" event.
     *
     * @param \App\Models\Application $application
     * @return void
     */
    public function deleted(Application $application)
    {
        //
    }

    /**
     * Handle the application "restored" event.
     *
     * @param \App\Models\Application $application
     * @return void
     */
    public function restored(Application $application)
    {
        //
    }

    /**
     * Handle the application "force deleted" event.
     *
     * @param \App\Models\Application $application
     * @return void
     */
    public function forceDeleted(Application $application)
    {
        //
    }
}
