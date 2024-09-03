
import { initDataTable } from "../func";

if (isMenu.customer) {
    $(function () {
        initDataTable('tbl-list', {
            columns: [
                {data:"id", name:"id", searchable:false, orderable:true},
                {data:"name", name:"name", searchable:true, orderable:true},
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
                $(row).find('td:eq(2)').addClass("text-start");
                $(row).find('td:eq(4)').addClass("text-center");
            },
        });
    });
}
