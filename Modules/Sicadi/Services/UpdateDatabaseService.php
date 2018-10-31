<?php

namespace Modules\Sicadi\Services;


use App\Events\ShowTablesUpdated;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Helpers\InterBase\Connection;
use Modules\ManagerAction\Services\ActionDatabaseServiceCrud;
use Modules\Sicadi\Repositories\AddressRepository;
use Modules\Sicadi\Repositories\DjGuideRepository;
use Modules\Sicadi\Repositories\ClientContractRepository;
use Modules\Sicadi\Repositories\ClientRepository;
use Modules\Sicadi\Repositories\ContractRepository;
use Modules\Sicadi\Repositories\ImmobileRepository;
use Modules\Sicadi\Repositories\ImmobileTypeRepository;
use Modules\Sicadi\Repositories\ImmobileVisitRepository;
use Modules\Sicadi\Repositories\InactiveContractRepository;
use Modules\Sicadi\Repositories\PhoneRepository;
use Modules\Sicadi\Repositories\ReceiptTenantCompleteRepository;
use Modules\Sicadi\Repositories\ReceiptTenantRepository;
use Modules\Sicadi\Repositories\TenantAllContractRepository;
use Modules\Sicadi\Repositories\VisitRepository;

class UpdateDataBaseService
{
    private $connection;

    /**
     * @var ClientRepository
     */
    private $clientRepository;
    /**
     * @var ContractRepository
     */
    private $contractRepository;
    /**
     * @var ImmobileRepository
     */
    private $immobileRepository;
    /**
     * @var ImmobileTypeRepository
     */
    private $immobileTypeRepository;
    /**
     * @var ImmobileVisitRepository
     */
    private $immobileVisitRepository;
    /**
     * @var InactiveContractRepository
     */
    private $inactiveContractRepository;
    /**
     * @var TenantAllContractRepository
     */
    private $tenantAllContractRepository;
    /**
     * @var VisitRepository
     */
    private $visitRepository;
    /**
     * @var ReceiptTenantRepository
     */
    private $receiptTenantRepository;
    /**
     * @var ClientContractRepository
     */
    private $clientContractRepository;
    /**
     * @var ReceiptTenantCompleteRepository
     */
    private $receiptTenantCompleteRepository;
    /**
     * @var DjGuideRepository
     */
    private $djGuideRepository;
    /**
     * @var PhoneRepository
     */
    private $phoneRepository;
    /**
     * @var AddressRepository
     */
    private $addressRepository;
    /**
     * @var ActionDatabaseServiceCrud
     */
    private $actionDatabaseServiceCrud;


    function __construct(ClientRepository $clientRepository
        , ContractRepository $contractRepository
        , ImmobileRepository $immobileRepository
        , ImmobileTypeRepository $immobileTypeRepository
        , ImmobileVisitRepository $immobileVisitRepository
        , InactiveContractRepository $inactiveContractRepository
        , TenantAllContractRepository $tenantAllContractRepository
        , VisitRepository $visitRepository
        , ReceiptTenantRepository $receiptTenantRepository
        , ClientContractRepository $clientContractRepository
        , ReceiptTenantCompleteRepository $receiptTenantCompleteRepository
        , DjGuideRepository $djGuideRepository
        , PhoneRepository $phoneRepository
        , AddressRepository $addressRepository
        , ActionDatabaseServiceCrud $actionDatabaseServiceCrud)
    {
        $this->clientRepository = $clientRepository;
        $this->contractRepository = $contractRepository;
        $this->immobileRepository = $immobileRepository;
        $this->immobileTypeRepository = $immobileTypeRepository;
        $this->immobileVisitRepository = $immobileVisitRepository;
        $this->inactiveContractRepository = $inactiveContractRepository;
        $this->tenantAllContractRepository = $tenantAllContractRepository;
        $this->visitRepository = $visitRepository;
        $this->receiptTenantRepository = $receiptTenantRepository;
        $this->clientContractRepository = $clientContractRepository;
        $this->receiptTenantCompleteRepository = $receiptTenantCompleteRepository;
        $this->djGuideRepository = $djGuideRepository;
        $this->phoneRepository = $phoneRepository;
        $this->addressRepository = $addressRepository;
        $this->actionDatabaseServiceCrud = $actionDatabaseServiceCrud;
    }

    /**
     * Inicia o processo de atualização
     */
    public function initProcessUpdateReadDatabase()
    {

        // limites para o upload
        ini_set('memory_limit', '500000M');
        ini_set('upload_max_filesize', '500000M');
        ini_set('post_max_size', '500000M');
        ini_set('max_input_time', 0);
        ini_set('max_execution_time', 0);



        $file_name = Storage::disk('local')->allFiles('firebird');

        $path_to_file = storage_path('app/').$file_name[0];

        if(count($file_name) > 0) {
            $this->connection = new Connection($path_to_file);
            $this->updateReceiptTenant();
        }
    }

