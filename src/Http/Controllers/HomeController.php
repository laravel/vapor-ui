<?php

namespace Laravel\VaporUi\Http\Controllers;

use Illuminate\View\View;
use Laravel\VaporUi\Support\Cloud;

class HomeController
{
    /**
     * Returns the Vapor UI home page.
     *
     * @return View
     */
    public function __invoke()
    {
        return view('vapor-ui::layout', [
            'path' => config('vapor-ui.path', 'vapor-ui'),
            'queues' => Cloud::queues(),
        ]);
    }
}
