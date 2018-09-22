<?php

namespace Modules\Register\Http\Controllers;

use App\Helpers\Mailer;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Register\Presenters\ReserveSendLetter\ReserveSendLetterPresenter;
use Modules\Register\Services\ReserveContract\ReserveContractServiceCrud;
use Modules\Register\Services\ReserveHistoric\ReserveHistoricServiceCrud;
use Modules\Register\Services\ReserveSendLetter\ReserveSendLetterServiceCrud;
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
    /**
     * @var ReserveSendLetterServiceCrud
     */
    private $reserveSendLetterServiceCrud;
    /**
     * @var ReserveHistoricServiceCrud
     */
    private $reserveHistoricServiceCrud;

    public function __construct(Mailer $mailer, ReserveContractServiceCrud $reserveContractServiceCrud, UserService $userService, ReserveSendLetterServiceCrud $reserveSendLetterServiceCrud
                                , ReserveHistoricServiceCrud $reserveHistoricServiceCrud)
    {
        $this->mailer = $mailer;
        $this->reserveContractServiceCrud = $reserveContractServiceCrud;
        $this->userService = $userService;
        $this->reserveSendLetterServiceCrud = $reserveSendLetterServiceCrud;
        $this->reserveHistoricServiceCrud = $reserveHistoricServiceCrud;
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


    /**
     * Consulta os emails de cartas que foram enviados
     * @param $reserveId
     * @return array
     */
    public function queryEmailLetter($reserveId)
    {
        $emailData = $this->reserveSendLetterServiceCrud->findWhere(['reserve_id' => $reserveId], ReserveSendLetterPresenter::class);


        // email aviso ao locador, dados do contrato
        $ownerContractData = collect($emailData['data'])->where('letter_name', 'email_send_owner')->toArray();

        sort($ownerContractData);

        // aviso ao condominio novo inquilino
        $condominiumContractData = collect($emailData['data'])->where('letter_name', 'email_send_condominium')->toArray();

        sort($condominiumContractData);


        // email de boas vindas ao inquilino
        $welcomeTenant = collect($emailData['data'])->where('letter_name', 'email_send_tenant')->toArray();

        sort($welcomeTenant);


        return [
            'owner_contract' => [
                'letter_name' => 'Email de aviso ao locador dos dados do contrato',
                'rp_last_action' => count($ownerContractData) ? $ownerContractData[0]['rp_last_action_name'] : '',
                'date_last_update' => count($ownerContractData) ? $ownerContractData[0]['updated_at'] : null
            ],
            'condominium_contract' => [
                'letter_name' => 'Email ao condominio nova locação',
                'rp_last_action' => count($condominiumContractData) ? $condominiumContractData[0]['rp_last_action_name'] : '',
                'date_last_update' => count($condominiumContractData) ? $condominiumContractData[0]['updated_at'] : null
            ],
            'welcome_tenant' => [
                'letter_name' => 'Email de boas vindas ao locatário',
                'rp_last_action' => count($welcomeTenant) ? $welcomeTenant[0]['rp_last_action_name'] : '',
                'date_last_update' => count($welcomeTenant) ? $welcomeTenant[0]['updated_at'] : null
            ]
        ];
    }


    /**
     * Envio de emails
     *  - Aviso ao proprietário de nova locação
     *  - Aviso ao condominio (se houver)
     *  - Email de boas vindas ao locatário
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|mixed|\Symfony\Component\HttpFoundation\Response
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function sendEmailLetters(Request $request)
    {
        $queryParams = [
            'email_send' => $request->get('email_send'),
            'text_letter' => $request->get('text_letter'),
            'reserve_id' => $request->get('reserve_id'),
            'type_email' => $request->get('type_email'),
        ];

        $typeEmail = '';

        if ($queryParams['type_email'] == 'email_send_owner') {
            $typeEmail = "AVISO AO LOCADOR DOS DADOS DO CONTRATO";
        }

        if ($queryParams['type_email'] == 'email_send_condominium') {
            $typeEmail = "EMAIL AO CONDOMINIO NOVA LOCACAO";
        }

        if ($queryParams['type_email'] == 'email_send_tenant') {
            return $this->sendEmailWelcomeTenant($queryParams);
        }

        $emailTo = $queryParams['email_send'];
        $nameTo = "Aluguel Master Imóveis";
        $subject = "Notificação de Locação";

        $dataBodyMail = [
            'data' => [
                'text_mail' => $queryParams['text_letter']
            ],
            'view' => 'register::reserve.email.notificationLetter'
        ];

        $this->mailer->config($emailTo, $nameTo , $subject, $dataBodyMail)->send();

        // depois do envio do email gravar em base de dados
        $paramsData = [
            'letter_name' => $queryParams['type_email'],
            'reserve_id' => $queryParams['reserve_id'],
            'rp_last_action' => Auth::user()->id,
        ];

        $check = $this->reserveSendLetterServiceCrud->findWhere(['reserve_id' => $queryParams['reserve_id'], 'letter_name' => $queryParams['type_email']]);

        if ($check->count()) {
            $paramsData['updated_at'] = date('Y-m-d H:i:s');
            $dataActionDb = $this->reserveSendLetterServiceCrud->update($paramsData, $check[0]['id']);
        } else {
            $dataActionDb = $this->reserveSendLetterServiceCrud->create($paramsData);
        }

        // gravo no historico ação
        if (isset($dataActionDb->id)) {
            $dataHistoric = [
                'historic' => '<p> O usuário ' . uppercase($this->userService->getNameById()) . ' enviou email de '.$typeEmail.' com os seguintes dados: </p> <br /> <br />' . $queryParams['text_letter'],
                'rp_last_action' => Auth::user()->id,
                'reserve_id' => $queryParams['reserve_id']
            ];

            $this->reserveHistoricServiceCrud->create($dataHistoric);
        }

        return $dataActionDb;
    }

    /**
     * Email de boas vindas ao locatário
     * @param array $params
     * @return \Illuminate\Contracts\Routing\ResponseFactory|mixed|\Symfony\Component\HttpFoundation\Response
     * @throws \PHPMailer\PHPMailer\Exception
     */
    private function sendEmailWelcomeTenant(array $params)
    {

        $emailTo = $params['email_send'];
        $nameTo = "Aluguel Master Imóveis";
        $subject = "Seja bem vindo a Master netimoveis";

        $configAttachment = [
            'use_logo' => false,
            'welcome_tenant' => true,
            'manual_tenant' => true,
        ];

        $dataBodyMail = [
            'data' => [
                'text_mail' => $params['text_letter']
            ],
            'view' => 'register::reserve.email.welcomeTenant'
        ];

        $this->mailer->config($emailTo, $nameTo , $subject, $dataBodyMail, null, null, $configAttachment)->send();


        // depois do envio do email gravar em base de dados
        $paramsData = [
            'letter_name' => $params['type_email'],
            'reserve_id' => $params['reserve_id'],
            'rp_last_action' => Auth::user()->id,
        ];

        $check = $this->reserveSendLetterServiceCrud->findWhere(['reserve_id' => $params['reserve_id'], 'letter_name' => $params['type_email']]);

        if ($check->count()) {
            $paramsData['updated_at'] = date('Y-m-d H:i:s');
            $dataActionDb = $this->reserveSendLetterServiceCrud->update($paramsData, $check[0]['id']);
        } else {
            $dataActionDb = $this->reserveSendLetterServiceCrud->create($paramsData);
        }

        // gravo no historico ação
        if (isset($dataActionDb->id)) {
            $dataHistoric = [
                'historic' => '<p> O usuário ' . uppercase($this->userService->getNameById()) . ' enviou email de boas vindas ao locatário',
                'rp_last_action' => Auth::user()->id,
                'reserve_id' => $params['reserve_id']
            ];

            $this->reserveHistoricServiceCrud->create($dataHistoric);
        }

        return $dataActionDb;
    }
}