    /**
     * Atualização tabela RECIBO_INQUILINO
     */
    private function updateReceiptTenant()
    {

        Log::info('Atualização tabela RECIBO_INQUILINO disparada');

        $this->actionDatabaseServiceCrud->initUpdateTable('recibo inquilino');
        // real time
        event(new ShowTablesUpdated());


        $sql = 'SELECT RECIBO_INQUILINO.VALOR_PAGO, RECIBO_INQUILINO.CONTRATO_ID, RECIBO_INQUILINO.DATA_VENCIMENTO, RECIBO_INQUILINO.DATA_PAGAMENTO,
                RECIBO_INQUILINO.VALOR_BASE
                FROM RECIBO_INQUILINO WHERE RECIBO_INQUILINO.DATA_PAGAMENTO IS NOT NULL';

        $resultArray = $this->connection->query($sql);

        $this->receiptTenantRepository->truncate();

        for($i = 0; $i < count($resultArray); $i++) {

            if($resultArray[$i]['CONTRATO_ID'] != null) {

                $data_created = [
                    'payment_date' => $resultArray[$i]['DATA_PAGAMENTO'],
                    'maturity_date' => $resultArray[$i]['DATA_VENCIMENTO'],
                    'value_last_payment' => $resultArray[$i]['VALOR_PAGO'],
                    'value_base' => $resultArray[$i]['VALOR_BASE'],
                    'contract_id' => $resultArray[$i]['CONTRATO_ID'],
                ];

                $this->receiptTenantRepository->create($data_created);
            }
        }

        $this->actionDatabaseServiceCrud->endUpdateTable('recibo inquilino');
        // real time
        event(new ShowTablesUpdated());

        Log::info('Atualização tabela RECIBO_INQUILINO finalizada');

        $this->updateReceiptTenantComplete();

    }

    /**
     * Atualização tabela RECIBO_INQUILINO_CUSTOM
     */
    private function updateReceiptTenantComplete()
    {
        Log::info('Atualização tabela RECIBO_INQUILINO CUSTOM disparada');

        $this->actionDatabaseServiceCrud->initUpdateTable('recibo inquilino completa');
        // real time
        event(new ShowTablesUpdated());

        $sql = 'SELECT RECIBO_INQUILINO.RECIBO_INQUILINO_ID, RECIBO_INQUILINO.VALOR_PAGO, RECIBO_INQUILINO.VALOR, RECIBO_INQUILINO.CONTRATO_ID, RECIBO_INQUILINO.DATA_VENCIMENTO, 
                RECIBO_INQUILINO.DATA_PAGAMENTO, RECIBO_INQUILINO.VALOR_BASE, RECIBO_INQUILINO.MES_SERIE,
                (SELECT FIRST 1 CONTROLE_CONTRATUAL.VALOR_ALUGUEL
                                     FROM CONTROLE_CONTRATUAL
                                     WHERE (CONTROLE_CONTRATUAL.CONTRATO_ID = RECIBO_INQUILINO.CONTRATO_ID)
                                     ORDER BY CONTROLE_CONTRATUAL_ID DESC) VALOR_ALUGUEL
                FROM RECIBO_INQUILINO';

        $resultArray = $this->connection->query($sql);

        $this->receiptTenantCompleteRepository->truncate();

        for($i = 0; $i < count($resultArray); $i++) {

            if($resultArray[$i]['CONTRATO_ID'] != null) {

                $data_created = [
                    'receipt_tenant_id' => $resultArray[$i]['RECIBO_INQUILINO_ID'],
                    'payment_date' => $resultArray[$i]['DATA_PAGAMENTO'],
                    'due_date' => $resultArray[$i]['DATA_VENCIMENTO'],
                    'value' => $resultArray[$i]['VALOR'],
                    'value_pay' => $resultArray[$i]['VALOR_PAGO'],
                    'value_base' => $resultArray[$i]['VALOR_BASE'],
                    'value_rent' => $resultArray[$i]['VALOR_ALUGUEL'],
                    'month_serie' => $resultArray[$i]['MES_SERIE'],
                    'contract_id' => $resultArray[$i]['CONTRATO_ID'],
                ];

                $this->receiptTenantCompleteRepository->create($data_created);
            }
        }

        Log::info('Atualização tabela RECIBO_INQUILINO CUSTOM finalizada');

        $this->actionDatabaseServiceCrud->endUpdateTable('recibo inquilino completa');
        // real time
        event(new ShowTablesUpdated());

        $this->updateClientContract();

    }

