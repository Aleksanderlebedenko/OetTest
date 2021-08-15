<?php


namespace App\Service;


use App\Entity\Record;
use App\Exception\NoDataFoundException;
use App\Repository\RecordRepository;

class GetRecordService
{
    private RecordRepository $recordRepository;

    public function __construct(
        RecordRepository $recordRepository
    ) {
        $this->recordRepository = $recordRepository;
    }

    /**
     * @param int $id
     * @return Record
     * @throws NoDataFoundException
     */
    public function get(int $id): Record
    {
        $record = $this->recordRepository->find($id);
        if (null === $record) {
            throw new NoDataFoundException("There are no any records with id: $id");
        }

        return $record;
    }

}