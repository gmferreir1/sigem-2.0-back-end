<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Modules\ImmobileCaptured\Entities\ReportList\ReportList;
use Modules\Sicadi\Entities\ImmobileType;

class MigrateImmobileCaptured extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sigem:migrate-immobile-captured';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migra as tabelas dos imoveis captados';

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

        $this->info('Iniciando Migração da tabela manager_report_immobile_captureds');
        ReportList::truncate();
        $destinationOrReason = DB::connection('new-sigem')->table('manager_report_immobile_captureds')->select('*')->get();
        foreach ($destinationOrReason as $item) {
            $data = get_object_vars($item);


            $data['captured_date'] = $item->catchment_date;
            $data['responsible'] = $item->pickup_id;
            $data['rp_last_action'] = $item->rp_open;

            $immobileType = ImmobileType::where('name_type_immobile', $data['immobile_type'])->first();
            // pego o id do tipo do imovel
            $data['type_immobile'] = $immobileType ? $immobileType->type_immobile_id : null;


            if (!$data['type_immobile']) {
                dd($data);
            }

            ReportList::create($data);
        }
        $this->info('Finalizando Migração da tabela manager_report_immobile_captureds');
    }
}
