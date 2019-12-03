<?php

namespace App\Controller;

use App\Entity\Knight;
use App\Form\KnightType;
use App\Handler\HandlerInterface;
use App\Repository\KnightRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class KnightController extends AbstractFOSRestController implements HandlerInterface
{
    /**
     * @var KnightRepository
     */
    private $knightRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(KnightRepository $knightRepository, EntityManagerInterface $entityManager)
    {
        $this->knightRepository = $knightRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Rest\QueryParam(name="limit", description="limit", nullable=true)
     * @Rest\QueryParam(name="offset", description="offset", nullable=true)
     * @param ParamFetcher $paramFetcher
     * @Rest\Get("/knights", name="knights")
     * @return \FOS\RestBundle\View\View
     */
    public function knights(ParamFetcher $paramFetcher)
    {
        $limit = $paramFetcher->get('limit');
        $offset = $paramFetcher->get('offset');
        $data = $this->all($limit, $offset);
        return $this->view($data, Response::HTTP_OK);
    }

    /**
     * @Rest\QueryParam(name="limit", description="limit", nullable=true)
     * @Rest\QueryParam(name="offset", description="offset", nullable=true)
     * @Rest\Get("/knight/{id}", name="knight")
     */
    public function knight($id)
    {
        $data = $this->getOne($id);
        if ($data) {
            return $this->view($data, Response::HTTP_OK);
        } else {
            throw new NotFoundHttpException('Knight #' . $id . ' not found.');
        }
    }


    /**
     * @param Request $request
     * @return \FOS\RestBundle\View\View
     * @Rest\Post("/knight", name="add_knight")
     */
    public function add(Request $request)
    {

        $knight = new Knight();
        $form = $this->createForm(KnightType::class, $knight);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()) {

            $knight = $this->post($data);
            return $this->view($knight, Response::HTTP_CREATED);
        }
        return $this->view('form is not valid', Response::HTTP_BAD_REQUEST);

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
        $data = $this->knightRepository->allKnight($limit, $offset);
        return $data;
    }

    /**
     * Register a resource
     *
     * @param $resource
     * @return mixed
     */
    public function post($resource)
    {
        $knight = new Knight();
        $knight->setName($resource['name']);
        $knight->setStrength($resource['strength']);
        $knight->setWeaponPower($resource['weaponPower']);
        $this->entityManager->persist($knight);
        $this->entityManager->flush();
        return $knight;
    }


    /**
     * Get a resource
     *
     * @param int $id
     * @return Object
     */
    public function getOne($id)
    {
        return $this->knightRepository->oneKnight($id);
    }
}
