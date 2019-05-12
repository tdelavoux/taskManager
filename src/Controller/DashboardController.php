<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class DashboardController
{
  public function dashboard(Environment $twig)
  {

    $content = $twig->render("Dashboard/dashboard.html.twig");

    return new Response($content);
  }

}