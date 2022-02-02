$(function () {
    $("#tableUser").DataTable({
        ajax: {
            url: "/user/datatables",
        },
        serverSide: true,
        processing: true,
        order: [[1, "asc"]],
        columns: [
            { data: "DT_RowIndex", class: "dt-center", orderable: false },
            { data: "name" },
            { data: "email" },
            { data: "data.mobile" },
            { data: "balance", class: "dt-right" },
            { data: "action", class: "dt-right" },
        ],
    });

    $(document).on("click", "#tableUser>tbody>tr", function () {
        $(this + ".btn-dropdown").trigger("click");
    });
});
