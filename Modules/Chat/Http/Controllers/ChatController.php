<?php

namespace Modules\Chat\Http\Controllers;

use App\Events\CheckUsersOnlineChat;
use App\Events\RefreshDataChat;
use App\Events\Typing;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Chat\Services\ChatService;
use Modules\Chat\Services\MessageServiceCrud;
use Modules\Chat\Services\OnlineUserServiceCrud;
use Modules\SystemAlert\Services\SystemAlertServiceCrud;
use Modules\User\Services\UserServiceCrud;

class ChatController extends Controller
{
    /**
     * @var OnlineUserServiceCrud
     */
    private $onlineUserServiceCrud;
    /**
     * @var UserServiceCrud
     */
    private $userServiceCrud;
    /**
     * @var ChatService
     */
    private $service;
    /**
     * @var MessageServiceCrud
     */
    private $messageServiceCrud;
    /**
     * @var SystemAlertServiceCrud
     */
    private $systemAlertServiceCrud;

    public function __construct(OnlineUserServiceCrud $onlineUserServiceCrud, UserServiceCrud $userServiceCrud, ChatService $service, MessageServiceCrud $messageServiceCrud
                                , SystemAlertServiceCrud $systemAlertServiceCrud)
    {
        $this->onlineUserServiceCrud = $onlineUserServiceCrud;
        $this->userServiceCrud = $userServiceCrud;
        $this->service = $service;
        $this->messageServiceCrud = $messageServiceCrud;
        $this->systemAlertServiceCrud = $systemAlertServiceCrud;
    }

    /**
     * Insere o usuário como logado na tale de online_users
     * @return \Illuminate\Contracts\Routing\ResponseFactory|mixed|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function login()
    {
        $userId = Auth::user()->id;

        // verifica se o usuário esta logado para remover
        $check  = $this->onlineUserServiceCrud->findWhere(['user_id' => $userId]);
        if ($check->count()) {
            $this->onlineUserServiceCrud->delete($check[0]['id']);
        }

        // define o usuário como logado
        $data = [
            'user_id' => $userId,
            'last_interaction' => date('Y-m-d H:i:s'),
            'online' => true
        ];

        // event(new CheckUsersOnlineChat());

        return $this->onlineUserServiceCrud->create($data);
    }

    /**
     * Seta uma nova interação para o usuário permanecer logado
     * @return \Illuminate\Contracts\Routing\ResponseFactory|mixed|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function setInteractionUserLogged()
    {
        $userId = Auth::user()->id;

        $dataUpdate = [
            'user_id' => $userId,
            'last_interaction' => date('Y-m-d H:i:s'),
            'online' => true
        ];

        $check = $this->onlineUserServiceCrud->findWhere(['user_id' => $userId]);

        if (!$check->count()) {
            return $this->onlineUserServiceCrud->create($dataUpdate);
        }

        $dataUpdated = $check->toArray();

        $dataUpdated[0]['last_interaction'] = date('Y-m-d H:i:s');

        return $this->onlineUserServiceCrud->update($dataUpdated[0], $dataUpdated[0]['id']);

    }

    /**
     * Desloga usuário do chat
     * @return array
     */
    public function logout()
    {
        $userId = Auth::user()->id;

        // verifica se o usuário esta logado para remover
        $check  = $this->onlineUserServiceCrud->findWhere(['user_id' => $userId]);
        if ($check->count()) {
            $this->onlineUserServiceCrud->delete($check[0]['id']);
        }

        event(new CheckUsersOnlineChat());

        return [
            'success' => true
        ];
    }

