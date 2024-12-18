<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
  /**
   * Muestra la vista principal (inicio).
   *
   * Este método maneja la solicitud para la página de inicio de la aplicación.
   *
   * @return \Illuminate\View\View
   */
  public function index()
  {
    // Retorna la vista 'inicio'.
    return view('home');
  }

  /**
   * Muestra la vista 'Nosotros'.
   *
   * Este método maneja la solicitud para la página 'Sobre nosotros' de la aplicación.
   *
   * @return \Illuminate\View\View
   */
  public function about()
  {
    // Retorna la vista 'nosotros'.
    return view('about');
  }
}
