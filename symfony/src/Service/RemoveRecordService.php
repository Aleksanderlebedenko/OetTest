<?php


namespace App\Service;


use App\Exception\NoDataFoundException;
use App\Exception\RepositoryException;
use App\Repository\RecordRepository;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\ORMInvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;

class RemoveRecordService
{
    private RecordRepository $recordRepository;

    public function __construct(
        RecordRepository $recordRepository
    ) {
        $this->recordRepository = $recordRepository;
    }

    /**
     * @param string $id
     * @throws NoDataFoundException
     * @throws RepositoryException
     */
    public function remove(string $id): void
    {
        $record = $this->recordRepository->find($id);
        if (null === $record) {
            throw new NoDataFoundException("There are no any records with id: $id");
        }

        try {
            $this->recordRepository->remove($record);
        } catch (ORMException $e) {
            throw new RepositoryException(
                "ORM exception during removing record with id: $id",
                Response::HTTP_INTERNAL_SERVER_ERROR,
                $e
            );
        } catch (ORMInvalidArgumentException $e) {
            throw new RepositoryException(
                "ORM invalid argument exception during removing record with id: $id",
                Response::HTTP_INTERNAL_SERVER_ERROR,
                $e
            );
        }
    }

}