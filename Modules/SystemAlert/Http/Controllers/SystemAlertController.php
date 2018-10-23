<?php

namespace Modules\SystemAlert\Http\Controllers;

use App\Events\CheckAlertSystem;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\SystemAlert\Services\SystemAlertServiceCrud;

class SystemAlertController extends Controller
{
    /**
     * @var SystemAlertServiceCrud
     */
    private $serviceCrud;

    public function __construct(SystemAlertServiceCrud $serviceCrud)
    {
        $this->serviceCrud = $serviceCrud;
    }

    public function find(Request $request)
    {
        $queryParams = [
            'user_id' => $request->get('user_id'),
            'only_read' => $request->get('only_read'),
            'mark_read' => $request->get('mark_read') == 'true' ? true : false
        ];

        $dataBeforeUpdate = $this->serviceCrud->findWhere(['responsible' => $queryParams['user_id'], 'read' => $queryParams['only_read']]);

        if ($queryParams['mark_read']) {

            $allAlertsNotRead = $this->serviceCrud->findWhere(['responsible' => $queryParams['user_id'], 'read' => $queryParams['only_read']]);

            foreach ($allAlertsNotRead as $item) {
                $this->serviceCrud->update(['read' => true], $item['id'], false);
            }

        }

        return $dataBeforeUpdate;
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|mixed|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function markRead($id)
    {
        return $this->serviceCrud->update(['read' => true], $id);
    }

    public function checkMessages($userId)
    {
        $alerts = $this->serviceCrud->findWhere(['responsible' => $userId, 'read' => 0]);

        event(new CheckAlertSystem($alerts->toArray()));
    }
}
