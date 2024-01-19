<?php

namespace App\Http\Controllers;

use App\Models\IroCase;
use App\Models\IroObligations;
use App\Models\IroPeriods;
use App\Models\IroUser;
use App\Http\Controllers\PdfController;
// use App\Models\EcmuEntry;
use App\Pdfs\CertificatePdf;
use App\Pdfs\ClearancePdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewPdfController extends Controller
{

    public function printCertificate(Request $request)
    {
        $caseId = $request->caseId;
        $a = request()->input('query');

        $result = ($a == 1) ? true : false;

        self::generateCertificateDetailsPdf($caseId, false, $result);
    }

    public function printClearance(Request $request)
    {
        $a = request()->input('query');
        $result = ($a == 1) ? true : false;

        $caseId = $request->caseId;
        self::generateClearanceDetailsPdf($caseId, false, $result);
    }

    static function generateCertificateDetailsPdf(string $caseId, bool $saveFile, $result)
    {
        $sxtData = DB::table('sxt_case_mst')
            ->where('case_id', $caseId)
            ->leftJoin('sxt_designations_mst', 'sxt_case_mst.designations', '=', 'sxt_designations_mst.designation_id')
            ->select('sxt_case_mst.*', 'sxt_designations_mst.designation_name')
            ->get();
        if (!$sxtData) {
            abort(404, 'Case data not found');
        }


        $savePath = null;

        if ($saveFile) {
            // generate unique filename
            $uniquePart = (new PdfController)->generateUniqId('0123456789', 15);
            $filename = "$caseId-contact-$uniquePart.pdf";
            $folderName = '/upload_gen';
            $savePath = strtolower("$folderName/$filename");
        }

        $pdfInstance = new CertificatePdf();
        //change the value to true for Deputy comissioner form
        $pdfInstance->getOutput($sxtData, $result);
        return $savePath;
    }

    static function generateClearanceDetailsPdf(string $caseId, bool $saveFile, $result)
    {
        $sxtDepartments = DB::table('sxt_role_mst')->select('role_desc')->get();
        $role = [];
        foreach ($sxtDepartments as $t) {
            $role[] = $t->role_desc;
        }
        $sxtData = DB::table('sxt_remarks_mst')
            ->select(
                'sxt_remarks_mst.case_id as case_idx',
                'sxt_liabilities_mst.case_id as case_id',
                'sxt_role_mst.role_desc as role_desc',
                'sxt_case_mst.employee_name as employee_name',
                'sxt_departments_mst.department_name as department',
                'sxt_division_mst.division_name as division',
                'sxt_designations_mst.designation_name as designation',
                'sxt_case_mst.station as station',
                'sxt_case_mst.phone as phone',
                'sxt_case_mst.email as email',
                'sxt_case_mst.address as address',
                'sxt_case_mst.user_name as user_name',
                'sxt_remarks_mst.remarks as remarks',
                'sxt_user_mst.last_name as lname',
                'sxt_user_mst.other_names as oname',
                'sxt_user_mst.email_address as emailDept'
            )
            ->leftJoin('sxt_liabilities_mst', 'sxt_remarks_mst.case_id', '=', 'sxt_liabilities_mst.case_id')
            ->leftJoin('sxt_case_mst', 'sxt_remarks_mst.case_id', '=', 'sxt_case_mst.case_id')
            ->leftJoin('sxt_role_mst', 'sxt_remarks_mst.department_id_', '=', 'sxt_role_mst.role_desc')
            ->leftJoin('sxt_departments_mst', 'sxt_case_mst.department', '=', 'sxt_departments_mst.department_id')
            ->leftJoin('sxt_division_mst', 'sxt_case_mst.division', '=', 'sxt_division_mst.division_id')
            ->leftJoin('sxt_designations_mst', 'sxt_case_mst.designations', '=', 'sxt_designations_mst.designation_id')
            ->leftJoin('sxt_user_mst', 'sxt_remarks_mst.username', '=', 'sxt_user_mst.user_name')
            ->where('sxt_remarks_mst.case_id', $caseId)
            ->get();



        \Log::info($sxtData);
        if (!$sxtData) {
            abort(404, 'Case data not found');
        }
        $savePath = null;

        if ($saveFile) {
            // generate unique filename
            $uniquePart = (new PdfController)->generateUniqId('0123456789', 15);
            $filename = "$caseId-contact-$uniquePart.pdf";
            $folderName = '/upload_gen';
            $savePath = strtolower("$folderName/$filename");
        }

        $pdfInstance = new ClearancePdf();
        $pdfInstance->getOutput($role, $sxtData, $result);
        return $savePath;
    }
    function filterData($departmentId, $caseId)
    {
        return DB::table('sxt_liabilities_mst')
            ->select(
                'product_name',
                'amount',
                'comment',
                'cleared_by',
            )
            ->where('case_id', $caseId)
            ->where('dept_id', $departmentId)
            ->get();

    }

    function remarks($departmentId, $caseId)
    {
        \Log::info("Dept =" . $departmentId . "Case Id" . $caseId);
        return DB::table('sxt_remarks_mst')
            ->select(
                'sxt_remarks_mst.remarks',
                'sxt_remarks_mst.username',
                'sxt_user_mst.last_name as lname',
                'sxt_user_mst.other_names as oname',
                'sxt_user_mst.email_address as email'
            )
            ->distinct('sxt_remarks_mst.department_id_')
            ->leftJoin('sxt_user_mst', 'sxt_remarks_mst.username', '=', 'sxt_user_mst.user_name')
            ->where('sxt_remarks_mst.case_id', $caseId)
            ->where('sxt_remarks_mst.department_id_', $departmentId)
            ->get();

    }

}