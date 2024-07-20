<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LoginController extends AbstractController
{
    #[Route('/api/login', name: 'app_api',methods: 'POST')]
    public function login()
    {
        // This code is never executed, as the route is intercepted by the JWT security layer.
        throw new \Exception('This should never be reached!');
    }
}
