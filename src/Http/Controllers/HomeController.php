<?php

namespace Laravel\VaporUi\Http\Controllers;

class HomeController
{
    /**
     * Gets the Vapor Ui home page.
     * 
     * @return array
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