    /**
     * Retorna os usuários do sistema e verifica se estão logados ou não
     */
    public function getAllUsers()
    {
        // all users
        $allUsers = $this->userServiceCrud->findWhere(['status' => 1]);

        $users = [
            'online' => [],
            'offline' => []
        ];

        // check online user
        if ($allUsers->count()) {

            foreach ($allUsers as $item) {

                $qtMessageNotRead = $this->messageServiceCrud->findWhere(['user_id_sender' => $item['id'], 'user_id_destination' => Auth::user()->id, 'date_read' => null])->count();

                $dataUser = [
                    'id' => $item['id'],
                    'name' => $item['name'] . ' ' . $item['last_name'],
                    'qt' => !$qtMessageNotRead ? null : $qtMessageNotRead
                ];

                $isOnline = $this->service->checkIsOnline($item['id']);

                if ($isOnline) {
                    array_push($users['online'], $dataUser);
                } else {
                    array_push($users['offline'], $dataUser);
                }

            }

        }

        $this->service->sort($users['online'], 'name');
        $this->service->sort($users['offline'], 'name');

        return [
            'online' => $this->service->sort($users['online'], 'name'),
            'offline' => $this->service->sort($users['offline'], 'name')
        ];
    }

    public function getConversations(Request $request)
    {
        $queryParams = [
            'in' => $request->get('in'),
            'to' => $request->get('to'),
            'read' => $request->get('read'),
        ];


        /*
         * Faz verificação se a mensagem é para marcar como lida
         */
        if ($queryParams['read'] and $queryParams['in'] == Auth::user()->id) {

            $dateRead = date('Y-m-d H:i:s');
            $closure = function ($query) use ($queryParams, $dateRead) {
                return $query->where('user_id_sender', $queryParams['to'])
                            ->where('user_id_destination', $queryParams['in'])->whereNull('date_read');
            };

            $dataToUpdate = $this->messageServiceCrud->scopeQuery($closure);

            foreach ($dataToUpdate as $item) {
                $this->messageServiceCrud->update(array('date_read' => $dateRead), $item['id'], false);
            }

        }


        $closure = function ($query) use ($queryParams) {
            return $query->where('user_id_sender', $queryParams['in'])
                ->where('user_id_destination', $queryParams['to'])
                ->orWhere(function ($query) use ($queryParams) {
                    $query->where('user_id_sender', $queryParams['to'])
                        ->where('user_id_destination', $queryParams['in']);
                });
        };

        return $this->messageServiceCrud->scopeQuery($closure);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|mixed|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function save(Request $request)
    {
        $data = $request->all();
        $data['user_id_sender'] = Auth::user()->id;

        $dataCreated = $this->messageServiceCrud->create($data);

        if (!isset($dataCreated->id)) {
            return $dataCreated;
        }

        /*
         * mensagem chat para o alerta do sistema
         */
        $dataMessage = [
            'message' => 'você tem uma nova mensagem do chat',
            'read' => false,
            'responsible' => $dataCreated->user_id_destination
        ];


        $this->systemAlertServiceCrud->create($dataMessage, false);

        return $dataCreated;
    }

    public function shootRealTime($idTo)
    {

        $params = [
            'in' => (int) Auth::user()->id,
            'to' => (int) $idTo
        ];

        event(new RefreshDataChat($params));
    }

    public function checkUsersOnline()
    {
        event(new CheckUsersOnlineChat());
    }

    /**
     * Verifica se o usuário esta digitando mensagem
     * @param Request $request
     */
    public function typing(Request $request)
    {
        $queryParams = [
            'to' => (int) $request->get('to'),
            'typing' => $request->get('typing') == 'true' ? true : false
        ];

        event(new Typing($queryParams));
    }


    /**
     * Marca as mensagens como lidas
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function markMessageRead(Request $request)
    {
        $queryParams = [
            'in' => $request->get('in'),
            'to' => Auth::user()->id
        ];

        $dateRead = date('Y-m-d H:i:s');

        $closure = function ($query) use ($queryParams, $dateRead) {
            return $query->where('user_id_sender', $queryParams['in'])
                        ->where('user_id_destination', $queryParams['to'])->whereNull('date_read');
        };

        $dataToUpdate = $this->messageServiceCrud->scopeQuery($closure);

        foreach ($dataToUpdate as $item) {
            $this->messageServiceCrud->update(array('date_read' => $dateRead), $item['id'], false);
        }

        return [
            'success' => true
        ];
    }
}
