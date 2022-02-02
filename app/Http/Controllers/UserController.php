<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegistrationRequest;
use App\Models\State;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        session()->forget('form-registration');
        $states = State::get();
        return view('user.create', compact('states'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRegistrationRequest $req)
    {
        $req->validated();
        try {
            $input = $req->all();
            unset($input['_token']);

            $ktpName = md5($req->file('ktp_photo') . microtime()) . "." .
                $req->file('ktp_photo')->extension();
            $fileKtp64 = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $req->ktp64));

            Storage::disk('public')->put('/ktp_photo/' . $ktpName, $fileKtp64, 'public');
            $input['ktp_photo'] = Storage::disk('public')->get('/ktp_photo/' . $ktpName);

            session(['form-registration' => $input]);
            return response()->json([
                'status'    => 'OK',
                'route'     => route('liveness.index')
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status'    => 400,
                'message'   => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::with(['data', 'balance'])->find($id);
        return view('user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function ocr_ktp()
    {
        $res = '{"timestamp": 1643177295,"status": 200,"errors": {},"data": {"nik": "3273080509890001","nama": "MANAN SUKIYANTO","tempat_lahir": "PONOROGO,","tanggal_lahir": "05 09-1989","jenis_kelamin": "LAKILAKI","gol_darah": "a","alamat": "JLNEGLASARINO.","rt/rw": "007/004","kelurahan/desa": "CIUMBULEUI","kecamatan": "CIDADAP","agama": "ISLAM","status_perkawinan": "KAWIN","pekerjaan": "KARYAWAN SWASTA","kewarganegaraan": "WNI","provinsi": "PROVINSI SUMATERA SELATAN","kota": "OGAN KOMERING ULU SELATAN"}}';
        $json = json_decode($res, true);
        $json = $json['data'];

        $state_id = get_state_id($json['provinsi'], 75);
        $district_id =  get_district_id($json['kota'], $state_id, 75);

        $data = [
            'nik'       => $json['nik'],
            'name'      => $json['nama'],
            'dob'       => Carbon::createFromFormat('dmY', str_only($json['tanggal_lahir']))->format('m/d/Y'),
            'pob'       => str_only($json['tempat_lahir']),
            'gender'    => (similar_text($json['jenis_kelamin'], "Laki-laki") > 0) ? '1' : (similar_text($json['jenis_kelamin'], "Perempuan") > 0 ? '0' : ''),
            'address'   => $json['alamat'] . ' ' . $json['rt/rw'],
            'state_id'  => $state_id,
            'district_id'  => $district_id
        ];

        return response()->json([
            'status'    => 200,
            'message'   => 'OK',
            'data'      => $data
        ]);
    }

    public function datatables()
    {
        $users = User::with(['balance', 'data'])->whereHas('data')->whereHas('balance')->get();
        return datatables($users)
            ->addIndexColumn()
            ->setRowId(function ($data) {
                return $data->id;
            })
            ->addColumn('balance', function ($data) {
                return rupiah($data->balance->balance ?? 0);
            })
            ->addColumn('action', function ($data) {
                return '
                    <div class="btn-group dropstart">
                        <button type="button" class="btn btn-sm dropdown-toggle btn-dropdown" data-bs-toggle="dropdown">
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/user/' . $data->id . '">Detail</a></li>
                        </ul>
                    </div>';
            })
            ->rawColumns(['action'])
            ->toJson();
    }
}
