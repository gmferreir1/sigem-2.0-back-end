<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Modules\Register\Entities\ReserveContract\ReserveContract;
use Modules\Register\Entities\ReserveHistoric\ReserveHistoric;
use Modules\Register\Entities\ReserveReasonCancel\ReserveReasonCancel;
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
        $dataToMigrate = DB::connection('sigem-to-migrate')->table('register_reserve_monitorings')->select('*')->get();
        foreach ($dataToMigrate as $item) {
            ReserveContract::create(get_object_vars($item));
        }
        $this->info('Finalizando Migração da tabela register_reserve_monitorings');


        /**
         * Migração da tabela register_reserve_score_attendants
         */
        $this->info('Iniciando Migração da tabela register_reserve_score_attendants');
        ScoreAttendance::truncate();
        $dataToMigrate = DB::connection('sigem-to-migrate')->table('register_reserve_score_attendants')->select('*')->get();
        foreach ($dataToMigrate as $item) {
            ScoreAttendance::create(get_object_vars($item));
        }
        $this->info('Finalizando Migração da tabela register_reserve_score_attendants');


        /**
         * Migração da tabela register_reserve_historics
         */
        $this->info('Iniciando Migração da tabela register_reserve_historics');
        ReserveHistoric::truncate();
        $dataToMigrate = DB::connection('sigem-to-migrate')->table('register_reserve_historics')->select('*')->get();
        foreach ($dataToMigrate as $item) {
            ReserveHistoric::create(get_object_vars($item));
        }
        $this->info('Finalizando Migração da tabela register_reserve_historics');


        /**
         * Migração da tabela register_reserve_reason_cancels
         */
        $this->info('Iniciando Migração da tabela register_reserve_reason_cancels');
        ReserveReasonCancel::truncate();
        $dataToMigrate = DB::connection('sigem-to-migrate')->table('register_reserve_reason_cancels')->select('*')->get();
        foreach ($dataToMigrate as $item) {
            ReserveReasonCancel::create(get_object_vars($item));
        }
        $this->info('Finalizando Migração da tabela register_reserve_reason_cancels');
    }
}
