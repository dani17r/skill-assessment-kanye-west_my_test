<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use App\Http\Middleware\VerifyCsrfToken;
use App\Http\Middleware\Authenticate;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
// use Illuminate\Http\Request;
use Inertia\Inertia;

class Controller extends BaseController
{
    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function view() {
        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    }

    public function dashboard() {
        return Inertia::render('Dashboard');
    }
}
