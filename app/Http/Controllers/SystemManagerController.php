<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SystemManagerController extends Controller
{
    //Department
    public function addDepartment(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
        ]);

        $data = DB::table('sxt_departments_mst')->insert([
            'department_name' => $request->name,
            'department_email' => $request->email,
        ]);
        if ($data) {
            return DB::table('sxt_departments_mst')->select('*')->get();
        }
    }

    public function getAllDepartments(Request $request)
    {
        return DB::table('sxt_departments_mst')->select('*')->get();
    }

    public function getDepartment(Request $request)
    {
        $id = request()->input('id');
        return DB::table('sxt_departments_mst')->where('department_id', $id)->first();
    }

    public function updateDepartment(Request $request)
    {
        $id = request()->input('id');
        $data = DB::table('sxt_departments_mst')->where('department_id', $id)->update([
            'department_name' => $request->name,
            'department_email' => $request->email,
        ]);

        if ($data) {
            return DB::table('sxt_departments_mst')->select('*')->get();
        }

    }
    public function deleteDepartment(Request $request)
    {
        $id = request()->input('id');
        $data = DB::table('sxt_departments_mst')->where('department_id', $id)->delete();
        if ($data) {
            return DB::table('sxt_departments_mst')->select('*')->get();
        }
    }
    //End Department

    //Designation
    public function addDesignation(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $data = DB::table('sxt_designations_mst')->insert([
            'designation_name' => $request->name,
        ]);
        if ($data) {
            return DB::table('sxt_designations_mst')->select('*')->get();
        }
    }

    public function getAllDesignations(Request $request)
    {
        return DB::table('sxt_designations_mst')->select('*')->get();
    }

    public function getDesignation(Request $request)
    {
        $id = request()->input('id');
        return DB::table('sxt_designations_mst')->where('designation_id', $id)->first();
    }

    public function updateDesignation(Request $request)
    {
        $id = request()->input('id');
        $data = DB::table('sxt_designations_mst')->where('designation_id', $id)->update([
            'designation_name' => $request->name,
        ]);

        if ($data) {
            return DB::table('sxt_designations_mst')->select('*')->get();
        }

    }
    public function deleteDesignation(Request $request)
    {
        $id = request()->input('id');
        $data = DB::table('sxt_designations_mst')->where('designation_id', $id)->delete();
        if ($data) {
            return DB::table('sxt_designations_mst')->select('*')->get();
        }
    }
    //End Designation

    //Division
    public function addDivision(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'department_id' => 'required',
            'email' => 'required',
        ]);

        $data = DB::table('sxt_division_mst')->insert([
            'division_name' => $request->name,
            'department_id' => $request->department_id,
            'division_email' => $request->email,
        ]);
        if ($data) {
            return DB::table('sxt_division_mst')->select('*')->get();
        }
    }

    public function getAllDivisions(Request $request)
    {
        return DB::table('sxt_division_mst')->
            leftJoin('sxt_departments_mst', 'sxt_division_mst.department_id', '=', 'sxt_departments_mst.department_id')->
            select('*')->get();
    }

    public function getDivision(Request $request)
    {
        $id = request()->input('id');
        return DB::table('sxt_division_mst')->where('division_id', $id)->first();
    }

    public function updateDivision(Request $request)
    {
        $id = request()->input('id');
        $data = DB::table('sxt_division_mst')->where('division_id', $id)->update([
            'division_name' => $request->name,
            'department_id' => $request->department_id,
            'division_email' => $request->email,
        ]);

        if ($data) {
            return DB::table('sxt_division_mst')->select('*')->get();
        }

    }
    public function deleteDivision(Request $request)
    {
        $id = request()->input('id');
        $data = DB::table('sxt_division_mst')->where('division_id', $id)->delete();
        if ($data) {
            return DB::table('sxt_division_mst')->select('*')->get();
        }
    }
    //End Division

}