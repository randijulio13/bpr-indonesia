@extends('layouts.app')

@section('style')
<style>
    .hide-this {
        display: none;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-sm-10 col-xs-12">
            <div class="my-5">
                <h3>Liveness Detection</h3>
            </div>
            <div class="card card-body">
                <video id="video-webcam" class="video-window mirror-video" autoplay="true" muted playsinline style="border: transparent; border-radius: 25px;">
                </video>
                <canvas id="canvas-camera" class="hide-this mirror-image">
                    <img id="img-camera">
                </canvas>
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <button class="btn btn-primary btn-lg take-photo mt-4" style="padding:10px 70px"><i class="bi bi-camera-fill"></i> Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript" src="{{ asset('js/liveness.js') }}"></script>
@endsection