<?php

namespace Modules\Register\Services\ScoreAttendance;


use Illuminate\Support\Facades\Auth;

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

    /**
     * @param int $attendantId
     * @return bool
     * @throws \Exception
     */
    public function addScore(int $attendantId)
    {
        $results = $this->serviceCrud->findWhere(['attendant_id' => $attendantId]);

        $rpLastAction = Auth::user()->id;

        if (count($results)) {
            $this->serviceCrud->update(['score' => $results[0]['score'] + 1, 'rp_last_action' => $rpLastAction], $results[0]['id'], false);
        } else {
            $this->serviceCrud->create(['score' => 1, 'attendant_id' => $attendantId, 'rp_last_action' => $rpLastAction], false);
        }

        return true;
    }
}