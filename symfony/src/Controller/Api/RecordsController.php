<?php


namespace App\Controller\Api;


use App\Exception\NoDataFoundException;
use App\Exception\RepositoryException;
use App\Form\Type\RecordType;
use App\Service\AddRecordService;
use App\Service\GetRecordService;
use App\Service\RemoveRecordService;
use Symfony\Component\Form\Exception\LogicException;
use Symfony\Component\Form\Exception\RuntimeException;
use Symfony\Component\HttpFoundation\Exception\SuspiciousOperationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class RecordsController extends AbstractApiController
{
    private GetRecordService $getRecordService;
    private RemoveRecordService $removeRecordService;
    private AddRecordService $addRecordService;

    public function __construct(
        GetRecordService $getRecordService,
        RemoveRecordService $removeRecordService,
        AddRecordService $addRecordService
    ) {
        $this->getRecordService = $getRecordService;
        $this->removeRecordService = $removeRecordService;
        $this->addRecordService = $addRecordService;
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
     * @Route("/api/records", name="add record", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     * @throws RepositoryException
     * @throws LogicException
     * @throws RuntimeException
     */
    public function add(Request $request): Response
    {
        $form = $this->buildForm(RecordType::class);

        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->respond($form, Response::HTTP_BAD_REQUEST);
        }

        return $this->json(
            $this->addRecordService->add($form->getData())
        );
    }

    /**
     * @Route("/api/records/{id}", name="update record", methods={"PATCH"}, requirements={"id"="\d+"})
     * @param string $id
     * @param Request $request
     * @return JsonResponse
     * @throws LogicException
     * @throws NotFoundHttpException
     * @throws RepositoryException
     * @throws RuntimeException
     * @throws SuspiciousOperationException
     */
    public function update(string $id, Request $request): Response
    {
        try {
            $record = $this->getRecordService->get($id);
        } catch (NoDataFoundException $exception) {
            throw $this->createNotFoundException($exception->getMessage());
        }
        $form = $this->buildForm(RecordType::class, $record, [
            'method' => $request->getMethod(),
        ]);

        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->respond($form, Response::HTTP_BAD_REQUEST);
        }

        return $this->json(
            $this->addRecordService->add($form->getData())
        );
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