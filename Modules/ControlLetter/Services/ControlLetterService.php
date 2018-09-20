<?php

namespace Modules\ControlLetter\Services;


use Carbon\Carbon;
use Modules\Sicadi\Services\QueryService;

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

    public function __construct(ControlLetterServiceCrud $serviceCrud, QueryService $queryService)
    {
        $this->serviceCrud = $serviceCrud;
        $this->queryService = $queryService;
    }

    public function mountLetter(string $typeLetter, array $data)
    {
        // carta de aviso ao locador dos dados do contrato
        if ($typeLetter === 'email_send_owner') {
            return $this->letterNotificationOwner($data);
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
            '@NOME_PROPRIETARIO',
            '@CODIGO_PROPRIETARIO',
            '@ENDERECO_PROPRIETARIO',
            '@BAIRRO_PROPRIETARIO',
            '@CIDADE_PROPRIETARIO',
            '@ESTADO_PROPRIETARIO',
            '@CEP_PROPRIETARIO',
            '@CONTRATO',
            '@ENDERECO_IMOVEL',
            '@BAIRRO_IMOVEL',
            '@CEP',
            '@CIDADE',
            '@ESTADO',
            '@VALOR_ALUGUEL',
            '@PRAZO_CONTRATO',
            '@DATA_INICIO_CONTRATO',
            '@DATA_FIM_CONTRATO',
            '@DATA_PRIMEIRO_ALUGUEL'
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
            $datePrimaryRent
        ];

        return str_replace($fieldsSearch, $replace, $letterData[0]);
    }


    private function getLetterData(string $letterName)
    {
        return $this->serviceCrud->findWhere(['name' => $letterName]);
    }
}