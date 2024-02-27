<!DOCTYPE html>
<html lang="th">

<head>
   <title><?php echo $title; ?></title>
   <meta charset="utf-8">
   <meta name="robots" content="noindex, nofollow">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/4.3.1/jquery.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

   <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
   <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
   <script type="text/javascript" src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>

   <style id="compiled-css" type="text/css">
      table.dataTable.select tbody tr,
      table.dataTable thead th:first-child {
         cursor: pointer;
      }

      /* EOS */
   </style>

</head>

<body>
   <div class="container">
      <?php //print_r($_REQUEST); ?>
      <div class="my-4 h4">กรุณาเลือกกิจกรรมที่อนุญาตให้โรงเรียนส่งรายชื่อได้</div>
      <form id="frm-datatable" action="" method="POST">

         <table id="datatable" class="display select" cellspacing="0" width="100%">
            <thead>
               <tr>
                  <th><input name="select_all" value="1" type="checkbox"></th>
                  <?php
                  $col_th = array("กลุ่มสาระ", "ชื่อกิจกรรม", "ระดับชั้น");
                  foreach ($col_th as $key => $value) {
                     echo "<th>" . $value . "</th>";
                  }
                  ?>
               </tr>
            </thead>
         </table>

         <div><button type="submit" name="activity_selected" class="btn btn-primary">ดำเนินการต่อ</button></div>

      </form>
   </div>



   <script type="text/javascript">
      // Updates "Select all" control in a data table
      function updateDataTableSelectAllCtrl(table) {
         var $table = table.table().node();
         var $chkbox_all = $('tbody input[type="checkbox"]', $table);
         var $chkbox_checked = $('tbody input[type="checkbox"]:checked', $table);
         var chkbox_select_all = $('thead input[name="select_all"]', $table).get(0);

         // If none of the checkboxes are checked
         if ($chkbox_checked.length === 0) {
            chkbox_select_all.checked = false;
            if ('indeterminate' in chkbox_select_all) {
               chkbox_select_all.indeterminate = false;
            }

            // If all of the checkboxes are checked
         } else if ($chkbox_checked.length === $chkbox_all.length) {
            chkbox_select_all.checked = true;
            if ('indeterminate' in chkbox_select_all) {
               chkbox_select_all.indeterminate = false;
            }

            // If some of the checkboxes are checked
         } else {
            chkbox_select_all.checked = true;
            if ('indeterminate' in chkbox_select_all) {
               chkbox_select_all.indeterminate = true;
            }
         }
      }

      $(document).ready(function() {
         // Array holding selected row IDs
         var rows_selected = [];
         var table = $('#datatable').DataTable({
            'processing': true,
            'serverSide': true,
            'ajax': {
               'url': "select-activity-process-data.php", // json datasource
               'type': "post", // method  , by default get
            },
            'oLanguage': {
               'sSearch': 'ค้นหา:',
               'sLengthMenu': "แสดง _MENU_ บรรทัด",
               'sZeroRecords': 'ไม่พบข้อมูล',
               'sInfo': ' แสดง (_START_ to _END_) จาก _TOTAL_ รายการ',
               "oPaginate": {
                  "sFirst": "หน้าแรก",
                  "sPrevious": "ก่อนหน้า",
                  "sNext": "ถัดไป",
                  "sLast": "หน้าสุดท้าย"
               }
            },
            'columnDefs': [{
               'targets': 0,
               'searchable': false,
               'orderable': false,
               'width': '1%',
               'className': 'dt-body-center',
               'render': function(data, type, full, meta) {
                  return '<input type="checkbox">';
               }
            }],
            'order': [1, 'asc'],
            'rowCallback': function(row, data, dataIndex) {
               // Get row ID
               var rowId = data[0];

               // If row ID is in the list of selected row IDs
               if ($.inArray(rowId, rows_selected) !== -1) {
                  $(row).find('input[type="checkbox"]').prop('checked', true);
                  $(row).addClass('selected');
               }
            }
         });

         // Handle click on checkbox
         $('#datatable tbody').on('click', 'input[type="checkbox"]', function(e) {
            var $row = $(this).closest('tr');

            // Get row data
            var data = table.row($row).data();

            // Get row ID
            var rowId = data[0];

            // Determine whether row ID is in the list of selected row IDs
            var index = $.inArray(rowId, rows_selected);

            // If checkbox is checked and row ID is not in list of selected row IDs
            if (this.checked && index === -1) {
               rows_selected.push(rowId);

               // Otherwise, if checkbox is not checked and row ID is in list of selected row IDs
            } else if (!this.checked && index !== -1) {
               rows_selected.splice(index, 1);
            }

            if (this.checked) {
               $row.addClass('selected');
            } else {
               $row.removeClass('selected');
            }

            // Update state of "Select all" control
            updateDataTableSelectAllCtrl(table);

            // Prevent click event from propagating to parent
            e.stopPropagation();
         });

         // Handle click on table cells with checkboxes
         $('#datatable').on('click', 'tbody td, thead th:first-child', function(e) {
            $(this).parent().find('input[type="checkbox"]').trigger('click');
         });

         // Handle click on "Select all" control
         $('thead input[name="select_all"]', table.table().container()).on('click', function(e) {
            if (this.checked) {
               $('#datatable tbody input[type="checkbox"]:not(:checked)').trigger('click');
            } else {
               $('#datatable tbody input[type="checkbox"]:checked').trigger('click');
            }

            // Prevent click event from propagating to parent
            e.stopPropagation();
         });

         // Handle table draw event
         table.on('draw', function() {
            // Update state of "Select all" control
            updateDataTableSelectAllCtrl(table);
         });

         // Handle form submission event
         $('#frm-datatable').on('submit', function(e) {
            var form = this;

            // Iterate over all selected checkboxes
            $.each(rows_selected, function(index, rowId) {
               // Create a hidden element
               $(form).append(
                  $('<input>')
                  .attr('type', 'hidden')
                  .attr('name', 'id[]')
                  .val(rowId)
               );
            });

         });

         // Remove row
         $(document).on('click', 'button:button', function() {
            var tr = $(this).closest('tr'),
               del_id = $(this).attr('id');
            //
            $.ajax({
               url: "remove-data.php?id=" + del_id,
               cache: false,
               success: function(result) {
                  tr.fadeOut(1000, function() {
                     $(this).remove();
                  });
               }
            });
         });

      });
   </script>
</body>

</html>