<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Laravel\Fortify\Features;

class AuthPageController extends Controller
{
    public function login()
    {
        return Inertia::render('welcome', [
            'canRegister' => Features::enabled(Features::registration()),
        ]);
    }
}