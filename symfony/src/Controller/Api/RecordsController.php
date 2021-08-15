<?php


namespace App\Controller\Api;


use App\Exception\NoDataFoundException;
use App\Service\GetRecordService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class RecordsController extends AbstractController
{
    private GetRecordService $getRecordService;

    public function __construct(
        GetRecordService $getRecordService
    ) {
        $this->getRecordService = $getRecordService;
    }

    /**
     * @Route("/api/records/{id}", name="get record", methods={"GET"}, requirements={"id"="\d+"})
     * @param string $id
     * @return JsonResponse
     * @throws NotFoundHttpException
     */
    public function get(string $id): JsonResponse
    {
        try {
            return $this->json($this->getRecordService->get($id));
        } catch (NoDataFoundException $exception) {
            throw $this->createNotFoundException($exception->getMessage());
        }
    }

}