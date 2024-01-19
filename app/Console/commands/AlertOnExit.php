<?php

namespace App\Console\Commands;
use Carbon\Carbon;
use App\Http\Console\commnds\SendAlerts;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
class AlertOnExit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exit:cron';

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
        $results = DB::table('sxt_case_mst')->select('*')
            ->where('case_exit_status',0)->get();

        if ($results->count()>0){
            foreach ($results as $result) {
                $currentDate = Carbon::now()->toDateString();
                $exitDate = Carbon::parse($result->exit_date)->toDateString();
                    if ($currentDate == $exitDate) {
                        $exitstatus = 1;
                        $results2 = DB::connection('pgsql')->table('sxt_case_mst')->update([
                            'library' => $exitstatus,
                            'knowledge_capture' => $exitstatus,
                            'facilities_assets' => $exitstatus,
                            'facilities_housing' => $exitstatus,
                            'ICT_Asset' => $exitstatus,
                            'ICT_ACCOUNT1' => $exitstatus,
                            'ICT_ACCOUNT2' => $exitstatus,
                            'ICT_ACCOUNT3' => $exitstatus,
                            'ICT_VPN' => $exitstatus,
                            'training' => $exitstatus,
                            'medical' => $exitstatus,
                            'security' => $exitstatus,
                            'own_department' => $exitstatus,
                            'case_exit_status'=>$exitstatus
                        ]);
                        $caseController = new SendAlerts();
                        $caseController->HandleEmails( $result->case_id, $result->user_name, $result->employee_name);
     
                    }
      
            }
        }
    }
}
