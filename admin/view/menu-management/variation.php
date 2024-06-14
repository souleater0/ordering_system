<div class="body-wrapper-inner">
  <div class="container-fluid">
    <div class="card shadow-sm">
      <div class="card-header bg-transparent border-bottom">
        <div class="row">
          <div class="col">
            <h5 class="mt-1 mb-0">Manage Variation/h5>
          </div>
          <div class="col">
            <button class="btn btn-primary btn-sm float-end" id="addVariationBTN" data-bs-toggle="modal" data-bs-target="#variationModal"><i class="fa-solid fa-plus"></i>&nbsp;Add
              Variation</button>
          </div>
        </div>
      </div>
      <div class="card-body">
        <table id="variationTable" class="table table-hover table-cs-color">
        </table>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="variationModal" tabindex="-1" aria-labelledby="variationModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    <form id="variationForm">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="variationModalLabel">Variation Details</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body border">
        <div class="row gy-2">
          <div class="col-lg-12">
          <label for="variation_name" class="form-label">Variation Name</label>
          <input type="text" class="form-control" id="variation_name" name="variation_name" placeholder="Ex. Large">
          </div>          
        </div>
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
        <button type="button" class="btn btn-primary" id="updateVariation" update-id="">UPDATE</button>
        <button type="button" class="btn btn-primary" id="addVariation">ADD</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- END -->
<script>
  $(document).ready( function () {
    // let table = new DataTable('#myTable');
  var table = $('#variationTable').DataTable({
        responsive: true,
        select: true,
        autoWidth: false,
        ajax:{
          url: 'process/table.php?table_type=variation',
          dataSrc: 'data'
        },
        columns:[
          {data: 'id', visible: false},
          {data: 'variation_name', title: 'Variation Name', className: 'text-dark'},
          {"data": null, title: 'Action', className: 'text-dark' , "defaultContent": "<button class='btn btn-primary btn-sm btn-edit'><i class='fa-regular fa-pen-to-square'></i></button>&nbsp;<button class='btn btn-danger btn-sm btn-delete'><i class='fa-solid fa-trash'></i></button>"}
        ]
    });
    function LoadTable(){
        $.ajax({
            url: 'process/table.php?table_type=variation',
            dataType: 'json',
            success: function(data) {
              table.clear().rows.add(data.data).draw(false); // Update data without redrawing
            
              // Reload the DataTable after a delay (e.g., 1 second) to reflect any changes in the table structure or formatting
              setTimeout(function() {
                  table.ajax.reload(null, false); // Reload the DataTable without resetting current page
              }, 1000); // Adjust delay as needed
            },
            error: function () {
                alert('Failed to retrieve brands.');
            }
        });
    }
    $('#variationForm').on('submit', function(event){
      event.preventDefault();
    });
    $('#addVariationBTN').click(function(){
      $('#variation_name').val('');
      $('#addVariation').show();
      $('#updateVariation').hide();
    });
    $('#addVariation').click(function(){
        var formData = $('#variationForm').serialize();
        //alert(formData);
        $.ajax({
            url: "process/admin_action.php",
            method: "POST",
            data: formData+"&action=addVariation",
            dataType: "json",
            success: function(response) {
                if(response.success==true){
                    LoadTable();
                    $('#variationModal').modal('hide');
                    toastr.success(response.message);
                }else{
                    toastr.error(response.message);
                }
            }
        });
    });
    $('#updateVariation').click(function(){
      var formData = $('#variationForm').serialize();
      var update_id = $(this).attr("update-id");
      $.ajax({
            url: "process/admin_action.php",
            method: "POST",
            data: formData+"&action=updateVariation&update_id="+update_id,
            dataType: "json",
            success: function(response) {
                if(response.success==true){
                    LoadTable();
                    $('#variationModal').modal('hide');
                    toastr.success(response.message);
                }else{
                    toastr.error(response.message);
                }
            }
        });
    });
    $('#variationTable').on('click', 'button.btn-edit', function () {
      var data = table.row($(this).parents('tr')).data();
      // // Populate modal with data
      $('#variation_name').val(data.variation_name);
      $('#addVariation').hide();
      $('#updateVariation').show();
      $('#variationModal').modal('show');
      // var update_id = $(this).attr("update-id");
      $("#updateVariation").attr("update-id", data.id);
    });
    $('#variationTable').on('click', 'button.btn-delete', function() {
            var data = table.row($(this).parents('tr')).data();
            $.ajax({
                url: "process/admin_action.php",
                method: "POST",
                data: {
                    action : "deleteVariation",
                    delete_id: data.id
                },
                dataType: "json",
                success: function(response) {
                    if (response.success == true) {
                        LoadTable();
                        $('#variationModal').modal('hide');
                        toastr.success(response.message);
                    } else {
                        toastr.error(response.message);
                    }
                }
            });
            // alert(data.id);
        });
  });
</script>