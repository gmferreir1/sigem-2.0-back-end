<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Modules\Financial\Entities\ContractCelebrated\ContractCelebrated;

class MigrateFinancialContractCelebrated extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sigem:migrate-financial-contract-celebrated';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migra as tabelas financeiras de contrato celebrado (financeiro)';

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
         * Migração da tabela immobile_release_terminations
         */

        $this->info('Iniciando Migração da tabela financial_contract_celebrateds');
        ContractCelebrated::truncate();
        $destinationOrReason = DB::connection('sigem-to-migrate')->table('financial_contract_celebrateds')->select('*')->get();
        foreach ($destinationOrReason as $item) {
            $data = get_object_vars($item);
            $data['sync'] = null;
            ContractCelebrated::create($data);
        }
        $this->info('Finalizando Migração da tabela financial_contract_celebrateds');
    }
}