    /**
     * Atualização tabela CLIENTE_CONTRATO
     */
    private function updateClientContract()
    {
        Log::info('Atualização tabela CLIENTE_CONTRATO disparada');

        $this->actionDatabaseServiceCrud->initUpdateTable('cliente contrato');
        // real time
        event(new ShowTablesUpdated());

        $sql = 'SELECT * FROM CLIENTE_CONTRATO';

        $resultArray = $this->connection->query($sql);

        $this->clientContractRepository->truncate();

        for($i = 0; $i < count($resultArray); $i++) {

            if($resultArray[$i]['CONTRATO_ID'] != null) {

                $data_created = [
                    'client_id' => $resultArray[$i]['CLIENTE_ID'],
                    'contract_id' => $resultArray[$i]['CONTRATO_ID'],
                    'type_client_contract' => $resultArray[$i]['TIPO_CLIENTE_CONTRATO'],
                    'main' => $resultArray[$i]['PRINCIPAL'],
                ];

                $this->clientContractRepository->create($data_created);
            }
        }

        Log::info('Atualização tabela CLIENTE_CONTRATO finalizada');

        $this->actionDatabaseServiceCrud->endUpdateTable('cliente contrato');
        // real time
        event(new ShowTablesUpdated());

        $this->updateVisitTable();
    }

    /**
     * Atualização da tabela VISITA
     */
    private function updateVisitTable()
    {
        Log::info('Atualização tabela VISITA disparada');

        $this->actionDatabaseServiceCrud->initUpdateTable('visita');
        // real time
        event(new ShowTablesUpdated());

        $sql = 'Select * from VISITA';

        $resultArray = $this->connection->query($sql);

        $this->visitRepository->truncate();

        for($i = 0; $i < count($resultArray); $i++) {

            if($resultArray[$i]['VISITA_ID'] != null) {

                $data_created = [
                    'visit_id' => $resultArray[$i]['VISITA_ID'],
                    'client_name' => $resultArray[$i]['NOME_CLIENTE'],
                    'address' => $resultArray[$i]['ENDERECO'],
                    'neighborhood' => $resultArray[$i]['BAIRRO'],
                    'city' => $resultArray[$i]['CIDADE'],
                    'state' => $resultArray[$i]['ESTADO'],
                    'zip_code' => $resultArray[$i]['CEP'],
                    'phone_commercial' => $resultArray[$i]['FONE_COMERCIAL'],
                    'phone_residential' => $resultArray[$i]['FONE_RESIDENCIAL'],
                    'cell_phone' => $resultArray[$i]['FONE_CELULAR'],
                    'email'  => $resultArray[$i]['E_MAIL'],
                    'date_register' => $resultArray[$i]['DATA_CADASTRO'],
                ];

                $this->visitRepository->create($data_created);
            }
        }

        Log::info('Atualização tabela VISITA finalizada');

        $this->actionDatabaseServiceCrud->endUpdateTable('visita');
        // real time
        event(new ShowTablesUpdated());

        $this->updateVisitImmobileTable();
    }

    /**
     * Atualização da tabela VISITA_IMOVEL
     */
    private function updateVisitImmobileTable()
    {
        Log::info('Atualização tabela VISITA_IMOVEL disparada');

        $this->actionDatabaseServiceCrud->initUpdateTable('visita imovel');
        // real time
        event(new ShowTablesUpdated());

        $sql = "SELECT VISITA_IMOVEL.VISITA_ID, VISITA_IMOVEL.COMENTARIO, VISITA_IMOVEL.TIPO_VISITA, VISITA_IMOVEL.VISITA_RESERVA,
                       VISITA_IMOVEL.IMOVEL_ID, VISITA_IMOVEL.TIPO_VISITA, VISITA_IMOVEL.VISITA_RESERVA, VISITA_IMOVEL.ENTREGA_CHAVES,
                       IMOVEL.CODIGO, IMOVEL.ENDERECO, IMOVEL.BAIRRO, IMOVEL.NOME_EDIFICIO, 
                       IMOVEL.TIPO_IMOVEL_ID, IMOVEL.DISPONIVEL_LOCACAO, IMOVEL.VALOR_ALUGUEL, IMOVEL.ALUGADO,
                       TIPO_IMOVEL.NOME_TIPO_IMOVEL,
                       CONDOMINIO.NOME_CONDOMINIO
                       FROM VISITA_IMOVEL
                       LEFT JOIN IMOVEL ON (IMOVEL.IMOVEL_ID = VISITA_IMOVEL.IMOVEL_ID)
                       LEFT JOIN TIPO_IMOVEL ON (TIPO_IMOVEL.TIPO_IMOVEL_ID = IMOVEL.TIPO_IMOVEL_ID)
                       LEFT JOIN CONDOMINIO ON (CONDOMINIO.CONDOMINIO_ID = IMOVEL.CONDOMINIO_ID)";


        $resultArray = $this->connection->query($sql);



        $this->immobileVisitRepository->truncate();

        for($i = 0; $i < count($resultArray); $i++) {

            if($resultArray[$i]['VISITA_ID'] != null) {

                $data_create = [
                    'immobile_id' => (int) $resultArray[$i]['IMOVEL_ID'],
                    'immobile_code' => $resultArray[$i]['CODIGO'],
                    'address' => $resultArray[$i]['ENDERECO'],
                    'neighborhood' => $resultArray[$i]['BAIRRO'],
                    'building_name' => $resultArray[$i]['NOME_EDIFICIO'],
                    'condominium_name' => $resultArray[$i]['NOME_CONDOMINIO'],
                    'type_immobile_id' => (int) $resultArray[$i]['TIPO_IMOVEL_ID'] ,
                    'value_rent' => $resultArray[$i]['VALOR_ALUGUEL'],
                    'available_rental' =>  $resultArray[$i]['DISPONIVEL_LOCACAO'],
                    'rent' =>  $resultArray[$i]['ALUGADO'],
                    'type_immobile' => $resultArray[$i]['NOME_TIPO_IMOVEL'],
                    'visit_id' => $resultArray[$i]['VISITA_ID'],
                    'commentary' => $resultArray[$i]['COMENTARIO'],
                    'type_visit' => $resultArray[$i]['TIPO_VISITA'],
                    'visit_reserve' => $resultArray[$i]['VISITA_RESERVA'],
                    'date' => $resultArray[$i]['ENTREGA_CHAVES'],
                ];

                $this->immobileVisitRepository->create($data_create);
            }

        }

        Log::info('Atualização tabela VISITA_IMOVEL finalizada');

        $this->actionDatabaseServiceCrud->endUpdateTable('visita imovel');
        // real time
        event(new ShowTablesUpdated());

        $this->updateCompleteClientTable();
    }

