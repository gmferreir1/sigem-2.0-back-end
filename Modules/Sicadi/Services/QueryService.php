<?php

namespace Modules\Sicadi\Services;


use Modules\Sicadi\Repositories\ClientContractRepository;
use Modules\Sicadi\Repositories\ClientRepository;
use Modules\Sicadi\Repositories\ImmobileRepository;
use Modules\Sicadi\Repositories\ImmobileTypeRepository;
use Modules\Sicadi\Repositories\PhoneRepository;
use Modules\Sicadi\Repositories\ReceiptTenantRepository;
use Modules\Sicadi\Repositories\TenantAllContractRepository;

class QueryService
{
    /**
     * @var TenantAllContractRepository
     */
    private $tenantAllContractRepository;
    /**
     * @var ReceiptTenantRepository
     */
    private $receiptTenantRepository;
    /**
     * @var PhoneRepository
     */
    private $phoneRepository;
    /**
     * @var ClientRepository
     */
    private $clientRepository;
    /**
     * @var ClientContractRepository
     */
    private $clientContractRepository;
    /**
     * @var ImmobileRepository
     */
    private $immobileRepository;
    /**
     * @var ImmobileTypeRepository
     */
    private $immobileTypeRepository;

    public function __construct(TenantAllContractRepository $tenantAllContractRepository, ReceiptTenantRepository $receiptTenantRepository,
                                PhoneRepository $phoneRepository, ClientRepository $clientRepository, ClientContractRepository $clientContractRepository,
                                ImmobileRepository $immobileRepository, ImmobileTypeRepository $immobileTypeRepository)
    {
        $this->tenantAllContractRepository = $tenantAllContractRepository;
        $this->receiptTenantRepository = $receiptTenantRepository;
        $this->phoneRepository = $phoneRepository;
        $this->clientRepository = $clientRepository;
        $this->clientContractRepository = $clientContractRepository;
        $this->immobileRepository = $immobileRepository;
        $this->immobileTypeRepository = $immobileTypeRepository;
    }

    /**
     * Retorna dados do imovel
     * (busca pelo contrato)
     * @param string $contract
     * @param boolean $getGuarantors
     * @return mixed
     */
    public function getImmobileDataPerContract(string $contract, $getGuarantors = false)
    {

        $data = $this->tenantAllContractRepository->scopeQuery(function ($query) use ($contract) {
            return $query->where('tenant_all_contracts.contract_code', 'like', '%'.$contract.'%')
                ->join('contracts', 'tenant_all_contracts.contract_code', '=', 'contracts.contract_code')
                ->join('immobiles', 'tenant_all_contracts.immobile_id', '=', 'immobiles.immobile_id')
                ->join('clients', 'immobiles.owner_code', '=', 'clients.client_id_sicadi')
                ->select('tenant_all_contracts.contract_id', 'tenant_all_contracts.contract_code as contract'
                    ,'tenant_all_contracts.client_name as tenant', 'tenant_all_contracts.client_id_sicadi as tenant_id'
                    ,'immobiles.immobile_code', 'immobiles.address', 'immobiles.neighborhood'
                    , 'immobiles.immobile_code', 'contracts.address'
                    , 'contracts.neighborhood', 'contracts.init_date_current_contract'
                    , 'immobiles.type_occupation as type_location', 'immobiles.type_immobile as immobile_type', 'immobiles.immobile_id as immobile_type_id'
                    , 'immobiles.type_immobile_id', 'immobiles.condominium_id', 'immobiles.condominium_syndicate'
                    , 'immobiles.condominium_address', 'immobiles.condominium_neighborhood'
                    , 'immobiles.condominium_city', 'immobiles.condominium_state', 'immobiles.condominium_cep as condominium_zip_code', 'immobiles.condominium_email'
                    ,'clients.client_name as owner', 'clients.client_id_sicadi as owner_id', 'clients.email as owner_email')
                ->orderBy('immobiles.address', 'ASC');
        })->all();


        /*
         * Dados do recibo
         */
        foreach ($data as $key => $item_value) {

            $receipt = $this->receiptTenantRepository->scopeQuery(function ($query) use ($item_value) {
                return $query->where('contract_id', $item_value['contract_id'])
                    ->orderBy('payment_date', 'DESC');
            })->first();

            if (isset($receipt->value_base)) {
                $data[$key]['value'] = (float)$receipt->value_base;
            } else {
                $data[$key]['value'] = (float)$item_value['value_rent'];
            }

            /*
             * Telefones do inquilino
             */
            $tenantData = $this->getClientData(['client_id_sicadi' => $data[$key]['tenant_id']]);
            $tenantPhones = $this->getClientPhones($data[$key]['tenant_id']);

            $data[$key]['tenant'] = $tenantData['client_name'];
            $data[$key]['tenant_email'] = $tenantData['email'];
            $data[$key]['tenant_phone_residential'] = $tenantPhones['residential'];
            $data[$key]['tenant_phone_commercial'] = $tenantPhones['commercial'];
            $data[$key]['tenant_cell_phone'] = $tenantPhones['cell_phone'];

           /*
            * Telefones do proprietário
            */
            $tenantPhones = $this->getClientPhones($data[$key]['owner_id']);
            $data[$key]['owner_phone_residential'] = $tenantPhones['residential'];
            $data[$key]['owner_phone_commercial'] = $tenantPhones['commercial'];
            $data[$key]['owner_cell_phone'] = $tenantPhones['cell_phone'];

            /*
             * Dados dos fiadores
             */
            if ($getGuarantors) {
                $data[$key]['guarantors'] = $this->getGuarantors($data[$key]['contract']);
            }
        }


        return $data;
    }

