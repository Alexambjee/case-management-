<?php

namespace App\Http\Controllers;

use App\Models\iroAttachement;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Yajra\Oci8\Eloquent\OracleEloquent as Eloquent;

class AttachmentController extends Controller
{    // upload attachment

    public function upload(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|max:210000'
        ]);

        $filenames = [];
        try {
            if (is_array($request->file)) {
                foreach ($request->file as $file) {
                    $fileName = time() . '.' . $file->getClientOriginalName();
                    $file->move(public_path('uploads'), $fileName);
                    $filenames[] = $fileName;
                }
            } else {
                $fileName = time() . '.' . $request->file->getClientOriginalName();
                $request->file->move(public_path('uploads'), $fileName);
                $filenames[] = $fileName;
            }
            
            return response()->json(['filenames' => $filenames]);
        } catch (\Throwable $th) {
            return  $th;
        }
        
    }
    // fetch attachments based on caseid
    public function fetchAttachments(Request $request)
    {
       
        return DB::table('sxt_attachment_mst')->where('case_id', $request->caseId)
            ->orderBy('created_at', 'desc')
            ->get();
    }


    public function getTaxpayerAttachments(Request $request)
    {
        // $assmnt='KRA201815359264';
        return $request->assmtNo;
        $data = DB::connection('oracle')
            ->table('IRO_DATA_ATT')
            ->where('ASSMT_NO', $request->tPin)
            ->get();
        return $data;


    //     foreach ($data as $row) {
    //         $report = $row->analysis_report;
    //         $file_name = $row->file_name;
    //         $ref_id =$row-> ref_id;
    //         $file_contents = base64_decode($report);

    //         return [$file_name, response($file_contents)
    //             ->header('Cache-Control', 'no-cache private')
    //             ->header('Content-Description', 'File Transfer')
    //             // ->header('Content-Type', $report->mime_type)
    //             ->header('Content-length', strlen($file_contents))
    //             // ->header('Content-Disposition', 'attachment; filename=' . $report->file_name)
    //             ->header('Content-Transfer-Encoding', 'binary')];

    // }
    // return mb_convert_encoding($data, 'UTF-8', 'UTF-8');
    }
    public function deleteAttachment($caseId, $attachmentId){
        try {
            //code...
            // Find attachment from DB
            $attachment = DB::table('sxt_attachment_mst')->where('CASE_ID', $caseId)->find($attachmentId);
            $attached = $attachment->ATTACHEMENT_LINK;
            $file = Str::of($attached)->replaceFirst('/', '');
            // Delete attachment from public storage
            unlink(public_path($file));
            // Delete attachement from DB
            $attachment->delete();
            return response()->json(['message'=>'Attachment deleted successfuly!']);
        } catch (\Exception  $er) {
            \Log::info($er);
            return 'Ooops! Failed to delete attachment.';
        }
    }
}