$(document).ready(function () {
    const moneyInputs = $(".money");
    moneyInputs.inputmask({
        alias: "decimal",
        groupSeparator: ".",
        autoGroup: true,
        autoUnmask: true,
    });

    $(".multiple-checkboxes").multiselect({
        includeSelectAllOption: true,
    });

    $(".summernote").summernote({
        toolbar: [
            ["style", ["bold", "italic", "underline", "clear"]],
            ["font", ["strikethrough", "superscript", "subscript"]],
            ["fontsize", ["fontsize"]],
            ["fontname", ["fontname"]],
            ["color", ["color"]],
            ["para", ["ul", "ol", "paragraph"]],
            ["height", ["height"]],
            ["table", ["table"]],
            ["view", ["fullscreen", "codeview", "help"]],
        ],
    });
    $(".select2").select2();
    $("#datatable").DataTable();
    $("#datatable-bordero").DataTable();
    $('[data-toggle="tooltip"]').tooltip();

    $("#buttondatatable").DataTable({
        dom: "lBfrtip",
        buttons: [
            {
                extend: "excel",
                className: "btn-sm",
            },
            {
                extend: "print",
                className: "btn-sm",
                orientation: "landscape",
            },
            {
                extend: "pdfHtml5",
                className: "btn-sm",
                orientation: "landscape",
            },
            {
                extend: "colvis",
                className: "btn-sm",
            },
        ],
    });
});

$(document)
    .ajaxStart(() => {
        swal("Harap Tunggu ...", "data sedang di proses", { button: false });
    })
    .ajaxStop(() => {
        swal.close();
    });

$("#datatable").on("click", ".show_confirm", function (e) {
    e.preventDefault();
    var form = $(this).parents("form");
    Swal.fire({
        title: "Konfirmasi",
        text: "Apakah anda yakin menghapus data ini?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "primary",
        cancelButtonColor: "#ff9191",
        confirmButtonText: "Ya, Hapus!",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.value) {
            form.submit();
        }
    });
});

const moneyRegex1 = /\B(?=(\d{3})+(?!\d))/g;
function moneyFormat(val) {
    return val.toString().replace(moneyRegex1, ",");
}

function labelMoneyFormat(val, tofixed = false) {
    if (val.toString().includes(".")) {
        if (tofixed) val = parseFloat(val).toFixed(2);
        let _val = val.toString().split(".");
        let _num = moneyFormat(_val[0]);
        let _dec = _val[1] ?? "00";
        return _num + "." + _dec;
    } else {
        return moneyFormat(parseFloat(val));
    }
}

async function axiosrequest(url, method = "get", data = null) {
    if (method == "get")
        return await axios
            .get(url)
            .then((res) => res.data)
            .catch((err) => {
                $("body").removeClass("loading");
                toastr.error(err.message);
                console.log("🚀 ~ axiosrequest ~ err:", err);
                return err;
            });
    else if (method == "post")
        return await axios
            .post(url, data)
            .then((res) => res.data)
            .catch((err) => {
                $("body").removeClass("loading");
                toastr.error(err.message);
                console.log("🚀 ~ axiosrequest ~ err:", err);
                return err;
            });
    else if (method == "put")
        return await axios
            .put(url, data)
            .then((res) => res.data)
            .catch((err) => {
                $("body").removeClass("loading");
                toastr.error(err.message);
                console.log("🚀 ~ axiosrequest ~ err:", err);
                return err;
            });
    else if (method == "delete")
        return await axios
            .delete(url)
            .then((res) => res.data)
            .catch((err) => {
                $("body").removeClass("loading");
                toastr.error(err.message);
                console.log("🚀 ~ axiosrequest ~ err:", err);
                return err;
            });
}

$(".general-datatable").DataTable({
    paging: true,
    order: [],
    dom: '<"top"f>rt<"bottom"lip><"clear">',
    lengthMenu: [
        [10, 25, 50, 100, -1],
        ["10 rows", "25 rows", "50 rows", "100 rows", "Show all"],
    ],
});
