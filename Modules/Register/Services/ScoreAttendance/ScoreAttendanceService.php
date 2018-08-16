<?php

namespace Modules\Register\Services\ScoreAttendance;


class ScoreAttendanceService
{
    /**
     * @var ScoreAttendanceServiceCrud
     */
    private $serviceCrud;

    public function __construct(ScoreAttendanceServiceCrud $serviceCrud)
    {
        $this->serviceCrud = $serviceCrud;
    }

    /**
     * Verifica se o usuário esta registrado para update
     * @param array $data
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function checkExistsForUpdate(array $data)
    {
        $closure = function ($query) use ($data) {
            return $query->whereNotIn('id', array($data['id']))
                        ->where('attendant_id', $data['attendant_id']);
        };

        $results = $this->serviceCrud->scopeQuery($closure);

        if ($results->count()) {
            $message[] = "Atendente já registrado";
            return response($message, 422);
        }
    }
}