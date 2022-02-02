@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="my-5">
                <h3>Tambah Data Nasabah</h3>
                <div class="row">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('user.index') }}" class="btn btn-danger"><i class="bi bi-arrow-left"></i> Kembali</a>
                        <a href="/user/upload_ktp" class="btn btn-danger" id="btn-upload"><i class="bi bi-upload"></i> Upload KTP</a>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body" id="card-form">
                    <div class="container-fluid py-4">
                        <form action="{{ route('user.store') }}" method="POST" id="form-register">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group mb-4">
                                        <label for="nik">NIK <span class="text-danger">*</span></label>
                                        <input type="file" style="display:none;" name="ktp_photo" id="ktp_photo">
                                        <input type="text" name="nik" id="nik" class="form-control" value="{{  request()->session()->get('form-registration')['nik'] ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-4">
                                        <label for="name">Nama <span class="text-danger">*</span></label>
                                        <input type="text" name="name" id="name" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="form-group mb-4">
                                        <label for="pob">Tempat Lahir <span class="text-danger">*</span></label>
                                        <input type="text" name="pob" class="form-control" id="pob">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="form-group mb-4">
                                        <label for="dob">Tanggal Lahir <span class="text-danger">*</span></label>
                                        <input type="text" name="dob" class="form-control" placeholder="dd/mm/yyyy" id="dob">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="form-group mb-4">
                                        <label for="gender">Jenis Kelamin <span class="text-danger">*</span></label>
                                        <select name="gender" id="gender" class="form-control">
                                            <option value="" selected disabled>-- Pilih Jenis Kelamin --</option>
                                            <option value="0">Perempuan</option>
                                            <option value="1">Laki-laki</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="form-group mb-4">
                                        <label for="mobile">Nomor Telepon <span class="text-danger">*</span></label>
                                        <input type="number" name="mobile" class="form-control" id="mobile" placeholder="081234567890">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-4">
                                        <label for="email">E-mail <span class="text-danger">*</span></label>
                                        <input type="text" name="email" id="email" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-4">
                                        <label for="email_confirmation">Konfirmasi E-mail <span class="text-danger">*</span></label>
                                        <input type="text" name="email_confirmation" id="email_confirmation" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="form-group mb-4">
                                        <label for="address">Alamat <span class="text-danger">*</span></label>
                                        <input type="text" name="address" id="address" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group mb-4">
                                        <label for="zip_code">Kode Pos <span class="text-danger">*</span></label>
                                        <input type="text" name="zip_code" id="zip_code" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group mb-4">
                                        <label for="state_id">Provinsi <span class="text-danger">*</span></label>
                                        <select name="state_id" id="state_id" class="form-control">
                                            <option value="" selected disabled>-- Pilih Provinsi --</option>
                                            @foreach($states as $state)
                                            <option value="{{ $state->state_id }}">{{ $state->label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group mb-4">
                                        <label for="district_id">Kota <span class="text-danger">*</span></label>
                                        <select name="district_id" id="district_id" class="form-control" disabled>
                                            <option value="" selected disabled>-- Pilih Kota --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group mb-4">
                                        <label for="sub_district_id">Kecamatan <span class="text-danger">*</span></label>
                                        <select name="sub_district_id" id="sub_district_id" class="form-control" disabled>
                                            <option value="" selected disabled>-- Pilih Kecamatan --</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 mb-4" style="display:none;">
                                <h4>KTP Photo</h4>
                                <img src="" alt="" class="img-thumbnail img-preview img-fluid" id="preview_ktp_photo">
                            </div>
                            <div class="col-lg-4 col-md-6 mb-4" style="display:none;">
                                <h4>Selfie Photo</h4>
                                <img src="" alt="" class="img-thumbnail img-preview img-fluid" id="preview_selfie_photo">
                            </div>
                            <div class="col-12">
                                <div class="form-check justify-content-center mx-2 mb-4">
                                    <input class="form-check-input" type="checkbox" value="" id="toa">
                                    <label class="form-check-label" for="toa">
                                        Dengan ini saya menyatakan, bahwa semua informasi yang saya berikan adalah lengkap dan benar.
                                    </label>
                                </div>
                                <button class="btn btn-primary px-4 py-2 btn-submit" disabled type="submit"><i class="bi bi-send-fill"></i> Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('js/user_create.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
@endsection

@section('modal')
<div class="modal fade" id="modalKTP" data-backdrop="static" data-keyboard="false" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            </div>

        </div>
    </div>
</div>


@endsection