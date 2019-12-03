<?php

namespace App\Controller;

use App\Entity\Knight;
use App\Handler\HandlerInterface;
use App\Repository\KnightRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\View;

class KnightController extends AbstractFOSRestController implements HandlerInterface
{
    /**
     * @var KnightRepository
     */
    private $knightRepository;

    public function __construct(KnightRepository $knightRepository)
    {
        $this->knightRepository = $knightRepository;
    }

    /**
     * @Rest\Get("/knight", name="knight")
     */
    public function index()
    {
        return $this->knightRepository->findAll() ;
    }


    /**
     * Get a collection of resources
     *
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function all($limit, $offset)
    {
        // TODO: Implement all() method.
    }

    /**
     * Register a resource
     *
     * @param $resource
     * @return mixed
     */
    public function post($resource)
    {

    }


    /**
     * Get a resource
     *
     * @param int $id
     * @return Object
     */
    public function get($id){
        return $this->knightRepository->find($id);
    }
}
