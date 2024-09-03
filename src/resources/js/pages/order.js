
if (isMenu["order"] == true) {
    $(function () {
        loadList();
    });

    $("#frm-search").on("keypress", function (e) {
        var key = e.which;
        if (key == 13)   {
            loadList();
        }
    });

    $("#btn-search").on("click", function (e) {
        loadList();
    });

    $(document).on("click", ".btn-add-cart", function (e) {
        const t = $(this);
        const product = t.data("content");
        const productID = t.data("id");

        console.log(product);
        console.log(productID);
    });

    const addCart = (_this) => {
        console.log(_this);
    }

    const loadList = () => {
        $.ajax({
            url: url.productlist,
            type: 'GET',
            dataType: 'json',
            data: {search: $("#frm-search").val()},
            beforeSend: function() {
                $("#items-content").hide();
                $("#items-content").empty();
                $("#items-content-placeholder").show();
            },
        })
        .done(function(res) {
            $("#items-content").show();
            $("#items-content-placeholder").hide();
            const results = res.results;

            $.each(results, function (key, val) {
                $("#items-content").append(val);
            });
        })
        .fail(function(err) {
            $("#items-content").show();
            $("#items-content-placeholder").hide();
            console.log("error");
            console.log(err);
        });
    }
}
