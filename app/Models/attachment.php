<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class attachment extends Model
{
    use HasFactory;
    protected $fillable=['PIN_NO','FILE_NAME','ANALYSIS_REPORT'];
    protected $table='IRO_DATA_ATT';
    protected $connection = 'oracle';
}
