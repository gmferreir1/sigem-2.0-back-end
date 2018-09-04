<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Modules\Register\Entities\Transfer\Contract\Contract;
use Modules\Register\Entities\Transfer\Historic\Historic;
use Modules\Register\Entities\Transfer\Reason\Reason;
use Modules\Register\Entities\Transfer\ScoreAttendant\ScoreAttendant;

class MigrateRegisterTransfer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sigem:migrate-register-transfer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migra as tabelas do modulo cadastro (transferencia)';

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
         * Migração da tabela contract_transfer_contracts
         */
        $this->info('Iniciando Migração da tabela contract_transfer_contracts');
        Contract::truncate();
        $dataToMigrate = DB::connection('sigem-to-migrate')->table('contract_transfer_contracts')->select('*')->get();
        foreach ($dataToMigrate as $item) {
            Contract::create(get_object_vars($item));
        }
        $this->info('Finalizando Migração da tabela contract_transfer_contracts');


        /**
         * Migração da tabela contract_transfer_historics
         */
        $this->info('Iniciando Migração da tabela contract_transfer_historics');
        Historic::truncate();
        $dataToMigrate = DB::connection('sigem-to-migrate')->table('contract_transfer_historics')->select('*')->get();
        foreach ($dataToMigrate as $item) {
            Historic::create(get_object_vars($item));
        }
        $this->info('Finalizando Migração da tabela contract_transfer_historics');



        /**
         * Migração da tabela contract_transfer_reasons
         */
        $this->info('Iniciando Migração da tabela contract_transfer_reasons');
        Reason::truncate();
        $dataToMigrate = DB::connection('sigem-to-migrate')->table('contract_transfer_reasons')->select('*')->get();
        foreach ($dataToMigrate as $item) {
            $data = get_object_vars($item);

            $dataArray = [
                'id' => $data['id'],
                'reason' => $data['text'],
                'rp_last_action' => $data['rp_last_action'],
                'created_at' => $data['created_at'],
                'updated_at' => $data['updated_at']
            ];

            Reason::create($dataArray);
        }
        $this->info('Finalizando Migração da tabela contract_transfer_reasons');


        /**
         * Migração da tabela contract_transfer_score_attendants
         */
        $this->info('Iniciando Migração da tabela contract_transfer_score_attendants');
        ScoreAttendant::truncate();
        $dataToMigrate = DB::connection('sigem-to-migrate')->table('contract_transfer_score_attendants')->select('*')->get();
        foreach ($dataToMigrate as $item) {
            ScoreAttendant::create(get_object_vars($item));
        }
        $this->info('Finalizando Migração da tabela contract_transfer_score_attendants');
    }
}
