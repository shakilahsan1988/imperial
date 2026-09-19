(function($){
      
    "use strict";
  
    //active
    $('#doctors').addClass('active');
    $('#manage_doctors_link').addClass('active');
    $('#manage_doctors').addClass('menu-open');

    //doctors datatable
    var table=$('#doctors_table').DataTable( {
      dom: "<'row'<'col-sm-4'l><'col-sm-4'B><'col-sm-4'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-4'i><'col-sm-8'p>>",
      buttons: [
        {
            extend:    'copyHtml5',
            text:      '<i class="fas fa-copy"></i> '+trans("Copy"),
            titleAttr: 'Copy'
        },
        {
            extend:    'excelHtml5',
            text:      '<i class="fas fa-file-excel"></i> '+trans("Excel"),
            titleAttr: 'Excel'
        },
        {
            extend:    'csvHtml5',
            text:      '<i class="fas fa-file-csv"></i> '+trans("CVS"),
            titleAttr: 'CSV'
        },
        {
            extend:    'pdfHtml5',
            text:      '<i class="fas fa-file-pdf"></i> '+trans("PDF"),
            titleAttr: 'PDF'
        },
        {
          extend:    'colvis',
          text:      '<i class="fas fa-eye"></i>',
          titleAttr: 'PDF'
        }
        
      ],
      "processing": true,
      "serverSide": true,
      "bSort" : false,
      "ajax": {
        url: url("admin/get_doctors")
      },
      // orderCellsTop: true,
      fixedHeader: true,
      "columns": [
         {data:"id"},
         {data:"code"},
         {data:"name"},
         {data:"specialty"}, // searched via a server-side filterColumn (relation name, not a real doctors column)
         {data:"department"}, // searched via a server-side filterColumn (relation name, not a real doctors column)
         {data:"phone"},
         {data:"email"},
         {data:"schedule",searchable:false}, // computed from related branch schedules, no matching column
         {data:"consultation_fee"},
         {data:"video_consultation_fee"},
         {data:"video_consultation",searchable:false}, // computed Yes/No badge, no matching column
         {data:"commission"},
         {data:"total",searchable:false}, // computed accessor (sum of commissions), not a real column
         {data:"paid",searchable:false}, // computed accessor (sum of expenses), not a real column
         {data:"due",searchable:false}, // computed accessor (total - paid), not a real column
         {data:"action",searchable:false,orderable:false,sortable:false}//action
      ],
      "language": {
        "sEmptyTable":     trans("No data available in table"),
        "sInfo":           trans("Showing")+" _START_ "+trans("to")+" _END_ "+trans("of")+" _TOTAL_ "+trans("records"),
        "sInfoEmpty":      trans("Showing")+" 0 "+trans("to")+" 0 "+trans("of")+" 0 "+trans("records"),
        "sInfoFiltered":   "("+trans("filtered")+" "+trans("from")+" _MAX_ "+trans("total")+" "+trans("records")+")",
        "sInfoPostFix":    "",
        "sInfoThousands":  ",",
        "sLengthMenu":     trans("Show")+" _MENU_ "+trans("records"),
        "sLoadingRecords": trans("Loading..."),
        "sProcessing":     trans("Processing..."),
        "sSearch":         trans("Search")+":",
        "sZeroRecords":    trans("No matching records found"),
        "oPaginate": {
            "sFirst":    trans("First"),
            "sLast":     trans("Last"),
            "sNext":     trans("Next"),
            "sPrevious": trans("Previous")
        },
      }
   });

    //delete doctor
    $(document).on('click','.delete_doctor',function(e){
        e.preventDefault();
        var el=$(this);
        swal({
          title: trans("Are you sure to delete doctor ?"),
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: trans("Delete"),
          cancelButtonText: trans("Cancel"),
          closeOnConfirm: false
        },
        function(){
          $(el).parent().submit();
        });
    });

})(jQuery);

