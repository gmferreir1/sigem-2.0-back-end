<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Termination\Entities\Contract;

class AdjustTerminationData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sigem:adjust-termination-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Altera o campo caveat da tabela de contratos inativados de (s) para (y)';

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
        $this->info('Iniciando Transação');

        $terminationData = Contract::select('*')->get()->toArray();

        foreach ($terminationData as $data) {

            $data['caveat'] = $data['caveat'] == 's' ? 'y' : 'n';

            Contract::where('id', $data['id'])->update(['caveat' => $data['caveat']]);
        }

        $this->info('Finalizando Transação');
    }
}