    /**
     * Atualização da tabela V_CLIENTE_COMPLETA
     */
    private function updateCompleteClientTable()
    {
        Log::info('Atualização tabela V_CLIENTE_COMPLETA disparada');

        $this->actionDatabaseServiceCrud->initUpdateTable('cliente');
        // real time
        event(new ShowTablesUpdated());

        $sql = "SELECT CLIENTE.CLIENTE_ID, CLIENTE.CODIGO, CLIENTE.NOME, CLIENTE.TIPO_CLIENTE, CLIENTE.DATA_NASCIMENTO
                , CLIENTE.SEXO, CLIENTE.ESTADO_CIVIL, CLIENTE.RG, CLIENTE.NOME_MAE, CLIENTE.NOME_PAI, CLIENTE.CODIGO_CONJUGE
                , CLIENTE.EMPRESA, CLIENTE.RESPONSAVEL_PESSOA_JURIDICA, CLIENTE.CIC_CGC, CLIENTE.E_MAIL
                FROM CLIENTE";

        $resultArray = $this->connection->query($sql);

        $this->clientRepository->truncate();

        for($i = 0; $i < count($resultArray); $i++) {

            $data_create = [
                'client_id_sicadi' => (int) $resultArray[$i]['CLIENTE_ID'],
                'client_code' => $resultArray[$i]['CODIGO'],
                'client_name' => $resultArray[$i]['NOME'],

                'type_client' => $resultArray[$i]['TIPO_CLIENTE'],
                'birth_date' => $resultArray[$i]['DATA_NASCIMENTO'],
                'sex' => $resultArray[$i]['SEXO'],
                'civil_state' => $resultArray[$i]['ESTADO_CIVIL'],
                'rg' => $resultArray[$i]['RG'],
                'mother_name' => $resultArray[$i]['NOME_MAE'],
                'father_name' => $resultArray[$i]['NOME_PAI'],
                'spouse_code' => $resultArray[$i]['CODIGO_CONJUGE'],
                'company' => $resultArray[$i]['EMPRESA'],
                'responsible_company' => $resultArray[$i]['RESPONSAVEL_PESSOA_JURIDICA'],

                'cic_cgc' => $resultArray[$i]['CIC_CGC'],
                'email' => $resultArray[$i]['E_MAIL']
            ];

            $this->clientRepository->create($data_create);
        }

        Log::info('Atualização tabela V_CLIENTE_COMPLETA finalizada');

        $this->actionDatabaseServiceCrud->endUpdateTable('cliente');
        // real time
        event(new ShowTablesUpdated());

        $this->updateAddressTable();
    }

    /**
     * Atualização da tabela de ENDEREÇO
     */
    private function updateAddressTable()
    {
        Log::info('Atualização tabela ADDRESSES disparada');

        $this->actionDatabaseServiceCrud->initUpdateTable('endereco');
        // real time
        event(new ShowTablesUpdated());

        $sql = "SELECT * FROM ENDERECO";

        $resultArray = $this->connection->query($sql);

        $this->addressRepository->truncate();

        for($i = 0; $i < count($resultArray); $i++) {

            $data_create = [
                'client_id' =>  $resultArray[$i]['CLIENTE_ID'],
                'address' =>  $resultArray[$i]['ENDERECO'],
                'neighborhood' => $resultArray[$i]['BAIRRO'],
                'city' => $resultArray[$i]['CIDADE'],
                'zip_code' => $resultArray[$i]['CEP'],
                'state' => $resultArray[$i]['ESTADO']
            ];

            $this->addressRepository->create($data_create);
        }

        Log::info('Atualização tabela ADDRESSES finalizada');

        $this->actionDatabaseServiceCrud->endUpdateTable('endereco');
        // real time
        event(new ShowTablesUpdated());

        $this->updatePhoneTable();
    }

