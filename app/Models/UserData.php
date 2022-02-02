<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserData extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','nik','name','email','pob','dob','gender','mobile','address','zip_code','state_id','district_id','sub_district_id','ktp_photo','selfie_photo'];
    
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    protected $hidden = [
        'updated_at',
        'created_at',
    ];
}
