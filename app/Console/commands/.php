<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;


class UniqueNumController
      {

       function generateUniqueNum($c, $l, $u = FALSE) {
              if (!$u) for ($s = '', $i = 0, $z = strlen($c)-1; $i < $l; $x = rand(0,$z), $s .= $c[$x], $i++);
              else for ($i = 0, $z = strlen($c)-1, $s = $c[rand(0,$z)], $i = 1; $i != $l; $x = rand(0,$z), $s .= $c[$x], $s = ($s[$i] == $s[$i-1] ? substr($s,0,-1) : $s), $i=strlen($s));
              return $s;
              }
             }

class CaseCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'case:cron';

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
        $conn3=oci_connect('RISK', 'risk#dbm02', '10.30.100.62:1521/dbm02');

        // $your_query="SELECT * FROM  IRO_MAPPING WHERE STATUS=0";
        // $sql_query = 'SELECT COUNT(*) AS NUMBER_OF_ROWS FROM (' . $your_query . ')';

        // $stmt= oci_parse($conn3, $sql_query);

        // oci_define_by_name($stmt, 'NUMBER_OF_ROWS', $number_of_rows);

        // oci_execute($stmt);

        // oci_fetch($stmt);


        // if($number_of_rows<1)
        // {
        // $stidu = oci_parse($conn3, " UPDATE IRO_MAPPING SET STATUS=0");
        // oci_execute($stidu);
        // }




        $stidx = oci_parse($conn3, " SELECT * FROM RISK.IRO_DATA WHERE STATUS=0");
        oci_execute($stidx);


        


          while (($row = oci_fetch_array($stidx, OCI_BOTH)) != false)
          {
           //SELECTING FROM POSTGRESS
          
           $host        = "host=127.0.0.1";
           $port        = "port=5432";
           $dbname      = "dbname = iroproject";
           $credentials = "user = postgres password=Root@2022";
           $db = pg_connect( "$host $port $dbname $credentials"  );
         

          

        $result=pg_query($db, 'SELECT MIN("AMOUNT")AS "AMOUNT" FROM public.iro_mapping_mst;');
        $row3 = pg_fetch_array($result);
        $VAL = $row3["AMOUNT"];
        $VAL = (int) $VAL;

       $sql =<<<EOF
       SELECT "OFFICER","CHIEF_MANAGER","MANAGER" FROM public.iro_mapping_mst where "AMOUNT"='$VAL';
      

       EOF;
       $result2 = pg_query($db, $sql);

        // $result2=pg_query($db, 'SELECT "OFFICER","CHIEF_MANAGER","MANAGER" FROM public.iro_mapping_mst where "AMOUNT"='$VAL';');
        $row2 = pg_fetch_array($result2);
         $OFFICER= $row2["OFFICER"];
        $MANAGER= $row2["MANAGER"];
         $CHIEF_MANAGER= $row2["CHIEF_MANAGER"];

        // $stidQ = oci_parse($conn3, "SELECT OFFICER,ID,CHIEF_MANAGER,MANAGER FROM IRO_MAPPING WHERE STATUS=0");
        // oci_execute($stidQ);
        // $row2 = oci_fetch_array($stidQ, OCI_BOTH);
        //  $OFFICER= $row2['OFFICER'];
        //  $MANAGER= $row2['MANAGER'];
        //  $CHIEF_MANAGER= $row2['CHIEF_MANAGER'];

        // $ID= $row2['ID'];
        $STATION_ID=$row['STATION_ID'];
        $REMARKS=$row['REMARKS'];
        $OBLIGATION_ID=$row['OBLIGATION_ID'];
        $PIN_NO=$row['PIN_NO'];
        $TAX_PAYER_NAME=$row['TAX_PAYER_NAME'];
        $TAX_PAYER_NAME = str_replace("'", '', $TAX_PAYER_NAME);
        $EMAIL_ID=$row['EMAIL_ID'];
        $TAX_HEAD=$row['TAX_HEAD'];
        $ASSMT_NO=$row['ASSMT_NO'];
        $ASSMT_AMT=$row['ASSMT_AMT'];
        $ASSMT_PERIOD_FROM=$row['ASSMT_FROM_DT'];
        $ASSMT_PERIOD_TO=$row['ASSMT_TO_DT'];
        $ASSMT_DONE_BY=$row['ASSMT_DONE_BY'];
        $USER_NAME=$row['USER_NAME'];
        $OBJ_AMT=$row['OBJ_AMT'];
        $OBJ_date=$row['OBJECTION_DATE'];
        $MOBILE_NUMBER=$row['MOBILE_NUMBER'];



        // $ID3=$row['ID'];

        // $AMOUNT=$row['AMOUNT'];
        //$today =date("Y-m-d");
        //$OBJ_date="2022-02-02";
       //$expected_date=date('Y-m-d', strtotime($OBJ_date. ' + 60days'));

       //$expected_date = "2022-01-01";
         $objUniqueNum = new UniqueNumController();
                $caseNo = $objUniqueNum->generateUniqueNum('0123456789', 6, true);
                $year = Date('Y');
                $caseNum = 'C' . $caseNo . '-' . $year . '-A';







                $expected_date=date('Y-m-d', strtotime($OBJ_date. ' + 59days'));

                //$expected_date = "2022-01-01";
                  $objUniqueNum = new UniqueNumController();
                         $caseNo = $objUniqueNum->generateUniqueNum('0123456789', 6, true);
                         $year = Date('Y');
                         $caseNum = 'C' . $caseNo . '-' . $year . '-A';
         
         
         
         
         
         
         
                    $sql =<<<EOF
                       INSERT INTO public.iro_case_mst(
                         "CASE_ID", "ASSESSMENT_NUMBER", "ASSESSMENT_AMOUNT", "OBJECTION_AMOUNT", "TAXPAYER_PIN", "OBLIGATION_ID", "PERIOD_FROM","PERIOD_TO", "STATION_ID", "ASSESSMENT_OFFICER", "DATE_OF_OBJECTION", "UPLOADED_BY", "STATUS", "OFFICER_PNO", "MANAGER_PNO", "CM_PNO",  "REASON_FOR_OBJECTION", "OTHER_OFFICERS", "LAST_UPDATE_BY", "TP_NAME", "TP_EMAIL", "TP_PHONE","created_at","CASE_SOURCE","EXPECTED_COMPLETION_DATE")
                          VALUES('$caseNum', '$ASSMT_NO', '$ASSMT_AMT', '$OBJ_AMT' , '$PIN_NO','$OBLIGATION_ID','$ASSMT_PERIOD_FROM','$ASSMT_PERIOD_TO', '$STATION_ID','$USER_NAME','$OBJ_date','ADMIN','1','$OFFICER','$MANAGER' ,'$CHIEF_MANAGER','$REMARKS','ADMIN','ADMIN','$TAX_PAYER_NAME','$EMAIL_ID','$MOBILE_NUMBER',current_timestamp,'ITAX','$expected_date');
         
         
                    EOF;

           $ret = pg_query($db, $sql);
           if(!$ret) {
              echo pg_last_error($db);
           } else {
              // $stidu = oci_parse($conn3, " UPDATE IRO_MAPPING SET OFFICER='TYTY'");
              //   oci_execute($stidu);
           }

           $VAL2=$VAL*1+1;
           $sql2 =<<<EOF

           UPDATE public.iro_mapping_mst SET "AMOUNT"='$VAL2' where "OFFICER"='$OFFICER';
           EOF;
           $ret = pg_query($db, $sql2);
           if(!$ret) {
              echo pg_last_error($db);
           } else {
              // $stidu = oci_parse($conn3, " UPDATE IRO_MAPPING SET OFFICER='TYTY'");
              //   oci_execute($stidu);
           }

           pg_close($db);

        // $stidD = oci_parse($conn3, "UPDATE IRO_MAPPING SET STATUS=1 WHERE OFFICER='$OFFICER'");
        // oci_execute($stidD);

        $stid = oci_parse($conn3, " UPDATE IRO_DATA SET STATUS=1 WHERE ASSMT_NO='$ASSMT_NO'");
        oci_execute($stid);

        // $your_query="SELECT * FROM  IRO_MAPPING WHERE STATUS=0";
        // $sql_query = 'SELECT COUNT(*) AS NUMBER_OF_ROWS FROM (' . $your_query . ')';

        // $stmt= oci_parse($conn3, $sql_query);

        // oci_define_by_name($stmt, 'NUMBER_OF_ROWS', $number_of_rows);

        // oci_execute($stmt);

        // oci_fetch($stmt);

        // if($number_of_rows<1)
        // {
        // $stidu = oci_parse($conn3, " UPDATE IRO_MAPPING SET STATUS=0");
        // oci_execute($stidu);
        // }
     }
     
     $host        = "host=127.0.0.1";
     $port        = "port=5432";
     $dbname      = "dbname = iroproject";
     $credentials = "user = postgres password=Root@2022";
     $db = pg_connect( "$host $port $dbname $credentials"  );






     $sql9 =<<<EOF
     SELECT "EXPECTED_COMPLETION_DATE","CASE_ID" FROM public.iro_case_mst;


