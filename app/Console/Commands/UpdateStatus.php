<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transactions;

class UpdateStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:status';
 
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        date_default_timezone_set("Asia/Makassar");
            $transaksi = Transactions::where('timeout', '<', date('Y-m-d H:i:s'))->where('status', '=', 'unverified')->get();
            if(!is_null($transaksi)){
                foreach($transaksi as $item){
                    $item->status = 'expired';
                    $item->save();
                }
            }
    }
}