    /**
     * Atualização da tabela de S_PHONES
     */
    private function updatePhoneTable()
    {
        Log::info('Atualização tabela S_PHONES disparada');

        $this->actionDatabaseServiceCrud->initUpdateTable('telefone');
        // real time
        event(new ShowTablesUpdated());


        $sql = "SELECT * FROM TELEFONE";

        $resultArray = $this->connection->query($sql);

        $this->phoneRepository->truncate();

        for($i = 0; $i < count($resultArray); $i++) {

            if ($resultArray[$i]['TELEFONE']) {

                $data_create = [
                    'client_id' => (int) $resultArray[$i]['CLIENTE_ID'],
                    'ddd' => $resultArray[$i]['DDD'],
                    'phone' => $resultArray[$i]['TELEFONE'],
                    'type_phone' => $resultArray[$i]['TIPO_FONE'],
                    'main' => $resultArray[$i]['TELEFONE_PRINCIPAL'],
                ];

                $this->phoneRepository->create($data_create);

            }

        }

        Log::info('Atualização tabela S_PHONES finalizada');

        $this->actionDatabaseServiceCrud->endUpdateTable('telefone');
        // real time
        event(new ShowTablesUpdated());

        $this->updateImmobileTable();
    }

    /**
     * Atualização da tabela IMOVEL
     */
    private function updateImmobileTable()
    {
        Log::info('Atualização tabela IMOVEL disparada');

        $this->actionDatabaseServiceCrud->initUpdateTable('imovel');
        // real time
        event(new ShowTablesUpdated());

        $sql = "SELECT IMOVEL.IMOVEL_ID, IMOVEL.CODIGO, IMOVEL.ENDERECO,
                IMOVEL.BAIRRO, IMOVEL.CIDADE, IMOVEL.ESTADO,
                IMOVEL.CEP, IMOVEL.NOME_EDIFICIO, 
                CONDOMINIO.NOME_CONDOMINIO, CONDOMINIO.ENDERECO_CONDOMINIO, CONDOMINIO.NOME_SINDICO,
                CONDOMINIO.BAIRRO, CONDOMINIO.CIDADE, CONDOMINIO.ESTADO, CONDOMINIO.CEP, CONDOMINIO.E_MAIL,   
                IMOVEL.TIPO_IMOVEL_ID, IMOVEL.VALOR_ALUGUEL, IMOVEL.DISPONIVEL_LOCACAO,
                IMOVEL.ALUGADO,
                IMOVEL.NUMERO_IPTU,
                IMOVEL.CONDOMINIO_ID,
                IMOVEL.TIPO_OCUPACAO,
                TIPO_IMOVEL.NOME_TIPO_IMOVEL,
                
                            (SELECT FIRST 1 PROPRIETARIO.CLIENTE_ID  
                            FROM PROPRIETARIO     
                            WHERE PROPRIETARIO.PROPRIETARIO_ID = (SELECT FIRST 1 IMOVEL_PROPRIETARIO.PROPRIETARIO_ID  
                            FROM IMOVEL_PROPRIETARIO     
                            WHERE IMOVEL_PROPRIETARIO.IMOVEL_ID = IMOVEL.IMOVEL_ID)) CODIGO_PROPRIETARIO,
                            
                            (SELECT FIRST 1 VISTORIA.TEXTO  
                            FROM VISTORIA     
                            WHERE VISTORIA.IMOVEL_ID = IMOVEL.IMOVEL_ID) TEXTO
                            
                FROM IMOVEL
                LEFT JOIN TIPO_IMOVEL ON (TIPO_IMOVEL.TIPO_IMOVEL_ID = IMOVEL.TIPO_IMOVEL_ID)
                LEFT JOIN CONDOMINIO ON (CONDOMINIO.CONDOMINIO_ID = IMOVEL.CONDOMINIO_ID)";

        $resultArray = $this->connection->query($sql);

        $this->immobileRepository->truncate();

        for($i = 0; $i < count($resultArray); $i++) {

            $data_created = [
                'immobile_id' => (int) $resultArray[$i]['IMOVEL_ID'],
                'immobile_code' => $resultArray[$i]['CODIGO'],
                'address' => $resultArray[$i]['ENDERECO'],
                'neighborhood' => $resultArray[$i]['BAIRRO'],
                'city' => $resultArray[$i]['CIDADE'],
                'state' => $resultArray[$i]['ESTADO'],
                'zip_code' => $resultArray[$i]['CEP'],
                'building_name' => $resultArray[$i]['NOME_EDIFICIO'],
                'condominium_id' => $resultArray[$i]['CONDOMINIO_ID'],
                'condominium_name' => $resultArray[$i]['NOME_CONDOMINIO'],
                'condominium_address' => $resultArray[$i]['ENDERECO_CONDOMINIO'],
                'condominium_syndicate' => $resultArray[$i]['NOME_SINDICO'],
                'condominium_neighborhood' => $resultArray[$i]['BAIRRO'],
                'condominium_city' => $resultArray[$i]['CIDADE'],
                'condominium_state' => $resultArray[$i]['ESTADO'],
                'condominium_cep' => $resultArray[$i]['CEP'],
                'condominium_email' => $resultArray[$i]['E_MAIL'],
                'type_immobile_id' => (int) $resultArray[$i]['TIPO_IMOVEL_ID'],
                'value_rent' => $resultArray[$i]['VALOR_ALUGUEL'],
                'available_rental' => $resultArray[$i]['DISPONIVEL_LOCACAO'],
                'rent' => $resultArray[$i]['ALUGADO'],
                'owner_code' =>  $resultArray[$i]['CODIGO_PROPRIETARIO'],
                'type_immobile' => $resultArray[$i]['NOME_TIPO_IMOVEL'],
                'type_occupation' => $resultArray[$i]['TIPO_OCUPACAO'],
                'survey_observation' => $resultArray[$i]['TEXTO'],
                'iptu' => $resultArray[$i]['NUMERO_IPTU'],
            ];

            $this->immobileRepository->create($data_created);
        }

        Log::info('Atualização tabela IMOVEL finalizada');

        $this->actionDatabaseServiceCrud->endUpdateTable('imovel');
        // real time
        event(new ShowTablesUpdated());

        $this->updateTenantAllContractTable();
    }

