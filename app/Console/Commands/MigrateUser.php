<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Modules\User\Entities\User;

class MigrateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sigem:migrate-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migra a tabela de usuário';

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
         * Migração da tabela users
         */

        $this->info('Iniciando Migração da tabela users');
        User::truncate();
        $destinationOrReason = DB::connection('sigem-to-migrate')->table('users')->select('*')->get();
        foreach ($destinationOrReason as $item) {
            User::create(get_object_vars($item));
        }
        $this->info('Finalizando Migração da tabela users');
    }
}
