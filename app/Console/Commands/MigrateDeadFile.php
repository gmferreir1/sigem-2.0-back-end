<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Modules\DeadFile\Entities\DeadFile;

class MigrateDeadFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sigem:migrate-deadFile';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migra as tabelas de arquivo morto';

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
         * Migração da tabela contract_inactivated_dead_files
         */

        $this->info('Iniciando Migração da tabela contract_inactivated_dead_files');
        DeadFile::truncate();
        $destinationOrReason = DB::connection('sigem-to-migrate')->table('contract_inactivated_dead_files')->select('*')->get();
        foreach ($destinationOrReason as $item) {
            DeadFile::create(get_object_vars($item));
        }
        $this->info('Finalizando Migração da tabela contract_inactivated_dead_files');
    }
}
