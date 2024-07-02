<?php
$categorys = getCategory($pdo);
$variations = getVariations($pdo);
?>
<div class="body-wrapper-inner">
    <div class="container-fluid">
        <div class="card shadow-sm">
            <div class="card-header bg-transparent border-bottom">
                <div class="row">
                    <div class="col">
                        <h5 class="mt-1 mb-0">Manage Menu</h5>
                    </div>
                    <div class="col">
                        <button class="btn btn-primary btn-sm float-end" id="addMenuBTN" data-bs-toggle="modal" data-bs-target="#foodModal"><i class="fa-solid fa-plus"></i>&nbsp;Add
                            Menu</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="menuTable" class="table table-hover table-cs-color">
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="foodModal" tabindex="-1" aria-labelledby="foodModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="foodForm" enctype="multipart/form-data">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="foodModalLabel">Menu Details</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body border">
                    <div class="row gy-2">
                        <div class="col-lg-12">
                            <label for="food_name" class="form-label">Food Name</label>
                            <input type="text" class="form-control" id="food_name" name="food_name" placeholder="Ex. Chicken Inasal">
                        </div>
                        <div class="col-lg-12">
                        <label for="food_description" class="form-label">Food Description</label>
                        <textarea class="form-control" id="food_description" name="food_description" rows="3"></textarea>
                        </div>
                        <div class="col-lg-12">
                            <label for="category_id" class="form-label">Category</label>
                            <select class="selectpicker form-control" id="category_id" name="category_id" data-live-search="true">
                                <?php foreach ($categorys as $category) : ?>
                                    <option value="<?php echo $category['category_id']; ?>"><?php echo $category['category_name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-lg-12">
                            <label for="foodImg" class="form-label">Food Image</label>
                            <input class="form-control" type="file" id="foodImg" name="foodImg" accept=".png,.jpg">
                        </div>
                        <div id="variations" class="col-lg-12">
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="foodOption" name="foodOption" checked>
                            <label class="form-check-label" for="foodOption">Enable Food</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="addVariation" class="btn btn-secondary">Add Variation</button>
                    <button type="button" class="btn btn-primary" id="updateMenu" update-id="">UPDATE</button>
                    <button type="button" class="btn btn-primary" id="addMenu">ADD MENU</button>
                </div>
            </form>


        </div>
    </div>
</div>
<!-- END -->
<script>
    $(document).ready(function() {
        let variationCount = 0; // Track variations dynamically added

        // Function to add a new variation input fields
        $('#addVariation').click(function() {
            var variationCount = $('.variation').length; // Get current count of variations
            $('#variations').append(`
                <div class="variation">
                    <label for="variation_name_${variationCount}" class="form-label">Variation Type</label>
                    <select class="selectpicker form-control" id="variation_name_${variationCount}" name="variations[${variationCount}][name]" data-live-search="true">
                    <?php foreach ($variations as $variation) : ?>
                        <option value="<?php echo $variation['variation_name']; ?>"><?php echo $variation['variation_name']; ?></option>
                    <?php endforeach; ?>
                    </select>
                    <label for="variation_price_${variationCount}" class="form-label">Price</label>
                    <input type="number" class="form-control" id="variation_price_${variationCount}" name="variations[${variationCount}][price]" min="1" step="0.01">
                    <button type="button" class="btn btn-danger btn-sm btn-remove-variation">Remove</button>
                </div>
            `);

            // Initialize selectpicker on the newly added select element
            $('#variation_name_' + variationCount).selectpicker('refresh'); // Refresh to apply selectpicker styles

            variationCount++;
        });

        $('#foodForm').on('click', '.btn-remove-variation', function() {
            $(this).closest('.variation').remove();
        });
        $('#food_price').on('input', function() {
            $(this).val($(this).val().replace(/\D/g, ''));
        });
        // let table = new DataTable('#myTable');
        var table = $('#menuTable').DataTable({
            responsive: true,
            select: true,
            autoWidth: false,
            order: [
                [3, "asc"]
            ],
            ajax: {
                url: 'process/table.php?table_type=food-menu',
                dataSrc: 'data'
            },
            columns: [{
                    data: 'id',
                    visible: false
                },
                {
                    data: 'menu_name',
                    title: 'Food Name',
                    className: 'text-dark'
                },
                {
                    data: 'menu_description',
                    visible: false
                },
                {
                    data: 'all_prices',
                    title: 'Price',
                    className: 'text-dark text-center'
                },
                {
                    data: 'category_id',
                    visible: false
                },
                {
                    data: 'category_name',
                    title: 'Category',
                    className: 'text-dark text-start'
                },
                {
                    "data": "isEnabled",
                    "render": function(data, type, row, meta) {
                        var statusText;
                        var statusColor;
                        switch (data) {
                            case 0:
                                statusText = "Disabled";
                                statusColor = "#EC7063"; // Orange
                                break;
                            case 1:
                                statusText = "Enabled";
                                statusColor = "#58D68D"; // Green
                                break;
                            default:
                                statusText = "Enabled";
                                statusColor = "#58D68D"; // Red
                                break;
                        }
                        return '<span class="badge text-white" style="background-color: ' + statusColor + ';">' + statusText + '</span>';
                    },
                    "title": "Status",
                },
                {
                    data: 'created_at',
                    title: 'Dated Created',
                    className: 'text-dark text-start'
                },
                // {
                //     data: 'updated_at',
                //     title: 'Date Updated',
                //     className: 'text-dark text-start'
                // },
                {
                    "data": null,
                    title: 'Action',
                    "defaultContent": "<button class='btn btn-primary btn-sm btn-edit'><i class='fa-regular fa-pen-to-square'></i></button>&nbsp;<button class='btn btn-danger btn-sm btn-delete'><i class='fa-solid fa-trash'></i></button>"
                }
            ]
        });

        function LoadTable() {
            $.ajax({
                url: 'process/table.php?table_type=food-menu',
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
        $('#foodForm').on('submit', function(event) {
            event.preventDefault();
        });
        $('#addMenuBTN').click(function() {
            $('#food_name').val("");
            $('#food_price').val("");
            $('#category_id').val(1);
            $('#category_id').selectpicker('refresh');
            $('#variations').empty();
            $('#addMenu').show();
            $('#updateMenu').hide();
        });

        //Handler Button Action

        $('#addMenu').click(function() {
            saveMenu('add');
        });

        // Handler for Update Menu button click
        $('#updateMenu').click(function() {
            var updateId = $(this).attr('update-id');
            saveMenu('update', updateId);
        });

        function saveMenu(action, updateId = '') {
            var formData = new FormData($('#foodForm')[0]);
            formData.forEach((value, key) => {
                console.log(key + ': ' + value);
            });
            if (action === 'add') {
                formData.append('action', 'addFood');
            } else if (action === 'update') {
                formData.append('action', 'updateFood');
                formData.append('update-id', updateId);
            }

            $.ajax({
                url: "process/admin_action.php",
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        $('#foodModal').modal('hide');
                        toastr.success(response.message);
                        LoadTable(); // Function to reload the table after adding/updating
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    toastr.error('Error occurred while processing the request.');
                    console.error(xhr.responseText);
                }
            });
        }

        $('#menuTable').on('click', 'button.btn-edit', function() {
            var data = table.row($(this).parents('tr')).data();
            // // Populate modal with data
            $('#food_name').val(data.menu_name);
            $('#food_description').val(data.menu_description);
            $('#food_price').val(data.menu_price);
            $('#category_id').val(data.category_id);
            $('#category_id').selectpicker('refresh');
            $('#variations').empty();
            $('#addMenu').hide();
            $('#updateMenu').show();
            $('#foodModal').modal('show');
            // var update_id = $(this).attr("update-id");
            loadMenuVariations(data.id);
            $("#updateMenu").attr("update-id", data.id);
        });
        $('#menuTable').on('click', 'button.btn-delete', function() {
            var data = table.row($(this).parents('tr')).data();
            $.ajax({
                url: "process/admin_action.php",
                method: "POST",
                data: {
                    action: "deleteFood",
                    delete_id: data.id
                },
                dataType: "json",
                success: function(response) {
                    if (response.success == true) {
                        LoadTable();
                        $('#foodModal').modal('hide');
                        toastr.success(response.message);
                    } else {
                        toastr.error(response.message);
                    }
                }
            });
            // alert(data.id);
        });

        function addVariationField(name = '', price = '') {
            var variationCount = $('.variation').length;
            $('#variations').append(`
            <div class="variation">
                <label for="variation_name_${variationCount}" class="form-label">Variation Type</label>
                <select class="selectpicker form-control" id="variation_name_${variationCount}" name="variations[${variationCount}][name]" data-live-search="true">
                <?php foreach ($variations as $variation) : ?>
                    <option value="<?php echo $variation['variation_name']; ?>" ${name === '<?php echo $variation['variation_name']; ?>' ? 'selected' : name}><?php echo $variation['variation_name']; ?></option>
                <?php endforeach; ?>
                </select>
                <label for="variation_price_${variationCount}" class="form-label">Price</label>
                <input type="number" class="form-control" id="variation_price_${variationCount}" name="variations[${variationCount}][price]" min="1" step="0.01" value="${price}">
                <button type="button" class="btn btn-danger btn-sm btn-remove-variation">Remove</button>
            </div>
        `);
            $('#variation_name_' + variationCount).selectpicker('refresh'); // Refresh to apply selectpicker styles
        }

        function loadMenuVariations(menuId) {
            $.ajax({
                url: 'process/admin_action.php',
                method: 'POST',
                data: {
                    action: 'getMenuVariations',
                    menu_id: menuId
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        var variations = response.variations;
                        variations.forEach(function(variation) {
                            addVariationField(variation.variation_name, variation.price);
                        });
                    } else {
                        toastr.error('Failed to load menu variations.');
                    }
                },
                error: function(xhr, status, error) {
                    toastr.error('Error occurred while loading menu variations.');
                    console.error(xhr.responseText);
                }
            });
        }
    });
</script>