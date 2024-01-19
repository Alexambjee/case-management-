<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SxtRole extends Model
{
    use HasFactory;
    protected $fillable =['role_id','role_name','role_desc','created_by'];
    public $primaryKey='role_id';
    protected $table='sxt_role_mst';
    // protected $connection = 'pgsql';
}