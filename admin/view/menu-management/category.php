<div class="body-wrapper-inner">
    <div class="container-fluid">
        <div class="card shadow-sm">
            <div class="card-header bg-transparent border-bottom">
                <div class="row">
                    <div class="col">
                        <h5 class="mt-1 mb-0">Manage Category</h5>
                    </div>
                    <div class="col">
                        <button class="btn btn-primary btn-sm float-end" id="addCategoryBTN" data-bs-toggle="modal" data-bs-target="#categoryModal"><i class="fa-solid fa-plus"></i>&nbsp;Add
                            Category</button>
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
            <form id="categoryForm">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="categoryModalLabel">Category Details</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body border">
                    <div class="row gy-2">
                        <div class="col-lg-12">
                            <label for="category_name" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="category_name" name="category_name" placeholder="Ex. Grill">
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
                url: 'process/table.php?table_type=category',
                dataSrc: 'data'
            },
            columns: [{
                    data: 'category_id',
                    visible: false
                },
                {
                    data: 'category_name',
                    title: 'Category Name',
                    className: 'text-dark'
                },
                {
                    "data": null,
                    title: 'Action',
                    "defaultContent": "<button class='btn btn-primary btn-sm btn-edit'><i class='fa-regular fa-pen-to-square'></i></button>&nbsp;<button class='btn btn-danger btn-sm btn-delete'><i class='fa-solid fa-trash'></i></button>"
                }
            ]
        });

        function LoadTable() {
            $.ajax({
                url: 'process/table.php?table_type=category',
                dataType: 'json',
                success: function(data) {
                    table.clear().rows.add(data.data).draw(false); // Update data without redrawing

                    // Reload the DataTable after a delay (e.g., 1 second) to reflect any changes in the table structure or formatting
                    setTimeout(function() {
                        table.ajax.reload(null, false); // Reload the DataTable without resetting current page
                    }, 1000); // Adjust delay as needed
                },
                error: function() {
                    alert('Failed to retrieve category.');
                }
            });
        }
        $('#categoryForm').on('submit', function(event) {
            event.preventDefault();
        });
        $('#addCategoryBTN').click(function() {
            $('#brand_name').val('');
            $('#addCategory').show();
            $('#updateCategory').hide();
        });
        $('#addCategory').click(function() {
            var formData = $('#categoryForm').serialize();
            //alert(formData);
            $.ajax({
                url: "process/admin_action.php",
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
            var formData = $('#categoryForm').serialize();
            var update_id = $(this).attr("update-id");
            $.ajax({
                url: "process/admin_action.php",
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
            $('#category_name').val(data.category_name);
            $('#addCategory').hide();
            $('#updateCategory').show();
            $('#categoryModal').modal('show');
            // var update_id = $(this).attr("update-id");
            $("#updateCategory").attr("update-id", data.category_id);
        });
        $('#categoryTable').on('click', 'button.btn-edit', function() {
            var data = table.row($(this).parents('tr')).data();

            $.ajax({
                url: "process/admin_action.php",
                method: "POST",
                data: {
                    action : "deleteCategory",
                    delete_id: data.id
                },
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
            $.ajax({
                url: "process/admin_action.php",
                method: "POST",
                data: {
                    action : "deleteCategory",
                    delete_id: data.id
                },
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
        $('#categoryTable').on('click', 'button.btn-delete', function() {
            var data = table.row($(this).parents('tr')).data();
            $.ajax({
                url: "process/admin_action.php",
                method: "POST",
                data: {
                    action : "deleteCategory",
                    delete_id: data.category_id
                },
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
            // alert(data.id);
        });
    });
</script>