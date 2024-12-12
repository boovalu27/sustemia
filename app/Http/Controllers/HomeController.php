<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
      // Retorna la vista 'inicio'.
      return view('home');
    }

    public function about()
    {
      // Retorna la vista 'nosotros'.
      return view('about');
    }
}