    /**
     * Atualização tabela V_INQUILINOS_CONTRATOS_TODOS
     */
    private function updateTenantAllContractTable()
    {
        Log::info('Atualização tabela V_INQUILINOS_CONTRATOS_TODOS disparada');

        $this->actionDatabaseServiceCrud->initUpdateTable('inquilino contrato todos');
        // real time
        event(new ShowTablesUpdated());


        $sql = 'Select * from V_INQUILINOS_CONTRATOS_TODOS';

        $resultArray = $this->connection->query($sql);

        $this->tenantAllContractRepository->truncate();

        for($i = 0; $i < count($resultArray); $i++) {

            $data_created = [
                'client_id_sicadi' => (int) $resultArray[$i]['CLIENTE_ID'],
                'contract_id' => (int) $resultArray[$i]['CONTRATO_ID'],
                'client_name' => $resultArray[$i]['NOME_CLIENTE'],
                'client_code' => $resultArray[$i]['CODIGO_CLIENTE'],
                'contract_code' => $resultArray[$i]['CODIGO_CONTRATO'],
                'immobile_id' => (int) $resultArray[$i]['IMOVEL_ID'],
            ];

            $this->tenantAllContractRepository->create($data_created);
        }

        Log::info('Atualização tabela V_INQUILINOS_CONTRATOS_TODOS finalizada');

        $this->actionDatabaseServiceCrud->endUpdateTable('inquilino contrato todos');
        // real time
        event(new ShowTablesUpdated());

        $this->updateImmobileTypeTable();
    }


    /**
     * Atualização da tabela TIPO_IMOVEL
     */
    private function updateImmobileTypeTable()
    {
        Log::info('Atualização tabela TIPO_IMOVEL disparada');

        $this->actionDatabaseServiceCrud->initUpdateTable('tipo imovel');
        // real time
        event(new ShowTablesUpdated());

        $sql = 'Select * from TIPO_IMOVEL';

        $resultArray = $this->connection->query($sql);

        $this->immobileTypeRepository->truncate();

        for($i = 0; $i < count($resultArray); $i++) {

            $data_created = [
                'type_immobile_id' => (int) $resultArray[$i]['TIPO_IMOVEL_ID'],
                'name_type_immobile' => $resultArray[$i]['NOME_TIPO_IMOVEL'],
            ];

            $this->immobileTypeRepository->create($data_created);
        }

        Log::info('Atualização tabela TIPO_IMOVEL finalizada');

        $this->actionDatabaseServiceCrud->endUpdateTable('tipo imovel');
        // real time
        event(new ShowTablesUpdated());

        $this->updateContractTable();
    }

