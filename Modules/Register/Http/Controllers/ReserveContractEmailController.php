<?php

namespace Modules\Register\Http\Controllers;

use App\Helpers\Mailer;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Register\Services\ReserveContract\ReserveContractServiceCrud;
use Modules\User\Services\UserService;

class ReserveContractEmailController extends Controller
{
    /**
     * @var Mailer
     */
    private $mailer;
    /**
     * @var ReserveContractServiceCrud
     */
    private $reserveContractServiceCrud;
    /**
     * @var UserService
     */
    private $userService;

    public function __construct(Mailer $mailer, ReserveContractServiceCrud $reserveContractServiceCrud, UserService $userService)
    {
        $this->mailer = $mailer;
        $this->reserveContractServiceCrud = $reserveContractServiceCrud;
        $this->userService = $userService;
    }

    /**
     * @param Request $request
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function sendEmailEndReserve(Request $request)
    {
        $queryParams = [
            'reserve_id' => $request->get('reserve_id'),
            'email_financial' => $request->get('email_financial'),
            'email_aux_rent' => $request->get('email_aux_rent')
        ];

        $data = $this->reserveContractServiceCrud->find($queryParams['reserve_id']);

        // financeiro
        if ($queryParams['email_financial']) {

            $emailTo = $queryParams['email_financial'];
            $nameTo = "Financeiro Master Imóveis";
            $subject = "Geração de Boleto";

            $dataBodyMail = [
                'data' => [
                    'text_mail' => '<tr>
                                    <td class="content-block">
                                        Gerar boleto para o contrato firmado nº <strong>' .uppercase($data->contract). '</strong>.
                                    </td>
                                </tr>
                                <tr>
                                    <td class="content-block">
                                        Atenciosamente, <strong>' .uppercase($this->userService->getNameById()). '</strong>.
                                    </td>
                                </tr>'
                ],
                'view' => 'email.internalNotification'
            ];

            $this->mailer->config($emailTo, $nameTo , $subject, $dataBodyMail)->send();
        }

        // aux aluguel
        if ($queryParams['email_aux_rent']) {

            $emailTo = $queryParams['email_aux_rent'];
            $nameTo = "Aluguel Master Imóveis";
            $subject = "Retirada Imóvel do Site";

            $dataBodyMail = [
                'data' => [
                    'text_mail' => '<tr>
                                    <td class="content-block">
                                        Retirar o imóvel do site código nº <strong>' .uppercase($data->immobile_code). '</strong>.
                                    </td>
                                </tr>
                                <tr>
                                    <td class="content-block">
                                        Atenciosamente, <strong>' .uppercase($this->userService->getNameById()). '</strong>.
                                    </td>
                                </tr>'
                ],
                'view' => 'email.internalNotification'
            ];

            $this->mailer->config($emailTo, $nameTo , $subject, $dataBodyMail)->send();
        }


    }
}
