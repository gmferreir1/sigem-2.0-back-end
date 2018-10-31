<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Modules\Chat\Services\OnlineUserServiceCrud;

class CheckUserOnline extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sigem:check-online';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica se o usuário esta online para desconectar do chat';
    /**
     * @var OnlineUserServiceCrud
     */
    private $onlineUserServiceCrud;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(OnlineUserServiceCrud $onlineUserServiceCrud)
    {
        parent::__construct();
        $this->onlineUserServiceCrud = $onlineUserServiceCrud;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $allUsersOnlineChat = $this->onlineUserServiceCrud->all();


        $timeCheck = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'))->subMinute(5)->format('Y-m-d H:i:s');

        foreach ($allUsersOnlineChat as $item) {


            if ($item['last_interaction'] < $timeCheck) {


                $this->onlineUserServiceCrud->delete($item['id']);


            }
        }
    }
}
