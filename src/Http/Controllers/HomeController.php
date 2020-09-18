<?php

namespace Laravel\VaporUi\Http\Controllers;

use Illuminate\View\View;

class HomeController
{
    /**
     * Returns the Vapor UI home page.
     *
     * @return View
     */
    public function __invoke()
    {
        return view('vapor-ui::layout');
    }
}
