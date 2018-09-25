<?php

namespace Modules\ExternalAccess\Http\Controllers;

use App\Helpers\Mailer;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ExternalAccess\Services\RecoveryPasswordTokenService;
use Modules\User\Services\UserServiceCrud;

class RecoveryPasswordController extends Controller
{

    /**
     * @var UserServiceCrud
     */
    private $serviceCrud;
    /**
     * @var Mailer
     */
    private $mailer;
    /**
     * @var RecoveryPasswordTokenService
     */
    private $service;

    public function __construct(UserServiceCrud $serviceCrud, Mailer $mailer, RecoveryPasswordTokenService $service)
    {
        $this->serviceCrud = $serviceCrud;
        $this->mailer = $mailer;
        $this->service = $service;
    }

    /**
     * @param Request $request
     * @return array|\Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function sendEmail(Request $request)
    {
        $queryParams = [
            'email' => $request->get('email')
        ];

        if (!$queryParams['email']) {
            $message[] = "Informe o email para recuperação";
            return response($message, 422);
        }

        // verifica se o email informado esta cadastrado na base de dados
        $check = $this->serviceCrud->findWhere(['email' => $queryParams['email']]);

        if (!count($check)) {
            $message[] = "Email informado não cadastrado na base de dados do sistema";
            return response($message, 422);
        }

        $tokenData = $this->service->createTokenRecovery($queryParams['email']);

        // envio o email de recuperação
        $emailTo = $queryParams['email'];
        $nameTo = env('EMAIL_TITLE_DEFAULT');
        $subject = "Alteração de Senha";

        $link = env('SYSTEM_URL').'change-password?token='.$tokenData->token;

        $dataBodyMail = [
            'data' => [
                'text_mail' => "<div>Foi solicitado uma alteração de senha no sistema para sua conta.</div>
                                <div style='padding-bottom: 20px; margin-top: 5px'><a href={$link}>Clique aqui</a> para alterar sua senha</div>"
            ],
            'view' => 'email.changePassword'
        ];

        $this->mailer->config($emailTo, $nameTo , $subject, $dataBodyMail)->send();

        return [
            'success' => true
        ];
    }

    public function changePassword(Request $request)
    {
        $dataUpdate = $request->all();

        return $this->service->changePassword($dataUpdate);
    }

}
