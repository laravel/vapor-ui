<?php

namespace Laravel\VaporUi\Http\Controllers;

use Illuminate\View\View;

class HomeController
{
    /**
     * Gets the Vapor Ui home page.
     *
     * @return View
     */
    public function __invoke()
    {
        return view('vapor-ui::layout', [
            'appVars' => [
                'timezone' => config('app.timezone'),
            ],
        ]);
    }
}
