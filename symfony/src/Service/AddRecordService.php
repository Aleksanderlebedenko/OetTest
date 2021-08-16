<?php


namespace App\Service;


use App\Entity\Record;
use App\Exception\RepositoryException;
use App\Repository\RecordRepository;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\ORMInvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;

class AddRecordService
{
    private RecordRepository $recordRepository;

    public function __construct(
        RecordRepository $recordRepository
    ) {
        $this->recordRepository = $recordRepository;
    }

    /**
     * @param Record $record
     * @return Record
     * @throws RepositoryException
     */
    public function add(Record $record): Record
    {
        try {
            $this->recordRepository->add($record);
        } catch (ORMException $e) {
            throw new RepositoryException(
                'ORM exception during adding new record.',
                Response::HTTP_INTERNAL_SERVER_ERROR,
                $e
            );
        } catch (ORMInvalidArgumentException $e) {
            throw new RepositoryException(
                'ORM invalid argument exception during adding new record',
                Response::HTTP_INTERNAL_SERVER_ERROR,
                $e
            );
        }
        return $record;
    }

}