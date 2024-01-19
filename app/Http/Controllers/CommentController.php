<?php

namespace App\Http\Controllers;

use App\Models\iroComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class CommentController extends Controller
{
    // fetching comments based on caseID
    public function getComments(Request $request){
        return DB::table('sxt_remarks_mst')->where('case_id','=',$request->caseId)
                ->leftjoin('sxt_user_mst','sxt_remarks_mst.username','=','sxt_user_mst.user_name')
                ->select('sxt_remarks_mst.*', 'sxt_user_mst.other_names', 'sxt_user_mst.email_address')
                ->orderBy('created_at','desc')
                ->get();
                
    }
}
