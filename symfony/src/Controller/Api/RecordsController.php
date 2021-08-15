<?php


namespace App\Controller\Api;


use App\Exception\NoDataFoundException;
use App\Exception\RepositoryException;
use App\Service\GetRecordService;
use App\Service\RemoveRecordService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class RecordsController extends AbstractController
{
    private GetRecordService $getRecordService;
    private RemoveRecordService $removeRecordService;

    public function __construct(
        GetRecordService $getRecordService,
        RemoveRecordService $removeRecordService
    ) {
        $this->getRecordService = $getRecordService;
        $this->removeRecordService = $removeRecordService;
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

    /**
     * @Route("/api/records/{id}", name="delete record", methods={"DELETE"}, requirements={"id"="\d+"})
     * @param string $id
     * @return JsonResponse
     * @throws NotFoundHttpException
     * @throws RepositoryException
     */
    public function remove(string $id): JsonResponse
    {
        try {
            $this->removeRecordService->remove($id);
            return $this->json([], Response::HTTP_NO_CONTENT);
        } catch (NoDataFoundException $exception) {
            throw $this->createNotFoundException($exception->getMessage());
        }
    }

}