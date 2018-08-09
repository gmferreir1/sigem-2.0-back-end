<?php

namespace Modules\Termination\Services;


use Illuminate\Support\Facades\Auth;

class ScoreService
{
    /**
     * @var ScoreServiceCrud
     */
    private $serviceCrud;

    public function __construct(ScoreServiceCrud $serviceCrud)
    {
        $this->serviceCrud = $serviceCrud;
    }

    /**
     * @param int $userId
     * @return \Illuminate\Contracts\Routing\ResponseFactory|mixed|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function addScore(int $userId)
    {
        $checkExists = $this->serviceCrud->findWhere(['attendant_id' => $userId]);

        if (count($checkExists)) {
            $scoreCurrent = $checkExists[0]['score'];
            $dataChange = $this->serviceCrud->update(['score' => $scoreCurrent + 1], $checkExists[0]['id'], false);

        } else {
            $dataCreated = [
                'attendant_id' => $userId,
                'score' => 1,
                'rp_last_action' => Auth::user()->id
            ];

            $dataChange = $this->serviceCrud->create($dataCreated);
        }

        return $dataChange;
    }
}