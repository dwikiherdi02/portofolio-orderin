import { showErrorValidation } from './func';

let isFormAjax = "";
$(function () {
    $(document).ajaxError(function(e, xhr) {
        if (
            xhr.status == 0 ||
            xhr.status == 500 ||
            xhr.status == 422
        ) return false;

        var res = xhr.responseJSON;
        let message = "";
        let isReload = false;
        let additionalSetting = {};
        switch (xhr.status) {
            case 419:
                message = "Session timeout";
                isReload = true;
                break;
            case 403:
                if (res.message != "") {
                    message = res.message;
                }
        }

        if (isReload == true) {
            additionalSetting = {
                onClose: () => {this.location.reload();}
            }
        }

        callout("Failed", message, {type: "danger"}, additionalSetting);
    });

    $('.form-ajax').submit(function(event) {
        event.preventDefault();
        if (isFormAjax != "") {
            isFormAjax.abort();
        }

        const form = $(this)

        let formData = new FormData(form[0]);

        let formAction = form.attr("action");

        let dataCallback = form.data("callback");

        let dataSubmitBtn = form.data("submit-button");

        let btnSubmit = form.find("button[type=submit]");
        if (dataSubmitBtn != undefined && dataSubmitBtn  != "") {
            btnSubmit = $(dataSubmitBtn);
        }

        let btnSubmitText = btnSubmit.html();

        isFormAjax = $.ajax({
            type: "POST",
            dataType: "json",
            url: formAction,
            // data: form.serialize(),
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                $(".form-error-message").text("");
                btnSubmit.prop("disabled", true);
                btnSubmit.html(`
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    <span class="sr-only">Loading...</span>
                `);
            },
            success: function() {
                isFormAjax = "";
                form.unbind('submit').submit(); // continue the submit unbind preventDefault
            },
            error: function(xhr) {
                isFormAjax = "";
                btnSubmit.prop("disabled", false);
                btnSubmit.html(btnSubmitText);
                const res = xhr.responseJSON;

                // if(xhr.status == 0) { showAlert(2, true); return; }

                if(xhr.status == 422 || res.data != undefined) {
                    const errors = res.data;
                    if(dataCallback != undefined && dataCallback != "") {
                        eval(dataCallback)
                    } else {
                        showErrorValidation(form, errors)
                    }
                }
            }
        });
    });
});
