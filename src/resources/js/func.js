import DataTable from 'datatables.net-bs5';
import Swal from 'sweetalert2';
import 'animate.css';

const showErrorValidation = (form, errors) => {
    form.find(".form-error-message").each(function (_, element) {
        const el = $(element);
        const _for = el.attr("for-name");
        if(errors[_for]) {
            el.text(errors[_for].replace("id", ""));
        }
    });
}

const replaceObject = (obj, destObj) => {
    const objReplace = Object.keys(obj);
    for (let index = 0; index < objReplace.length; index++) {
        const key = objReplace[index];
        if (key == "icon") { continue; }
        destObj[key] = obj[key];
    }
    return destObj;
}

const mergeObject = (...obj) => {
    let mObj = {};
    obj.forEach((_, index) => {
        var rObj = Object.keys(obj[index]);
        for (let i = 0; i < rObj.length; i++) {
            const key = rObj[i];
            mObj[key] = obj[index][key];
        }
    });
    return mObj;
}

let _uploadImg = {};
const uploadImgInit = (name="") => {
    _uploadImg[name]  = {
        "imgThumb": $(`#image-thumbnail-${name}`),
        "btnUpload": $(`#btn-upload-${name}`),
        "btnRemove": $(`#btn-remove-upload-${name}`),
        "fileInp": $(`#upload-${name}`),
        "img": $(`#image-thumbnail-${name}`).find("img"),
        "isrm": $(`#isrm-${name}`),
    };


    $(function () {
        if (_uploadImg[name].img.attr("src") != "") {
            _uploadImg[name].btnRemove.show();
        } else {
            _uploadImg[name].btnRemove.hide();
        }

        _uploadImg[name].btnUpload.on("click", function (e) {
            e.preventDefault();
            _uploadImg[name].fileInp.trigger("click");
        });

        _uploadImg[name].fileInp.change(function (e) {
            _uploadImg[name].imgThumb.removeClass("image-thumbnail-active");
            _uploadImg[name].isrm.val(1);
            let file = this.files[0];
            if (file) {
                _uploadImg[name].btnRemove.show();
                let reader = new FileReader();
                reader.onload = function (event) {
                    _uploadImg[name].imgThumb.addClass("image-thumbnail-active");
                    _uploadImg[name].img.attr("src", event.target.result);
                };
                reader.readAsDataURL(file);
            } else {
                _uploadImg[name].btnRemove.hide();
            }
        });

        _uploadImg[name].btnRemove.on("click", function (e) {
            e.preventDefault();
            _uploadImg[name].fileInp.val("");
            _uploadImg[name].fileInp.trigger("change");
            _uploadImg[name].img.attr("src", "");
        });
    });
}

let _dttable = {};
let _dttableOpt = {
    dom: `<"card-body px-0 table-responsive" t><"card-footer bg-transparent border-0" <"d-flex flex-column flex-sm-row justify-content-between align-items-center" <"order-2 order-sm-1" l> <"order-1 order-sm-2" p>>>`,
    responsive: false,
    autoWidth: false,
    processing: false,
    pagingType: `first_last_numbers`,
    oLanguage: {
        sLengthMenu:  `_MENU_`,
        oPaginate: {
            sFirst: `<i class="fas fa-step-backward"></i>`,
            sLast: `<i class="fas fa-step-forward"></i>`,
        },
    },
    lengthMenu: [ [10, 25, 50, 100], [10, 25, 50, 100] ],
    fnDrawCallback: function(oSettings) {
        if (oSettings._iDisplayLength > oSettings.fnRecordsDisplay()) {
            $(oSettings.nTableWrapper).find('.dataTables_paginate').hide();
        } else {
            $(oSettings.nTableWrapper).find('.dataTables_paginate').show();
        }
    }
};
const initDataTable = (id, opt) => {
    _dttableOpt = mergeObject(_dttableOpt, opt);
    _dttable[id] = new DataTable(`#${id}`, _dttableOpt);
}

const deleteData = (el, callback) => {
    const url = $(el).data("href");
    let swalCustom = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-danger",
            cancelButton: "btn btn-link text-dark"
        },
        buttonsStyling: false
    });
    swalCustom.fire({
        text: "Deleted data cannot be recovered. Are you sure?",
        icon: "warning",
        showClass: { popup: ` animate__animated animate__pulse animate__faster ` },
        hideClass: { popup: ``},
        showCancelButton: true,
        confirmButtonText: "Yes!",
        cancelButtonText: "Cancel",
        showLoaderOnConfirm: true,
        allowOutsideClick: () => !Swal.isLoading(),
        preConfirm: async () => {
            swalCustom = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-dark",
                },
                buttonsStyling: false
            });
            try {
                await processDelete(url)
                swalCustom.fire({
                    text: "The data has been successfully deleted.",
                    icon: "success",
                    showClass: { popup: ` animate__animated animate__pulse animate__faster ` },
                    hideClass: { popup: ``},
                    confirmButtonText: "Oke",
                }).then((result) => {
                    if (result.isConfirmed) {
                        if(callback != undefined) {
                            eval(callback);
                        }
                    }
                });
            } catch (error) {
                let res = error.responseJSON;
                let message = "The data deletion failed, please contact the admin.";
                if (res.message != "") {
                    message = res.message;
                }
                swalCustom.fire({
                    text: message,
                    icon: "error",
                    showClass: { popup: ` animate__animated animate__pulse animate__faster ` },
                    hideClass: { popup: ``},
                    confirmButtonText: "Oke",
                });
            }
        }
    });
}

const processDelete = (url) => {
    return $.ajax({
        type: "post",
        url: url,
        data: {"_method" : "delete"},
        dataType: "json"
    });
}

const reloadTable = (id) => {
    _dttable[`${id}`].ajax.reload();
}

const toRupiah = (number, withSymbol=true) => {
    let opt = { style: 'currency', currency: 'IDR' };

    if (!withSymbol) {
        opt["currencyDisplay"] = "code";
    }

    let formattedNumber =  new Intl.NumberFormat( 'id-ID', opt ).format(number);

    if (!withSymbol) {
        return formattedNumber.replace("IDR", "").trim()
    }

    return formattedNumber
}

export { _dttable, deleteData, initDataTable, mergeObject, processDelete, reloadTable, replaceObject, showErrorValidation, toRupiah, uploadImgInit};
