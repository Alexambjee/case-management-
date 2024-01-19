<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\BelongsToRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;

class SxtUser extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [
        'user_name',
        'role_id',
        'created_by',
        'last_name',
        'other_names',
        'email_address',
        'status',
        'password',
        'USER_ID',
        'status'
];
    protected $table='sxt_user_mst';
    public function role(){
        return $this->belongsTo('App\Models\SxtRole','role_id');
    }


}
