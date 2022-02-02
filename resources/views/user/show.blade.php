@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="my-5">
                <h3>Profil Nasabah</h3>
                <a href="{{ route('user.index') }}" class="btn btn-danger"><i class="bi bi-arrow-left"></i> Kembali</a>
            </div>
            <div class="card card-profile card-body p-5 mb-4">
                <div class="row">
                    <div class="d-flex justify-content-between">
                        <h4><strong>{{ $user->name }}</strong></h4>
                        <a href="#" class="btn btn-danger"><i class="bi bi-pencil-fill"></i></a>
                    </div>
                    <p class="mb-4 text-secondary"> <i class="bi bi-envelope"></i> {{ $user->email }} </p>
                    <div class="alert px-4">
                        <div class="row">
                            <div class="col-lg-6">
                                <p class="mb-4"><strong>SALDO</strong>
                                    <br><span class="text-secondary"> {{ rupiah($user->balance->balance) }}</span>
                                </p>
                            </div>
                            <div class="col-lg-6">
                                <p class="mb-4"><strong>NIK</strong>
                                    <br><span class="text-secondary"> {{ $user->data->nik }}</span>
                                </p>
                            </div>
                            <div class="col-lg-12">
                                <p class="mb-4"><strong>TEMPAT / TANGGAL LAHIR</strong>
                                    <br><span class="text-secondary"> {{ $user->data->pob .' / '. $user->data->dob }}</span>
                                </p>
                            </div>
                            <div class="col-lg-12">
                                <p class="mb-4"><strong>ALAMAT</strong>
                                    <br><span class="text-secondary"> {{ $user->data->address }}, {{ get_sub_district($user->data->sub_district_id) }}, {{ get_district($user->data->district_id) }}<br>{{ get_state($user->data->state_id) }}, {{ $user->data->zip_code }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection