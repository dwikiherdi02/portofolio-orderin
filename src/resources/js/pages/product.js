import { initDataTable, mergeObject, uploadImgInit } from '../func';

const _slc2Config = {
    theme: "bootstrap-5",
}

if (isMenu.product.wildcard) {
    if (isMenu.product.index) {
        $(function () {
            initDataTable('tbl-list', {
                columns: [
                    {data:"id", name:"id", searchable:false, orderable:true},
                    {data:"image", name:"image", searchable:false, orderable:false},
                    {data:"name", name:"name", searchable:true, orderable:true},
                    {data:"price", name:"price", searchable:true, orderable:true},
                    {data:"categories", name:"categories", searchable:true, orderable:false},
                    {data:"action", name:"action", searchable:false, orderable:false},
                ],
                "order": [[ 0, 'desc' ]],
                ajax: {
                    url: url.datatables,
                    beforeSend: function() {
                        if (typeof _dttable["tbl-list"] != "undefined" && _dttable["tbl-list"].hasOwnProperty('settings') && _dttable["tbl-list"].settings()[0].jqXHR != null) {
                            _dttable["tbl-list"].settings()[0].jqXHR.abort();
                        }
                    },
                    data: function (param) {
                        // param.search = $("#inp-filter-search").val();
                    }
                },
                processing: true,
                serverSide: true,
                createdRow: function( row, data, dataIndex ) {
                    $(row).find('td:eq(0)').addClass("text-center");
                    $(row).find('td:eq(1)').addClass("text-center");
                    $(row).find('td:eq(2)').addClass("text-start");
                    $(row).find('td:eq(3)').addClass("text-end");
                    $(row).find('td:eq(4)').addClass("text-center");
                    $(row).find('td:eq(5)').addClass("text-center");
                },
            });
        });
    }

    if (isMenu.product.create || isMenu.product.edit) {
        $(function () {
            let opt = _slc2Config;
            opt = mergeObject(opt, {tags: true});
            $("#categories").select2(opt);

            uploadImgInit("image");
        });
    }
}

