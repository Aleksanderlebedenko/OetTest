<?php


namespace App\Controller\Api;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecordsController
{

    /**
     * @Route("/api/records/{id}", name="get record", methods={"GET"})
     */
    public function get(int $id): JsonResponse
    {
        return new JsonResponse(['id' => $id], Response::HTTP_OK);
    }

}