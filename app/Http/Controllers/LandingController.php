<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingController extends Controller
{
    // Halaman utama
    public function index()
    {
        return view('landing.index');
    }

    // Halaman Features
    public function features()
    {
        return view('landing.sections.features');
    }

    // Halaman Testimonials
    public function testimonials()
    {
        return view('landing.sections.testimonials');
    }

    // Halaman Contact
    public function hero()
    {
        return view('landing.sections.hero');
    }

    public function cta() {
        return view('landing.sections.cta');
    }
}
