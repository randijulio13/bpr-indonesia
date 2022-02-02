<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nik'   => ['required'],
            'name'  => ['required'],
            'pob'  => ['required'],
            'dob'  => ['required'],
            'gender'  => ['required'],
            'mobile'  => ['required'],
            'email'  => ['required', 'unique:users', 'confirmed'],
            'address'   => ['required'],
            'zip_code'  => ['required'],
            'state_id'  => ['required'],
            'district_id'   => ['required'],
            'sub_district_id'   => ['required'],
            'ktp_photo' => ['required'],
            // 'selfie_photo'  => ['required']
        ];
    }

    function messages()
    {
        return [
            'required'  => ':attribute harus diisi!',
            'unique'    => ':attribute sudah digunakan'
        ];
    }
    
    function attributes()
    {
        return [
            'nik'   => 'NIK',
            'name'  => 'Nama',
            'pob'  => 'Tempat Lahir',
            'dob'  => 'Tanggal Lahir',
            'gender'  => 'Jenis Kelamin',
            'mobile'  => 'Nomor HP',
            'email'  => 'Email',
            'address'   => 'Alamat',
            'zip_code'  => 'Kode POS',
            'state_id'  => 'Provinsi',
            'district_id'   => 'Kota',
            'sub_district_id'   => 'Kecamatan',
            'ktp_photo' => 'Foto KTP',
            'selfie_photo'  => 'Foto Selfie'
        ];
    }
}