EOF;






$result9 = pg_query($db, $sql9);
while ($row9 = pg_fetch_array($result9)) 
{
  $EXPECTED_COMPLETION_DATE= $row9['EXPECTED_COMPLETION_DATE'];
$case_id= $row9['CASE_ID'];
 $today9 =date("Y-m-d");
$small=strtotime($today9);
$big=strtotime($EXPECTED_COMPLETION_DATE);
$results=$big-$small;
$mainresults=$results/86400;

if($mainresults<1)
{
$mainresults=0;

}

$mainresults;



$sql2 =<<<EOF

    UPDATE public.iro_case_mst SET "REMAINDER_DURATION"='$mainresults' where "CASE_ID"='$case_id';
    EOF;
   $ret = pg_query($db, $sql2);
   if(!$ret) {
      // echo pg_last_error($db);
   } else {
      // $stidu = oci_parse($conn3, " UPDATE IRO_MAPPING SET OFFICER='TYTY'");
      //   oci_execute($stidu);
   }





}




   

     $sql21 =<<<EOF

UPDATE public.iro_case_mst SET "STATUS"='9' where  "REMAINDER_DURATION"='0';
EOF;
$ret1 = pg_query($db, $sql21);
if(!$ret1) {
  // echo pg_last_error($db);
} else {
  // $stidu = oci_parse($conn3, " UPDATE IRO_MAPPING SET OFFICER='TYTY'");
  //   oci_execute($stidu);
}

}
}
