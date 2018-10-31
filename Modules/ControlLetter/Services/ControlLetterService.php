<?php

namespace Modules\ControlLetter\Services;


use Carbon\Carbon;
use Modules\Sicadi\Services\QueryService;
use Modules\User\Services\UserService;

class ControlLetterService
{
    /**
     * @var ControlLetterServiceCrud
     */
    private $serviceCrud;
    /**
     * @var QueryService
     */
    private $queryService;
    /**
     * @var UserService
     */
    private $userService;

    public function __construct(ControlLetterServiceCrud $serviceCrud, QueryService $queryService, UserService $userService)
    {
        $this->serviceCrud = $serviceCrud;
        $this->queryService = $queryService;
        $this->userService = $userService;
    }

    public function mountLetter(string $typeLetter, array $data)
    {
        // carta de aviso ao locador dos dados do contrato
        if ($typeLetter === 'email_send_owner') {
            return $this->letterNotificationOwner($data);
        }

        // carta de aviso ao condominio
        if ($typeLetter === 'email_send_condominium') {
            return $this->letterNotificationCondominium($data);
        }

        // carta de aviso ao condominio
        if ($typeLetter === 'email_send_tenant') {
            return $this->sendEmailTenant($data);
        }

        $message[] = "Nenhuma carta encontrada !";

        return [
            'error' => true,
            'message' => response($message, 422)
        ];
    }

    /**
     * Carta de notificação ao proprietario com os dados da locação
     * @param array $data
     * @return array|mixed
     */
    private function letterNotificationOwner(array $data)
    {

        $immobileData = $this->queryService->getImmobileData($data['immobile_code']);

        if (!count($immobileData)) {
            $message[] = "Base de dados do SIGEM não atualizada, tente novamente mais tarde !";
            return [
                'error' => true,
                'message' => response($message, 422)
            ];
        }


        $contractData = $this->queryService->getContractData($data['contract']);

        if (!$contractData) {
            $message[] = "Contrato ainda não atualizado na base do SIGEM, tente novamente mais tarde !";
            return [
                'error' => true,
                'message' => response($message, 422)
            ];
        }

        $dateEndContract = Carbon::createFromFormat('d/m/Y', $contractData['init_date_current_contract'])->addMonths($contractData['contract_time'])->format('d/m/Y');
        $datePrimaryRent = !$data['conclusion'] ? '' :  Carbon::createFromFormat('d/m/Y', formatDate($data['conclusion']))->addDays(30)->format('d/m/Y');



        $letterData = $this->getLetterData('notificacao proprietario nova locacao');

        if (!$letterData->count()) {
            $message[] = "Carta não registrada no sistema !";
            return [
                'error' => true,
                'message' => response($message, 422)
            ];
        }


        $fieldsSearch = [
            '@_NOME_PROPRIETARIO',
            '@_CODIGO_PROPRIETARIO',
            '@_ENDERECO_PROPRIETARIO',
            '@_BAIRRO_PROPRIETARIO',
            '@_CIDADE_PROPRIETARIO',
            '@_ESTADO_PROPRIETARIO',
            '@_CEP_PROPRIETARIO',
            '@_CONTRATO',
            '@_ENDERECO_IMOVEL',
            '@_BAIRRO_IMOVEL',
            '@_CEP',
            '@_CIDADE',
            '@_ESTADO',
            '@_VALOR_ALUGUEL',
            '@_PRAZO_CONTRATO',
            '@_DATA_INICIO_CONTRATO',
            '@_DATA_FIM_CONTRATO',
            '@_DATA_PRIMEIRO_ALUGUEL',
            '@_ASSINATURA'
        ];



        $replace = [
            uppercase($immobileData['owner']),
            $immobileData['owner_code'],
            uppercase($immobileData['owner_address']),
            uppercase($immobileData['owner_neighborhood']),
            uppercase($immobileData['owner_city']),
            uppercase($immobileData['owner_state']),
            $immobileData['owner_zip_code'],
            uppercase($data['contract']),
            uppercase($data['address']),
            uppercase($data['neighborhood']),
            $immobileData['zip_code'],
            uppercase($immobileData['city']),
            uppercase($immobileData['state']),
            number_format($data['value_negotiated'], 2, ',', '.'),
            $contractData['contract_time'],
            $contractData['init_date_current_contract'],
            $dateEndContract,
            $datePrimaryRent,
            uppercase($this->userService->getNameById())
        ];

        return [
            'text_letter' => str_replace($fieldsSearch, $replace, $letterData[0]['text']),
            'email_send' => $immobileData['owner_email'],
            'reserve_id' => $data['id'],
            'type_email' => 'email_send_owner'
        ];
    }

