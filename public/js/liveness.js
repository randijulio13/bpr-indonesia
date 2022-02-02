$(function () {
    let index = 0;
    let dataFile = [];
    let img;

    // seleksi elemen video
    var video = document.querySelector("#video-webcam");
    // minta izin user
    navigator.getUserMedia =
        navigator.getUserMedia ||
        navigator.webkitGetUserMedia ||
        navigator.mozGetUserMedia ||
        navigator.msGetUserMedia ||
        navigator.oGetUserMedia;

    // jika user memberikan izin
    if (navigator.getUserMedia) {
        // jalankan fungsi handleVideo, dan videoError jika izin ditolak
        navigator.getUserMedia(
            {
                video: true,
            },
            handleVideo,
            videoError
        );
    }

    // fungsi ini akan dieksekusi jika  izin telah diberikan
    function handleVideo(stream) {
        video.srcObject = stream;
    }

    // fungsi ini akan dieksekusi kalau user menolak izin
    function videoError(e) {
        // do something
        alert("Please allow to use your webcam");
    }

    // running video in iPhone
    if (navigator.mediaDevices.getUserMedia) {
        navigator.mediaDevices
            .getUserMedia({
                video: true,
            })
            .then(function (stream) {
                video.srcObject = stream;
                video.play();
            })
            .catch(function (e) {
                console.log("Something went wrong!");
            });
    }

    $(".take-photo").on("click", function () {
        takeSnapshot();
    });

    function takeSnapshot() {
        // buat elemen img
        img = document.querySelector("#img-camera");
        img.style.display = "none";
        var context;

        // ambil ukuran video
        var width = video.offsetWidth,
            height = video.offsetHeight;

        // buat elemen canvas
        var canvas = document.querySelector("#canvas-camera");
        canvas.width = width;
        canvas.height = height;

        // ambil gambar dari video dan masukan
        // ke dalam canvas
        context = canvas.getContext("2d");
        context.drawImage(video, 0, 0, width, height);

        // render hasil dari canvas ke elemen img
        img.src = canvas.toDataURL("image/jpeg");

        document.body.appendChild(img);

        dataFile.push(img.src);

        validationCapture();
    }

    function checkLiveness(formData) {
        return new Promise(async (resolve, reject) => {
            try {
                let res = await $.ajax({
                    type: "post",
                    processData: false,
                    contentType: false,
                    url: "/liveness",
                    data: formData,
                });
                resolve(res);
            } catch (err) {
                reject(err);
            }
        });
    }

    function validationCapture() {
        let formData = new FormData();

        formData.append("picture", dataFile);
        formData.append("index", index);
        $(".button-validate").prop("disabled", "disabled");

        mySwal
            .fire({
                title: "",
                text: "Would you like to use this photo?",
                imageUrl: dataFile,
                imageWidth: 400,
                showCancelButton: true,
                confirmButtonText: "Confirm",
                cancelButtonText: "Cancel",
                allowOutsideClick: false,
            })
            .then(async (e) => {
                if (e.isConfirmed) {
                    try {
                        mySwal.fire({
                            html: `<div class="d-flex justify-content-center">
                            <div class="spinner-border" role="status"></div>
                            </div><br><h4><strong>Loading</strong></h4>`,
                            imageUrl: dataFile,
                            imageWidth: 400,
                            allowOutsideClick: false,
                            showConfirmButton: false,
                        });
                        await checkLiveness(formData);
                        mySwal.fire({
                            icon: "success",
                            showConfirmButton: false,
                            title: "Berhasil",
                            timer: 2000,
                            timerProgressBar: true,
                        });
                    } catch (err) {
                        console.log(err);
                        mySwal.fire({
                            icon: "error",
                            title: "Error",
                            text: err,
                        });
                    }
                } else {
                    dataFile = [];
                    $(".button-validate").prop("disabled", false);
                }
            });
    }
});
