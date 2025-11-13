// JavaScript Document
$(document).ready(function () {
  "use strict";

  var todayOrderTable = $("#todayorder").DataTable({
    responsive: true,
    paging: true,
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
        sLast: lang.sLast,
      },
      oAria: {
        sSortAscending: ":" + lang.sSortAscending + '"',
        sSortDescending: ":" + lang.sSortDescending + '"',
      },
      select: {
        rows: {
          _: lang._sign,
          0: lang._0sign,
          1: lang._1sign,
        },
      },
      buttons: {
        copy: lang.copy,
        csv: lang.csv,
        excel: lang.excel,
        pdf: lang.pdf,
        print: lang.print,
        colvis: lang.colvis,
      },
    },
    dom: "Bfrtip",
    lengthMenu: [
      [25, 50, 100, 150, 200, 500, -1],
      [25, 50, 100, 150, 200, 500, "All"],
    ],
    buttons: [
      { extend: "copy", className: "btn-sm", footer: true },
      { extend: "csv", title: "TodayOrder", className: "btn-sm", footer: true },
      { extend: "excel", title: "TodayOrder", className: "btn-sm", footer: true },
      { extend: "pdf", title: "TodayOrder", className: "btn-sm", footer: true },
      { extend: "print", className: "btn-sm", footer: true },
      { extend: "colvis", className: "btn-sm", footer: true },
    ],
    searching: true,
    processing: true,
    serverSide: true,
    ajax: {
      url: basicinfo.baseurl + "ordermanage/order/todayallorder",
      type: "post",
      data: function (data) {
        data.csrf_test_name = $("#csrfhashresarvation").val();
      },
    },
    footerCallback: function (row, data, start, end, display) {
      var api = this.api();
      var intVal = function (i) {
        return typeof i === "string"
          ? i.replace(/[\$,]/g, "") * 1
          : typeof i === "number"
          ? i
          : 0;
      };

      var total = api
        .column(7)
        .data()
        .reduce(function (a, b) {
          return intVal(a) + intVal(b);
        }, 0);

      var pageTotal = api
        .column(7, { page: "current" })
        .data()
        .reduce(function (a, b) {
          return intVal(a) + intVal(b);
        }, 0);

      pageTotal = pageTotal.toFixed(2);
      total = total.toFixed(2);

      $(api.column(7).footer()).html(pageTotal + " ( " + total + " total)");
    },
  });

  // --- REFRESH AUTOMATIQUE toutes les 30 secondes (30000 ms) ---
  setInterval(function () {
    todayOrderTable.ajax.reload(null, false); // false = ne pas réinitialiser la pagination
  }, 30000);
});
