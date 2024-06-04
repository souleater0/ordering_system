<div class="body-wrapper-inner">
    <div class="container-fluid">
        <div class="card shadow-sm">
            <div class="card-header bg-transparent border-bottom">
                <div class="row">
                    <div class="col">
                        <h5 class="mt-1 mb-0">Manage Customer</h5>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="categoryTable" class="table table-hover table-cs-color">
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="brandForm">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="categoryModalLabel">Customer Details</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body border">
                    <div class="row gy-2">
                        <div class="col-lg-12">
                            <label for="brand_name" class="form-label">Customer Name</label>
                            <input type="text" class="form-control" id="brand_name" name="brand_name" placeholder="Ex. Juan Dela Cruz">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                    <button type="button" class="btn btn-primary" id="updateCategory" update-id="">UPDATE</button>
                    <button type="button" class="btn btn-primary" id="addCategory">ADD</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END -->
<script>
    $(document).ready(function() {
        // let table = new DataTable('#myTable');
        var table = $('#categoryTable').DataTable({
            responsive: true,
            select: true,
            autoWidth: false,
            ajax: {
                url: 'process/table.php?table_type=customer-detail',
                dataSrc: 'data'
            },
            columns: [{
                    data: 'customer_id',
                    visible: false
                },
                {
                    data: 'customer_name',
                    title: 'Customer Name',
                    className: 'text-dark text-start'
                },
                {
                    data: 'customer_contact',
                    title: 'Customer Contact',
                    className: 'text-dark text-start'
                },
                {
                    data: 'customer_email',
                    title: 'Customer Email',
                    className: 'text-dark text-start'
                },
                {
                    "data": null,
                    "title": "Action",
                    "className": "text-dark text-center",
                    "render": function(data, type, row) {
                        return '<a class="btn btn-info btn-sm" href="index.php?route=view-product&product=' + row.product_id + '"><i class="fa-solid fa-eye"></i></a>';
                    }
                }
            ]
        });

        function LoadTable() {
            $.ajax({
                url: 'admin/process/table.php?table_type=customer-detail',
                dataType: 'json',
                success: function(data) {
                    table.clear().rows.add(data.data).draw(false); // Update data without redrawing

                    // Reload the DataTable after a delay (e.g., 1 second) to reflect any changes in the table structure or formatting
                    setTimeout(function() {
                        table.ajax.reload(null, false); // Reload the DataTable without resetting current page
                    }, 1000); // Adjust delay as needed
                },
                error: function() {
                    alert('Failed to retrieve brands.');
                }
            });
        }
        $('#brandForm').on('submit', function(event) {
            event.preventDefault();
        });
        $('#addCategoryBTN').click(function() {
            $('#brand_name').val('');
            $('#addCategory').show();
            $('#updateCategory').hide();
        });
        $('#addCategory').click(function() {
            var formData = $('#brandForm').serialize();
            //alert(formData);
            $.ajax({
                url: "admin/process/admin_action.php",
                method: "POST",
                data: formData + "&action=addCategory",
                dataType: "json",
                success: function(response) {
                    if (response.success == true) {
                        LoadTable();
                        $('#categoryModal').modal('hide');
                        toastr.success(response.message);
                    } else {
                        toastr.error(response.message);
                    }
                }
            });
        });
        $('#updateCategory').click(function() {
            var formData = $('#brandForm').serialize();
            var update_id = $(this).attr("update-id");
            $.ajax({
                url: "admin/process/admin_action.php",
                method: "POST",
                data: formData + "&action=updateCategory&update_id=" + update_id,
                dataType: "json",
                success: function(response) {
                    if (response.success == true) {
                        LoadTable();
                        $('#categoryModal').modal('hide');
                        toastr.success(response.message);
                    } else {
                        toastr.error(response.message);
                    }
                }
            });
        });
        $('#categoryTable').on('click', 'button.btn-edit', function() {
            var data = table.row($(this).parents('tr')).data();
            // // Populate modal with data
            $('#brand_name').val(data.brand_name);
            $('#addCategory').hide();
            $('#updateCategory').show();
            $('#categoryModal').modal('show');
            // var update_id = $(this).attr("update-id");
            $("#updateCategory").attr("update-id", data.brand_id);
        });
    });
</script>