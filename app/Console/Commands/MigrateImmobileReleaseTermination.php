<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Modules\Termination\Entities\ImmobileRelease;

class MigrateImmobileReleaseTermination extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sigem:migrate-immobile-release-termination';

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
         * Migração da tabela immobile_release_terminations
         */

        $this->info('Iniciando Migração da tabela immobile_release_terminations');
        ImmobileRelease::truncate();
        $destinationOrReason = DB::connection('sigem-to-migrate')->table('immobile_release_terminations')->select('*')->get();
        foreach ($destinationOrReason as $item) {
            ImmobileRelease::create(get_object_vars($item));
        }
        $this->info('Finalizando Migração da tabela immobile_release_terminations');
    }
}
