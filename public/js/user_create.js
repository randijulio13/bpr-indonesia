$(function () {
    function readURL(input, tag) {
        let id = $(tag).attr("id");
        if (input.target.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $(`#preview_${id}`).attr("src", e.target.result);
                $(`#preview_${id}`).parent().show();
            };
            reader.readAsDataURL(input.target.files[0]);
            return true;
        } else {
            $(`#preview_${id}`).parent().hide();
            $("#form-register").trigger("reset");
            return false;
        }
    }

    $("#ktp_photo").on("change", async function (e) {
        try {
            $("#card-form").LoadingOverlay('show');
            if (!readURL(e, this)) return;

            $("#btn-upload")
                .addClass("disabled")
                .html(
                    `<div class="spinner-border spinner-border-sm" role="status"></div> Upload KTP`
                );
            let data = new FormData();
            data.append("ktp_photo", $("#ktp_photo").val());

            let res = await ocrKTP(data);
            res = res.data;
            $("#nik").val(res.nik);
            $("#name").val(res.name);
            $("#dob").val(res.dob);
            $("#pob").val(res.pob);
            $("#gender").val(res.gender);
            $("#address").val(res.address);
            $("#state_id").val(res.state_id).trigger("change");
            await set_state();
            $("#district_id").val(res.district_id).trigger("change");
            await set_district();
            $("#mobile").focus();
        } catch (err) {
            mySwal.fire({
                icon: "error",
                title: "Error",
                text: err,
                timer: 2000,
                showConfirmButton: false,
                timerProgressBar: true,
            });
        } finally {
            $('#card-form').LoadingOverlay('hide')
            $("#btn-upload")
                .removeClass("disabled")
                .html(`<i class="bi bi-upload"></i> Upload KTP`);
        }
    });

    function ocrKTP(data) {
        return new Promise(async (resolve, reject) => {
            try {
                let res = await $.ajax({
                    processData: false,
                    contentType: false,
                    type: "post",
                    url: "/user/ocr_ktp",
                    data,
                });
                resolve(res);
            } catch (err) {
                reject(err);
            }
        });
    }

    async function getLocation(type, id) {
        let url = `/location?type=${type}&id=${id}`;
        return await $.get(url);
    }

    $("#preview_selfie_photo, #preview_ktp_photo").on("click", function (e) {
        $(this).siblings(".form-group").find("input").trigger("click");
    });

    async function set_state() {
        let id = $("#state_id").val();
        let list = await getLocation("district", id);
        $("#district_id")
            .html(
                '<option value="" selected disabled>-- Pilih Kota --</option>'
            )
            .removeAttr("disabled");
        await $.each(list, function (index, district) {
            $("#district_id").append(
                `<option value="${district.district_id}">${district.label}</option>`
            );
        });
    }

    async function set_district() {
        let id = $("#district_id").val();
        let list = await getLocation("sub_district", id);
        $("#sub_district_id")
            .html(
                '<option value="" selected disabled>-- Pilih Kecamatan --</option>'
            )
            .removeAttr("disabled");
        await $.each(list, function (index, sub_district) {
            $("#sub_district_id").append(
                `<option value="${sub_district.sub_district_id}">${sub_district.label}</option>`
            );
        });
    }

    $("#state_id").on("change", async function (e) {
        set_state();
        $("#sub_district_id")
            .html(
                '<option value="" selected disabled>-- Pilih Kecamatan --</option>'
            )
            .attr("disabled", true);
    });

    $("#district_id").on("change", async function (e) {
        let id = $(this).val();
        let list = await getLocation("sub_district", id);
        $("#sub_district_id")
            .html(
                '<option value="" selected disabled>-- Pilih Kecamatan --</option>'
            )
            .removeAttr("disabled");
        $.each(list, function (index, sub_district) {
            $("#sub_district_id").append(
                `<option value="${sub_district.sub_district_id}">${sub_district.label}</option>`
            );
        });
    });

    $("#form-register").on("change", function () {
        if ($("#toa").is(":checked")) {
            $(".btn-submit").prop("disabled", false);
        } else {
            $(".btn-submit").prop("disabled", true);
        }
    });

    $("#form-register").on("submit", async function (e) {
        e.preventDefault();
        try {
            let data = new FormData(this);
            let res = await $.ajax({
                url: "/user",
                data,
                type: "post",
                contentType: false,
                processData: false,
            });
            if (res.status == "OK") {
                window.location.href = res.route;
            }
        } catch (err) {
            if (err.status == 422) {
                console.log(err);
                errorFeedback(err);
                mySwal.fire({
                    title: "Error",
                    icon: "error",
                    text: "Periksa kembali form anda",
                    showConfirmButton: false,
                    timerProgressBar: true,
                    timer: 2000,
                });
            } else {
                mySwal.fire({
                    title: "Error",
                    icon: "error",
                    text: err.responseJSON.message,
                    showConfirmButton: false,
                    timerProgressBar: true,
                    timer: 2000,
                });
            }
        }
    });

    $("#btn-upload").on("click", function (e) {
        e.preventDefault();
        $("#ktp_photo").trigger("click");
    });
});