    private function letterNotificationCondominium(array $data)
    {

        $immobileData = $this->queryService->getImmobileData($data['immobile_code']);

        if (!count($immobileData)) {
            $message[] = "Base de dados do SIGEM não atualizada, tente novamente mais tarde !";
            return [
                'error' => true,
                'message' => response($message, 422)
            ];
        }

        $contractData = $this->queryService->getContractData($data['contract']);

        if (!count($contractData)) {
            $message[] = "Base de dados do SIGEM não atualizada, tente novamente mais tarde !";
            return [
                'error' => true,
                'message' => response($message, 422)
            ];
        }

        $tenantData = $this->queryService->getTenantDataPerContract($data['contract']);

        if (!count($contractData)) {
            $message[] = "Base de dados do SIGEM não atualizada, tente novamente mais tarde !";
            return [
                'error' => true,
                'message' => response($message, 422)
            ];
        }

        $cicCgc = "";

        $dataCicCjc = onlyNumber($tenantData['cic_cgc']);

        if (strlen($dataCicCjc) == 11) {
            $cicCgc = mask($dataCicCjc, '###.###.###-##');
        }

        if (strlen($dataCicCjc) == 14) {
            $cicCgc = mask($dataCicCjc, '##.###.###/####-##');
        }


        $phones = $tenantData['phone_residential'] . (!$tenantData['phone_commercial'] ? null : ' - ' . $tenantData['phone_commercial']) . (!$tenantData['tenant_cell_phone'] ? null : ' - ' . $tenantData['tenant_cell_phone']);


        $fieldsSearch = [
            '@_NOME_CONDOMINIO_SINDICO',
            '@_ENDERECO_CONDOMINIO',
            '@_BAIRRO_CONDOMINIO',
            '@_CIDADE_CONDOMINIO',
            '@_ESTADO_CONDOMINIO',
            '@_CONTRATO',
            '@_ENDERECO_IMOVEL',
            '@_BAIRRO_IMOVEL',
            '@_CEP',
            '@_CIDADE',
            '@_ESTADO',
            '@_NOME_PROPRIETARIO',
            '@_NOME_INQUILINO',
            '@_CIG_CGC_INQUILINO',
            '@_EMAIL_INQUILINO',
            '@_TELEFONE_INQUILINO',
            '@_DATA_ENTREGA_CHAVES',
            '@_ASSINATURA'
        ];


        $replace = [
            uppercase(!$immobileData['condominium_syndicate'] ? '@_NOME_CONDOMINIO_SINDICO' : $immobileData['condominium_syndicate']),
            uppercase(!$immobileData['condominium_address'] ? '@_ENDERECO_CONDOMINIO' : $immobileData['condominium_address']),
            uppercase(!$immobileData['condominium_neighborhood'] ? '@_BAIRRO_CONDOMINIO' : $immobileData['condominium_neighborhood']),
            uppercase(!$immobileData['condominium_city'] ? '@_CIDADE_CONDOMINIO' : $immobileData['condominium_city']),
            uppercase(!$immobileData['condominium_state'] ? '@_ESTADO_CONDOMINIO' : $immobileData['condominium_state']),
            uppercase($data['contract']),
            uppercase($data['address']),
            uppercase($data['neighborhood']),
            $immobileData['zip_code'],
            uppercase($immobileData['city']),
            uppercase($immobileData['state']),
            uppercase($immobileData['owner']),
            uppercase($contractData['tenant_name']),
            $cicCgc,
            $tenantData['email'],
            $phones,
            date('d/m/Y', strtotime($data['end_process'])),
            uppercase($this->userService->getNameById())
        ];


        $letterData = $this->getLetterData('notificacao condominio nova locacao');

        return [
            'text_letter' => str_replace($fieldsSearch, $replace, $letterData[0]['text']),
            'email_send' => $immobileData['condominium_email'],
            'reserve_id' => $data['id'],
            'type_email' => 'email_send_condominium'
        ];
    }

    private function sendEmailTenant(array $data)
    {
        $tenantData = $this->queryService->getTenantDataPerContract($data['contract']);

        if (!count($tenantData)) {
            $message[] = "Base de dados do SIGEM não atualizada, tente novamente mais tarde !";
            return [
                'error' => true,
                'message' => response($message, 422)
            ];
        }


        $path = public_path().'/storage/images/boas_vindas_locatario.png';
        $file = file_get_contents($path);

        $type = mime_content_type($path);

        $base64 = 'data:' . $type . ';base64,' . base64_encode($file);


        return [
            'text_letter' => $base64,
            'email_send' => $tenantData['email'],
            'reserve_id' => $data['id'],
            'type_email' => 'email_send_tenant',
            'client_name' => $tenantData['client_name']
        ];
    }


    private function getLetterData(string $letterName)
    {
        return $this->serviceCrud->findWhere(['name' => $letterName]);
    }
}