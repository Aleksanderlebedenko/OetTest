<?php


namespace App\Controller\Api;


use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;

class AbstractApiController extends AbstractFOSRestController
{
    protected function buildForm(string $type, $data = null, array $options = []): FormInterface
    {
        return $this->container->get('form.factory')->createNamed('', $type, $data, $options);
    }

    public function respond($data, $statusCode = Response::HTTP_OK): Response
    {
        return $this->handleView($this->view($data, $statusCode));
    }
}