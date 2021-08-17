<?php


namespace App\Service;


use App\Entity\Record;
use App\Exception\NoDataFoundException;
use App\Repository\RecordRepository;
use Symfony\Component\HttpFoundation\Request;

class GetRecordService
{
    private RecordRepository $recordRepository;

    public function __construct(
        RecordRepository $recordRepository
    ) {
        $this->recordRepository = $recordRepository;
    }

    /**
     * @param string $id
     * @return Record
     * @throws NoDataFoundException
     */
    public function get(string $id): Record
    {
        $record = $this->recordRepository->find($id);
        if (null === $record) {
            throw new NoDataFoundException("There are no any records with id: $id");
        }

        return $record;
    }

    /**
     * @param Request $request
     * @return Record[]
     */
    public function find(Request $request): array
    {
        return $this->recordRepository->findByNameAndDescription(
            $request->get('name'),
            $request->get('description')
        );
    }

}