<?php

namespace Laravel\VaporUi\Http\Controllers;

use Illuminate\View\View;
use Laravel\VaporUi\Repositories\QueuesRepository;

class HomeController
{
    /**
     * Holds an instance of the queue repository.
     *
     * @var QueuesRepository
     */
    protected $queues;

    /**
     * Creates a new instance of the job controller.
     *
     * @param QueuesRepository $queues
     *
     * @return void
     */
    public function __construct(QueuesRepository $queues)
    {
        $this->queues = $queues;
    }

    /**
     * Returns the Vapor UI home page.
     *
     * @return View
     */
    public function __invoke()
    {
        return view('vapor-ui::layout', [
            'queues' => $this->queues->all(),
        ]);
    }
}
