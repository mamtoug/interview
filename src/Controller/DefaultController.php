<?php

namespace App\Controller;

use App\Entity\Knight;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\FOSRestBundle;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractFOSRestController
{
    /**
     * @Route("/", name="default")
     */
    public function index()
    {

        return new JsonResponse(null ,200);
    }
}
