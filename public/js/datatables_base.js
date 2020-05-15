$(function(){
  $("#data-table").DataTable({
    "language": {
      "url": "//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Japanese.json"
    },
    "paging": true,
  });
  $("#data-table1").DataTable({
    "language": {
        "url": "//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Japanese.json"
    },
    "paging": true,
  });
  $(".data-table-no-order").DataTable({
    "language": {
      "url": "//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Japanese.json"
    },
    "paging": true,
    "ordering": false,
  });
});
