<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Modules\Termination\Entities\Contract;
use Modules\Termination\Entities\DestinationOrReason;
use Modules\Termination\Entities\Historic;
use Modules\Termination\Entities\RentAccessory;

class MigrateTermination extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sigem:migrate-termination';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migra as tabelas de inativação';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        /**
         * Migração da tabela contract_inactivated_destinations_or_reasons
         */

        $this->info('Iniciando Migração da tabela contract_inactivated_destinations_or_reasons');
        DestinationOrReason::truncate();
        $destinationOrReason = DB::connection('sigem-to-migrate')->table('contract_inactivated_destinations_or_reasons')->select('*')->get();
        foreach ($destinationOrReason as $item) {
            DestinationOrReason::create(get_object_vars($item));
        }
        $this->info('Finalizando Migração da tabela contract_inactivated_destinations_or_reasons');



        /**
         * Migração da tabela contract_inactivated_contracts
         */

        $this->info('Iniciando Migração da tabela contract_inactivated_contracts');
        Contract::truncate();
        $contractInactivated = DB::connection('sigem-to-migrate')->table('contract_inactivated_contracts')->select('*')->get();
        foreach ($contractInactivated as $item) {
            $data = get_object_vars($item);
            $data['caveat'] = $data['caveat'] == 0 ? 'n' : 's';

            Contract::create($data);
        }
        $this->info('Finalizando Migração da tabela contract_inactivated_contracts');



        /**
         * Migração da tabela contract_inactivated_auditors
         */

        $this->info('Iniciando Migração da tabela contract_inactivated_auditors');
        Historic::truncate();
        $historicData = DB::connection('sigem-to-migrate')->table('contract_inactivated_auditors')->select('*')->get();
        foreach ($historicData as $item) {

            $data = get_object_vars($item);

            $typeAction = 'user_action';

            $checkAction = explode(' ', $data['action']);

            if ($checkAction[0] == 'O') {

                $check = $checkAction[1];

                if ($check[0] == 'u' and $check[1] == 's' and $check[2] == 'u') {
                    $typeAction = 'system_action';
                }
            }

            $dataCreated = [
                'contract_id' => $data['id_contract_inactivated'],
                'historic' => $data['action'],
                'rp_last_action' => $data['rp_action'],
                'type_action' => $typeAction,
                'created_at' => $data['created_at'],
                'updated_at' => $data['updated_at']
            ];

            Historic::create($dataCreated);

        }
        $this->info('Finalizando Migração da tabela contract_inactivated_auditors');



        /**
         * Migração da tabela contract_inactivated_rent_accessories
         */

        $this->info('Iniciando Migração da tabela contract_inactivated_rent_accessories');
        RentAccessory::truncate();
        $contractInactivated = DB::connection('sigem-to-migrate')->table('contract_inactivated_rent_accessories')->select('*')->get();
        foreach ($contractInactivated as $item) {
            RentAccessory::create(get_object_vars($item));
        }
        $this->info('Finalizando Migração da tabela contract_inactivated_rent_accessories');
    }
}
