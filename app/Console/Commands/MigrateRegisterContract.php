<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Modules\Register\Entities\ReserveContract\ReserveContract;
use Modules\Register\Entities\ScoreAttendance\ScoreAttendance;

class MigrateRegisterContract extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sigem:migrate-register-contract';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migra as tabelas do modulo cadastro';

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
         * Migração da tabela register_reserve_monitorings
         */
        $this->info('Iniciando Migração da tabela register_reserve_monitorings');
        ReserveContract::truncate();
        $destinationOrReason = DB::connection('sigem-to-migrate')->table('register_reserve_monitorings')->select('*')->get();
        foreach ($destinationOrReason as $item) {
            ReserveContract::create(get_object_vars($item));
        }
        $this->info('Finalizando Migração da tabela register_reserve_monitorings');


        /**
         * Migração da tabela register_reserve_score_attendants
         */
        $this->info('Iniciando Migração da tabela register_reserve_score_attendants');
        ScoreAttendance::truncate();
        $destinationOrReason = DB::connection('sigem-to-migrate')->table('register_reserve_score_attendants')->select('*')->get();
        foreach ($destinationOrReason as $item) {
            ScoreAttendance::create(get_object_vars($item));
        }
        $this->info('Finalizando Migração da tabela register_reserve_score_attendants');
    }
}
