<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class AccountController
{
  public function account(Environment $twig)
  {

    $content = $twig->render("Account/account.html.twig");

    return new Response($content);
  }

}