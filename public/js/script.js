function errorFeedback(err) {
    $('.is-invalid').removeClass('is-invalid')
    $.each(err.responseJSON.errors, function (index, value) {
        $(`#${index}`).parent().find('.invalid-feedback').remove()
        $(`#${index}`).addClass('is-invalid').parent().append(`<div class="invalid-feedback">${value}</div>`)
    })
}

const mySwal = Swal.mixin({
    customClass: {
        confirmButton: 'btn btn-primary py-2 px-4 mx-1',
        cancelButton: 'btn btn-danger py-2 px-4 mx-1'
    },
    buttonsStyling: false
})

AOS.init();

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});