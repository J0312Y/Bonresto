// JavaScript Document
$(document).ready(function () {
    "use strict";

    // Initialisation DataTable QR Order
    var qroredrlist = $('#allqrorder').DataTable({
        responsive: true,
        paging: true,
        searching: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: basicinfo.baseurl + "ordermanage/order/allqrorder",
            type: "post",
            data: function (data) {
                data.csrf_test_name = $('#csrfhashresarvation').val();
            }
        },
        dom: 'Bfrtip',
        lengthMenu: [[25, 50, 100, 150, 200, 500, -1], [25, 50, 100, 150, 200, 500, "All"]],
        createdRow: function (row, data) {
            if (data[10] == 1) {
                $(row).css('background-color', '#e5cc34c4'); // Highlight new order
            } else {
                $(row).css('background-color', '#ffffff');
            }
        },
        buttons: [
            { extend: 'copy', className: 'btn-sm', footer: true },
            { extend: 'csv', className: 'btn-sm', footer: true },
            { extend: 'excel', className: 'btn-sm', footer: true },
            { extend: 'pdf', className: 'btn-sm', footer: true },
            { extend: 'print', className: 'btn-sm', footer: true },
            { extend: 'colvis', className: 'btn-sm', footer: true }
        ],
        language: {
            sProcessing: lang.Processingod,
            sSearch: lang.search,
            sLengthMenu: lang.sLengthMenu,
            sInfo: lang.sInfo,
            sInfoEmpty: lang.sInfoEmpty,
            sInfoFiltered: lang.sInfoFiltered,
            sLoadingRecords: lang.sLoadingRecords,
            sZeroRecords: lang.sZeroRecords,
            sEmptyTable: lang.sEmptyTable,
            oPaginate: {
                sFirst: lang.sFirst,
                sPrevious: lang.sPrevious,
                sNext: lang.sNext,
                sLast: lang.sLast
            },
            oAria: {
                sSortAscending: ":" + lang.sSortAscending + '"',
                sSortDescending: ":" + lang.sSortDescending + '"'
            },
            select: {
                rows: {
                    "_": lang._sign,
                    "0": lang._0sign,
                    "1": lang._1sign
                }
            },
            buttons: {
                copy: lang.copy,
                csv: lang.csv,
                excel: lang.excel,
                pdf: lang.pdf,
                print: lang.print,
                colvis: lang.colvis
            }
        },
        footerCallback: function (row, data, start, end, display) {
            var api = this.api();

            var intVal = function (i) {
                return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
            };

            var total = api.column(8).data().reduce((a, b) => intVal(a) + intVal(b), 0);
            var pageTotal = api.column(8, { page: 'current' }).data().reduce((a, b) => intVal(a) + intVal(b), 0);

            $(api.column(8).footer()).html(pageTotal.toFixed(2) + ' (' + total.toFixed(2) + ' total)');
        }
    });

    // Rafraîchissement automatique toutes les 15 secondes
    setInterval(function () {
        qroredrlist.ajax.reload(null, false);
        load_unseen_notification();
    }, 15000);

    // Premier chargement des notifications
    load_unseen_notification();
});
