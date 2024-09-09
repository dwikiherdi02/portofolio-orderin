import { initDataTable, toRupiah } from '../func';

if (isMenu.order.wildcard) {
    if (isMenu.order.index) {
        $(function () {
            initDataTable('tbl-list', {
                columns: [
                    {data:"id", name:"id", searchable:false, orderable:true},
                    {data:"customer", name:"customer", searchable:true, orderable:true},
                    {data:"order_no", name:"order_no", searchable:true, orderable:true},
                    {data:"ordered_at", name:"ordered_at", searchable:true, orderable:true},
                    {data:"created_at", name:"created_at", searchable:true, orderable:true},
                    {data:"total_items", name:"total_items", searchable:true, orderable:true},
                    {data:"total_price", name:"total_price", searchable:true, orderable:true},
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
                        param.search = $("#inp-filter-search").val();
                        param.ordered_at_from = $("#order-date-from").val();
                        param.ordered_at_to = $("#order-date-to").val();
                        param.created_at_from = $("#create-date-from").val();
                        param.created_at_to = $("#create-date-to").val();
                    }
                },
                processing: true,
                serverSide: true,
                createdRow: function( row, data, dataIndex ) {
                    $(row).find('td:eq(0)').addClass("text-center").css('vertical-align', 'middle');
                    $(row).find('td:eq(1)').addClass("text-start").css('vertical-align', 'middle');
                    $(row).find('td:eq(2)').addClass("text-center").css('vertical-align', 'middle');
                    $(row).find('td:eq(3)').addClass("text-center").css('vertical-align', 'middle');
                    $(row).find('td:eq(4)').addClass("text-center").css('vertical-align', 'middle');
                    $(row).find('td:eq(5)').addClass("text-center").css('vertical-align', 'middle');
                    $(row).find('td:eq(6)').addClass("text-end").css('vertical-align', 'middle');
                    $(row).find('td:eq(7)').addClass("text-center").css('vertical-align', 'middle');
                },
            });

            const reloadTable = () => {
                _dttable["tbl-list"].ajax.reload();
            }

            $("#frm-filter").on('submit', (e) => {
                e.preventDefault();
                reloadTable();
            });

            $("#btn-filter-clear").on("click", () => {
                $("#frm-filter")[0].reset();
                $("#order-date-from").val("");
                $("#order-date-to").val("");
                $("#create-date-from").val("");
                $("#create-date-to").val("");
                reloadTable();
            });
        });
    }

    if (isMenu.order.create) {
        let dataOrderedProduct = {};

        const rowOrderedProductTemplate = `
            <tr id="row-ordered-{{ID}}">
                <td class="text-start align-self-center" style="vertical-align: middle;">{{NAME}}</td>
                <td class="text-end align-self-center" style="vertical-align: middle;">
                    {{PRICE}}
                    <input type="hidden" name="detail[{{ID}}][price]" value="{{RAWPRICE}}">
                </td>
                <td class="text-center" style="vertical-align: middle;">
                    <div class="input-group input-group-sm form-counter">
                        <button type="button" class="btn btn-dark btn-decrease-count"><i class="fa-solid fa-minus"></i></button>
                        <input type="number" min="0" value="{{QTY}}" name="detail[{{ID}}][qty]" class="form-control text-center input-counter" aria-label="counter-qty" aria-describedby="counter-qty" readonly>
                        <button type="button" class="btn btn-dark btn-increase-count"><i class="fa-solid fa-plus"></i></button>
                    </div>
                </td>
            </tr>
        `;

        const loadOrderedProduct = () => {
            let ttlOrderedProduct = 0;
            const tbody = $("#tbl-ordered-product").find("tbody");
            tbody.empty();

            $.each(dataOrderedProduct, function (_, items) {
                let template = rowOrderedProductTemplate
                                .replaceAll(/{{ID}}/g, items.id)
                                .replaceAll(/{{NAME}}/g, items.name)
                                .replaceAll(/{{RAWPRICE}}/g, items.price)
                                .replaceAll(/{{PRICE}}/g, toRupiah(items.price, false))
                                .replaceAll(/{{QTY}}/g, items.qty);

                tbody.append(template);
                $(`#row-ordered-${items.id}`).data("rowOrderedID", items.id);

                ttlOrderedProduct = parseInt(ttlOrderedProduct) + (parseInt(items.price) * parseInt(items.qty));
            });

            $("#ttl-ordered-product").text(toRupiah(ttlOrderedProduct, false));
        }

        $(function () {
            loadOrderedProduct();
        });

        // decrease counter
        $(document).on("click", ".btn-decrease-count", function () {
            const _p = $(this).parent();
            const inp = _p.find("input[type=number]");
            const newQty = parseInt(inp.val()) - 1;

            const IDProduct = _p.parents("tr").data("rowOrderedID");

            if (newQty <= 0) {
                delete dataOrderedProduct[IDProduct];
            } else {
                dataOrderedProduct[IDProduct]["qty"] = newQty;
            }

            loadOrderedProduct();
        });

        // increase counter
        $(document).on("click", ".btn-increase-count", function () {
            const _p = $(this).parent();
            const inp = _p.find("input[type=number]");
            const newQty = parseInt(inp.val()) + 1;

            const IDProduct = _p.parents("tr").data("rowOrderedID");

            dataOrderedProduct[IDProduct]["qty"] = newQty;
            loadOrderedProduct();
        });

        $(document).on("click", ".btn-select-product", function (e) {
            e.preventDefault();
            const _t =  $(this);
            const row = _t.parents("tr");
            const data = row.data("rowData");
            if (dataOrderedProduct[data.id] == undefined) {
                data.qty = 1;
                dataOrderedProduct[data.id] = data;
            } else {
                dataOrderedProduct[data.id]["qty"]++;
            }
            loadOrderedProduct();
        })

        const mdlAddProduct = document.getElementById('mdl-list-products');
        mdlAddProduct.addEventListener('shown.bs.modal', event => {
            if (_dttable['tbl-add-product'] == undefined) {
                initDataTable('tbl-add-product', {
                    columns: [
                        {data:"id", name:"id", searchable:false, orderable:true},
                        {data:"name", name:"name", searchable:true, orderable:true},
                        {data:"price", name:"price", searchable:true, orderable:true},
                        {data:"action", name:"action", searchable:false, orderable:false},
                    ],
                    "order": [[ 1, 'asc' ]],
                    ajax: {
                        url: url.datatables.list_ordering,
                        beforeSend: function() {
                            if (typeof _dttable["tbl-add-product"] != "undefined" && _dttable["tbl-add-product"].hasOwnProperty('settings') && _dttable["tbl-add-product"].settings()[0].jqXHR != null) {
                                _dttable["tbl-add-product"].settings()[0].jqXHR.abort();
                            }
                        },
                        data: function (param) {
                            // param.search = $("#inp-filter-search").val();
                        }
                    },
                    processing: true,
                    serverSide: true,
                    createdRow: function( row, rawData, dataIndex ) {
                        const data = JSON.parse(rawData.data);
                        $(row).data("rowData", data);

                        // $(row).attr('id', `row-ordering-${data.id}`);
                        $(row).find('td').css('vertical-align', 'middle');

                        $(row).find('td:eq(0)').addClass("text-center");
                        $(row).find('td:eq(1)').addClass("text-start");
                        $(row).find('td:eq(2)').addClass("text-end");
                        $(row).find('td:eq(3)').addClass("text-center");
                    },
                });
            } else {
                _dttable['tbl-add-product'].ajax.reload();
            }
        })
    }
}