    /**
     * Atualização da tabela CONTRATO
     */
    private function updateContractTable()
    {
        Log::info('Atualização tabela CONTRATO disparada');

        $this->actionDatabaseServiceCrud->initUpdateTable('contrato');
        // real time
        event(new ShowTablesUpdated());

        $sql = "SELECT CONTRATO.CODIGO, CONTRATO.CONTRATO_ID,
                CONTRATO.DATA_PRIMEIRO_CONTRATO, CONTRATO.DATA_INICIO_CONTRATO_ATUAL, CONTRATO.ULTIMO_REAJUSTE, 
                CONTRATO.IMOVEL_ID, CONTRATO.DATA_RECISAO,
                IMOVEL.ENDERECO, IMOVEL.BAIRRO, IMOVEL.CIDADE, IMOVEL.NOME_EDIFICIO, IMOVEL.TIPO_IMOVEL_ID,
                TIPO_IMOVEL.NOME_TIPO_IMOVEL,
                CLIENTE.NOME,
                CONDOMINIO.NOME_CONDOMINIO,
                               (SELECT FIRST 1 CONTROLE_CONTRATUAL.VALOR_ALUGUEL
                                     FROM CONTROLE_CONTRATUAL
                                     WHERE (CONTROLE_CONTRATUAL.CONTRATO_ID = CONTRATO.CONTRATO_ID)
                                     ORDER BY CONTROLE_CONTRATUAL_ID DESC
                               ),
                               (SELECT FIRST 1 CONTROLE_CONTRATUAL.PERIODICIDADE_CONTRATO
                                     FROM CONTROLE_CONTRATUAL
                                     WHERE (CONTROLE_CONTRATUAL.CONTRATO_ID = CONTRATO.CONTRATO_ID)
                                     ORDER BY CONTROLE_CONTRATUAL_ID DESC
                               )                        
                FROM CONTRATO
                LEFT JOIN CLIENTE_CONTRATO ON (CLIENTE_CONTRATO.CONTRATO_ID = CONTRATO.CONTRATO_ID AND CLIENTE_CONTRATO.TIPO_CLIENTE_CONTRATO = 'I')
                LEFT JOIN CLIENTE ON CLIENTE.CLIENTE_ID = CLIENTE_CONTRATO.CLIENTE_ID
                LEFT JOIN IMOVEL ON IMOVEL.IMOVEL_ID = CONTRATO.IMOVEL_ID
                LEFT JOIN CONDOMINIO ON CONDOMINIO.CONDOMINIO_ID = IMOVEL.CONDOMINIO_ID
                LEFT JOIN TIPO_IMOVEL ON TIPO_IMOVEL.TIPO_IMOVEL_ID = IMOVEL.TIPO_IMOVEL_ID";

        $resultArray = $this->connection->query($sql);

        $this->contractRepository->truncate();

        for($i = 0; $i < count($resultArray); $i++) {

            $data_created = [
                'contract_id' => $resultArray[$i]['CONTRATO_ID'],
                'contract_code' => $resultArray[$i]['CODIGO'],
                'tenant_name' => $resultArray[$i]['NOME'],
                'date_primary_contract' => $resultArray[$i]['DATA_PRIMEIRO_CONTRATO'],
                'init_date_current_contract' => $resultArray[$i]['DATA_INICIO_CONTRATO_ATUAL'],
                'contract_time' => (int) $resultArray[$i]['PERIODICIDADE_CONTRATO'],
                'value_rent' => $resultArray[$i]['VALOR_ALUGUEL'],
                'immobile_id' => (int) $resultArray[$i]['IMOVEL_ID'],
                'address' => $resultArray[$i]['ENDERECO'],
                'neighborhood' => $resultArray[$i]['BAIRRO'],
                'city' => $resultArray[$i]['CIDADE'],
                'building_name' => $resultArray[$i]['NOME_EDIFICIO'],
                'condominium_name' => $resultArray[$i]['NOME_CONDOMINIO'],
                'type_immobile' => $resultArray[$i]['NOME_TIPO_IMOVEL'],
                'type_immobile_id' => $resultArray[$i]['TIPO_IMOVEL_ID'],
                'termination_date' => $resultArray[$i]['DATA_RECISAO'],
                'last_adjustment' => $resultArray[$i]['ULTIMO_REAJUSTE'],
            ];

            $this->contractRepository->create($data_created);
        }

        Log::info('Atualização tabela CONTRATO finalizada');

        $this->actionDatabaseServiceCrud->endUpdateTable('contrato');
        // real time
        event(new ShowTablesUpdated());

        $this->updateContractInactiveTable();
    }