    public function getImmobileDataPerCode(string $immobileCode)
    {
        $data = $this->immobileRepository->scopeQuery(function ($query) use ($immobileCode) {
            return $query->where('immobile_code', 'like', '%' . $immobileCode . '%')
                ->join('clients', 'immobiles.owner_code', '=', 'clients.client_id_sicadi')
                ->select('immobiles.immobile_code', 'immobiles.address', 'immobiles.neighborhood'
                    , 'immobiles.city', 'immobiles.state', 'immobiles.zip_code', 'immobiles.value_rent as value'
                    , 'immobiles.type_immobile', 'immobiles.type_occupation as type_location', 'immobiles.iptu', 'immobiles.type_immobile_id'
                    , 'clients.client_id_sicadi as client_id', 'clients.client_name as owner', 'clients.email as owner_email');
        })->all();

        if ($data->count()) {

            foreach ($data as $key => $item) {

                /*
                 * Valor
                 */
                $data[$key]['value'] = (float)$item['value'];

                /*
                 * Tipo de locação
                 */
                $item['type_location'] = $item['type_location'] ? ($item['type_location'] == 're' ? 'r' : 'c') : null;

                /*
                 * Pega os telefones
                 */
                $phones = $this->getClientPhones($item['client_id']);

                $data[$key]['owner_phone_residential'] = $phones['residential'];
                $data[$key]['phone_commercial'] = $phones['commercial'];
                $data[$key]['owner_cell_phone'] = $phones['cell_phone'];
            }

            return $data;
        }

        return [];
    }

    /**
     * Retorna os dados de um imovel pelo código
     * @param string $immobileCode
     * @return array|mixed
     */
    public function getImmobileData(string $immobileCode)
    {
        $data = $this->immobileRepository->scopeQuery(function ($query) use ($immobileCode) {
            return $query->where('immobile_code', $immobileCode)
                ->join('clients', 'immobiles.owner_code', '=', 'clients.client_id_sicadi')
                ->select('immobiles.immobile_code', 'immobiles.address', 'immobiles.neighborhood'
                    , 'immobiles.city', 'immobiles.state', 'immobiles.zip_code', 'immobiles.value_rent as value'
                    , 'immobiles.type_immobile', 'immobiles.type_occupation as type_location', 'immobiles.iptu', 'immobiles.type_immobile_id'
                    , 'clients.client_id_sicadi as client_id', 'clients.client_name as owner', 'clients.email as owner_email');
        })->all();

        if ($data->count()) {

            $data[0]['value'] = (float) $data[0]['value'];

            return $data[0];
        }

        return [];
    }


    /**
     * Dados dos fiadores
     * @param string $contract
     * @return array
     */
    public function getGuarantors(string $contract)
    {
        $contractData = $this->tenantAllContractRepository->findWhere(['contract_code' => $contract]);

        $data = [];

        if (count($contractData) > 0) {

            $contractId = $contractData[0]['contract_id'];
            $guarantors = $this->clientContractRepository->findWhere(['contract_id' => $contractId, 'type_client_contract' => 'f']);

            if (count($guarantors) > 0) {

                foreach ($guarantors as $key => $item) {

                    $clientData = $this->getClientData(['client_id_sicadi' => $item['client_id']]);

                    if (count($clientData) > 0) {

                        /*
                         * Pega os telefones
                         */
                        $phones = $this->getClientPhones($item['client_id']);

                        $data[$key] = [
                            'guarantors_name' => uppercase($clientData['client_name']),
                            'guarantors_email' => $clientData['email'],
                            'guarantors_phone_residential' => format_phone($phones['residential']),
                            'guarantors_phone_commercial' => format_phone($phones['commercial']),
                            'guarantors_cell_phone' => format_phone($phones['cell_phone'])
                        ];

                    }

                }

            }

        }

        return $data;
    }

    /**
     * Retorna os tipos de imóveis disponiveis
     */
    public function getTypesImmobileAvailable()
    {
        $closure = function ($query) {
            return $query->select('type_immobile_id as id', 'name_type_immobile as name')
                ->orderBy('name_type_immobile', 'ASC');
        };

        return $this->immobileTypeRepository->scopeQuery($closure)->all();
    }


    /**
     * Retorna os telefones
     * @param $clientId
     * @return array
     */
    private function getClientPhones($clientId)
    {

        $phoneResidential = $this->phoneRepository->findWhere(['client_id' => $clientId, 'type_phone' => 'residencial']);
        $phoneCommercial = $this->phoneRepository->findWhere(['client_id' => $clientId, 'type_phone' => 'comercial']);
        $cellPhone = $this->phoneRepository->findWhere(['client_id' => $clientId, 'type_phone' => 'celular']);

        return [
            'residential' => count($phoneResidential) ? $phoneResidential[0]['ddd'] . $phoneResidential[0]['phone'] : null,
            'commercial' => count($phoneCommercial) ? $phoneCommercial[0]['ddd'] . $phoneCommercial[0]['phone'] : null,
            'cell_phone' => count($cellPhone) ? $cellPhone[0]['ddd'] . $cellPhone[0]['phone'] : null,
        ];
    }

    /**
     * Retorna os dados do cliente
     * @param array $param
     * @return array
     */
    private function getClientData(array $param)
    {
        $clientData = $this->clientRepository->findWhere($param);

        if (count($clientData)) {
            return $clientData[0];
        }

        return [];
    }
}