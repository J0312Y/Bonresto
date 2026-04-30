// JavaScript Document
$(document).ready(function () {
    "use strict";

    // ----------------------------
    // Select2 pour recherche dynamique
    // ----------------------------
    function initSelect2(selector, placeholder, url) {
        $(selector).select2({
            placeholder: placeholder,
            minimumInputLength: 1,
            ajax: {
                url: url,
                dataType: 'json',
                delay: 250,
                data: function () {
                    return { csrf_test_name: basicinfo.csrftokeng };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return { id: item.id, text: item.text };
                        })
                    };
                },
                cache: true
            }
        });
    }

    initSelect2('.search-table-field', lang.type_slorder, 'ongoingtable_name');
    initSelect2('.search-tablesr-field', lang.type_table, 'ongoingtablesearch');

    // ----------------------------
    // DataTable pour Ongoing Orders
    // ----------------------------
    var ongoingOrderTable = $('#OngoingOrders').DataTable({
        responsive: true,
        paging: true,
        serverSide: true,
        processing: true,
        searching: true,
        ajax: {
            url: basicinfo.baseurl + "ordermanage/order/ongoingorders",
            type: "POST",
            data: function (d) {
                d.csrf_test_name = $('#csrfhashresarvation').val();
            }
        },
        lengthMenu: [[25, 50, 100, -1], [25, 50, 100, "All"]],
        dom: 'Bfrtip',
        buttons: [
            { extend: 'copy', className: 'btn-sm', footer: true },
            { extend: 'csv', className: 'btn-sm', footer: true },
            { extend: 'excel', className: 'btn-sm', footer: true },
            { extend: 'pdf', className: 'btn-sm', footer: true },
            { extend: 'print', className: 'btn-sm', footer: true },
            { extend: 'colvis', className: 'btn-sm', footer: true }
        ],
        "createdRow": function (row, data) {
            if (data[10] == 1) { // Marquer certaines lignes si besoin
                $(row).css('background-color', '#e5cc34c4');
            } else {
                $(row).css('background-color', '#ffffff');
            }
        },
        "footerCallback": function (row, data, start, end, display) {
            var api = this.api();

            var intVal = function (i) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '') * 1 :
                    typeof i === 'number' ? i : 0;
            };

            // Total sur toutes les pages
            var total = api.column(8).data().reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

            // Total sur la page courante
            var pageTotal = api.column(8, { page: 'current' }).data().reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

            $(api.column(8).footer()).html(pageTotal.toFixed(2) + ' (' + total.toFixed(2) + ' total)');
        }
    });

    // ----------------------------
    // Refresh automatique toutes les 10 secondes
    // ----------------------------
    setInterval(function () {
        ongoingOrderTable.ajax.reload(null, false); // false = ne pas réinitialiser la pagination
    }, 10000); // 10000ms = 10 secondes
});