    /**
     * Atualização tabela CONTRATO_INATIVO
     */
    private function updateContractInactiveTable()
    {

        Log::info('Atualização tabela CONTRATO_INATIVO disparada');

        $this->actionDatabaseServiceCrud->initUpdateTable('contrato_inativo');
        // real time
        event(new ShowTablesUpdated());

        $sql = "SELECT CONTRATO.CODIGO, CONTRATO.CONTRATO_ID,
                CONTRATO.DATA_PRIMEIRO_CONTRATO, CONTRATO.DATA_INICIO_CONTRATO_ATUAL, CONTRATO.PERIODICIDADE_CONTRATO, 
                CONTRATO.IMOVEL_ID, CONTRATO.DATA_RECISAO,
                IMOVEL.ENDERECO, IMOVEL.BAIRRO, IMOVEL.CIDADE, IMOVEL.NOME_EDIFICIO, IMOVEL.TIPO_IMOVEL_ID,
                TIPO_IMOVEL.NOME_TIPO_IMOVEL,
                CONDOMINIO.NOME_CONDOMINIO,
                               (SELECT FIRST 1 RECIBO_INQUILINO.VALOR_ALUGUEL 
                                     FROM RECIBO_INQUILINO
                                     WHERE (RECIBO_INQUILINO.CONTRATO_ID = CONTRATO.CONTRATO_ID)
                                     ORDER BY DATA_PAGAMENTO DESC
                               )                        
                FROM CONTRATO
                LEFT JOIN IMOVEL ON IMOVEL.IMOVEL_ID = CONTRATO.IMOVEL_ID
                LEFT JOIN CONDOMINIO ON CONDOMINIO.CONDOMINIO_ID = IMOVEL.CONDOMINIO_ID
                LEFT JOIN TIPO_IMOVEL ON TIPO_IMOVEL.TIPO_IMOVEL_ID = IMOVEL.TIPO_IMOVEL_ID";

        $resultArray = $this->connection->query($sql);

        $this->inactiveContractRepository->truncate();

        for($i = 0; $i < count($resultArray); $i++) {

            $data_created = [
                'contract_code' => $resultArray[$i]['CODIGO'],
                'date_primary_contract' => $resultArray[$i]['DATA_PRIMEIRO_CONTRATO'],
                'init_date_current_contract' => $resultArray[$i]['DATA_INICIO_CONTRATO_ATUAL'],
                'contract_time' => (int) $resultArray[$i]['PERIODICIDADE_CONTRATO'],
                'value_rent' => $resultArray[$i]['VALOR_ALUGUEL'],
                'date_cancellation' => $resultArray[$i]['DATA_RECISAO'],
                'immobile_id' => (int) $resultArray[$i]['IMOVEL_ID'],
                'address' => $resultArray[$i]['ENDERECO'],
                'neighborhood' => $resultArray[$i]['BAIRRO'],
                'city' => $resultArray[$i]['CIDADE'],
                'building_name' => $resultArray[$i]['NOME_EDIFICIO'],
                'condominium_name' => $resultArray[$i]['NOME_CONDOMINIO'],
                'type_immobile' => $resultArray[$i]['NOME_TIPO_IMOVEL'],
                'type_immobile_id' => $resultArray[$i]['TIPO_IMOVEL_ID'] != null ? $resultArray[$i]['TIPO_IMOVEL_ID'] : null,
            ];

            $this->inactiveContractRepository->create($data_created);
        }

        Log::info('Atualização tabela CONTRATO_INATIVO finalizada');

        $this->actionDatabaseServiceCrud->endUpdateTable('contrato_inativo');
        // real time
        event(new ShowTablesUpdated());

        $this->updateDjGuideTable();
    }

    /**
     * Atualização da tabela GUIA_DJ
     */
    public function updateDjGuideTable()
    {
        Log::info('Atualização tabela GUIA_DJ disparada');

        $this->actionDatabaseServiceCrud->initUpdateTable('departamento juridico');
        // real time
        event(new ShowTablesUpdated());

        $sql = "SELECT GUIA_DJ.GUIA_DJ_ID, GUIA_DJ.DATA_ENCAMINHAMENTO, GUIA_DJ.RECIBO_INQUILINO_ID, GUIA_DJ.VALOR_DO_RECIBO, GUIA_DJ.DATA_RETIRADA FROM GUIA_DJ";

        $resultArray = $this->connection->query($sql);

        $this->djGuideRepository->truncate();

        for($i = 0; $i < count($resultArray); $i++) {

            $data_created = [
                'dj_id' => $resultArray[$i]['GUIA_DJ_ID'],
                'date_send' => $resultArray[$i]['DATA_ENCAMINHAMENTO'],
                'receipt_id' => $resultArray[$i]['RECIBO_INQUILINO_ID'],
                'value' => (float) $resultArray[$i]['VALOR_DO_RECIBO'],
                'date_exit' => $resultArray[$i]['DATA_RETIRADA']
            ];

            $this->djGuideRepository->create($data_created);
        }

        Log::info('Atualização tabela GUIA_DJ finalizada');

        $this->actionDatabaseServiceCrud->endUpdateTable('departamento juridico');
        // real time
        event(new ShowTablesUpdated());

        Log::info('Atualização das tabelas concluída');
    }

}