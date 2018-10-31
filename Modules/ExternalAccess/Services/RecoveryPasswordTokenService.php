<?php

namespace Modules\ExternalAccess\Services;


use Carbon\Carbon;
use Modules\User\Services\UserServiceCrud;

class RecoveryPasswordTokenService
{
    /**
     * @var RecoveryPasswordTokenServiceCrud
     */
    private $serviceCrud;
    /**
     * @var UserServiceCrud
     */
    private $userServiceCrud;

    public function __construct(RecoveryPasswordTokenServiceCrud $serviceCrud, UserServiceCrud $userServiceCrud)
    {
        $this->serviceCrud = $serviceCrud;
        $this->userServiceCrud = $userServiceCrud;
    }

    /**
     * @param string $email
     * @return \Illuminate\Contracts\Routing\ResponseFactory|mixed|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function createTokenRecovery(string $email)
    {
        // verifica se tem token em uso e remove
        $check = $this->serviceCrud->findWhere(['email' => $email]);
        if ($check->count()) {
            $this->serviceCrud->delete($check[0]['id']);
        }

        $dataCreated = [
            'email' => $email,
            'token' => md5(uniqid(rand(), true)),
            'expired' => Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'))->addHour()->format('Y-m-d H:i:s')
        ];

        //return $dataCreated;

        // cria um novo token
        return $this->serviceCrud->create($dataCreated, false);
    }

    /**
     * Altera a senha
     * @param array $data
     * @return array|\Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function changePassword(array $data)
    {
        if (!$data['token']) {
            $message[] = "Nenhum token informado !";
            return response($message, 422);
        }

        // verifica se o token é valido
        $now = date('Y-m-d H:i:s');
        $check = $this->serviceCrud->findWhere(['token' => $data['token']]);
        if (!$check->count()) {
            if (!$data['token']) {
                $message[] = "Dados do token não encontrado !";
                return response($message, 422);
            }
        }

        if (strtotime($now) > strtotime($check[0]['expired'])) {
            $message[] = "Token expirado, faça uma nova solicitação !";
            return response($message, 422);
        }

        $userData = $this->userServiceCrud->findWhere(['email' => $check[0]['email']])->toArray();

        $userData = $userData[0];

        $userData['password'] = $data['password'];
        $userData['password_confirmation'] = $data['password_confirmation'];


        if ($userData['password'] != $userData['password_confirmation']) {
            $message[] = "Senhas não combinam !";
            return response($message, 422);
        }

        $userData['password'] = bcrypt($data['password']);

        unset($userData['password_confirmation']);

        $dataUpdated = $this->userServiceCrud->update($userData, $userData['id']);

        if (isset($dataUpdated->id)) {
            return [
                'success' => true
            ];
        }
    }
}