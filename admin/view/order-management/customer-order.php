<?php
$foodlists = getFoodList($pdo);
?>
<div class="body-wrapper-inner">
    <div class="container-fluid">
        <div class="card shadow-sm">
            <div class="card-header bg-transparent border-bottom">
                <div class="row">
                    <div class="col">
                        <h5 class="mt-1 mb-0">Customer Orders</h5>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="orderTable" class="table table-hover table-cs-color"></table>
            </div>
        </div>
    </div>
</div>
<!-- VIEW ORDER -->
<div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Order Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="orderContent">
                <h5>Table No: <span id="modalTableNo"></span></h5>
                <h5>Customer Name: <span id="modalCustomerName"></span></h5>
                <table id="modalOrderTable" class="table table-hover">
                    <thead>
                        <tr>
                            <th class="text-dark">Menu Name</th>
                            <th class="text-dark">Variation</th>
                            <th class="text-dark">Quantity</th>
                            <th class="text-dark">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Order items will be populated here -->
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-end text-dark">Total:</th>
                            <th id="modalTotalPrice" class="text-dark"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="printButton">Print</button>
            </div>
        </div>
    </div>
</div>
<!-- END MODAL -->

<!-- CUSTOMER ORDER MODAL EDIT -->
<div class="modal fade" id="editOrder" tabindex="-1" aria-labelledby="editOrderLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="foodlistForm">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editOrderLabel">Edit Customer Order</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body border">
                    <div class="row">
                        <div class="col-8 text-dark">Menu Type</div>
                        <div class="col-2 text-dark">QTY</div>
                        <div class="col-2 text-dark">ACTION</div>
                    </div>
                    <div id="foodList" class="col-lg-12"></div>
                </div>
                <div class="modal-body border-bottom">
                    <div class="row">
                        <div class="col text-dark">Total Order: <span id="totalOrder"></span></div>
                        <div class="col text-dark">Total Price: <span id="totalPrice"></span></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="addFood" class="btn btn-secondary">Add Food</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END -->

<script>
$(document).ready(function() {
    let foodCount = 0; // Track food dynamically added

    $('#addFood').click(function() {
        addFoodList();
        updateTotalPrice();
    });

    $('#foodlistForm').on('click', '.btn-remove-variation', function() {
        $(this).closest('.foodItem').remove();
        updateTotalPrice(); // Update total price when an item is removed
    });

    var table = $('#orderTable').DataTable({
        responsive: true,
        select: true,
        autoWidth: false,
        ajax: {
            url: 'process/table.php?table_type=customer-order',
            dataSrc: 'data'
        },
        columns: [{
                data: 'order_no',
                title: 'ORDER #',
                className: 'text-dark text-start'
            },
            {
                data: 'table_no',
                title: 'Table #',
                className: 'text-dark text-start'
            },
            {
                data: 'customer_name',
                title: 'Customer Name',
                className: 'text-dark text-start'
            },
            {
                data: 'created_at',
                title: 'Date Created',
                className: 'text-dark text-start',
                render: function(data, type, row) {
                    const date = new Date(data);
                    const options = {
                        year: 'numeric',
                        month: 'long',
                        day: '2-digit',
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit',
                        hour12: true
                    };
                    return new Intl.DateTimeFormat('en-PH', options).format(date);
                }
            },
            {
                "data": null,
                "title": "Action",
                "render": function(data, type, row) {
                    return '<button class="btn btn-info btn-sm btn-show">View</button>&nbsp;<button class="btn btn-primary btn-sm btn-edit">Edit</button>&nbsp;<button class="btn btn-warning btn-sm text-white btn-process">Process</button>&nbsp;<button class="btn btn-danger btn-sm btn-cancel">Cancel</button>';
                }
            }
        ]
    });

    function addFoodList(menuid = '', qty = 1) {
        var foodCount = $('.foodItem').length; // Get current count of foods
        $('#foodList').append(`
        <div class="foodItem row mt-2">
            <div class="col-8">
                <select class="selectpicker form-control food-select" id="food_name_${foodCount}" name="foods[${foodCount}][name]" data-live-search="true">
                <?php foreach ($foodlists as $foodlist) : ?>
                    <option value="<?php echo $foodlist['menu_id']; ?>" data-price="<?php echo $foodlist['price']; ?>" ${menuid == '<?php echo $foodlist['menu_id']; ?>' ? 'selected' : ''}>
                        <?php echo $foodlist['menu_name'].' ['.$foodlist['variation_name'].'] [₱'.$foodlist['price'].']'; ?>
                    </option>
                <?php endforeach; ?>
                </select>
            </div>
            <div class="col-2">
                <input type="number" class="form-control food-qty" id="variation_qty_${foodCount}" name="foods[${foodCount}][qty]" min="1" step="1" value="${qty}">
            </div>
            <div class="col-2 d-flex align-items-end">
                <button type="button" class="btn btn-danger btn-sm btn-remove-variation"><iconify-icon icon="mdi:trash" width="20" height="20"></iconify-icon></button>
            </div>
        </div>
        `);

        // Initialize selectpicker on the newly added select element
        $('#food_name_' + foodCount).selectpicker('refresh'); // Refresh to apply selectpicker styles

        // Add event listeners to newly added elements
        $('#food_name_' + foodCount).change(function() {
            updateTotalPrice();
        });

        $('#variation_qty_' + foodCount).change(function() {
            updateTotalPrice();
        });
    }

    function updateTotalPrice() {
        var totalPrice = 0;
        $('.foodItem').each(function() {
            var foodSelect = $(this).find('.food-select');
            var qtyInput = $(this).find('.food-qty');
            var price = parseFloat(foodSelect.find('option:selected').data('price'));
            var qty = parseInt(qtyInput.val());
            totalPrice += price * qty;
        });
        $("#totalPrice").text(totalPrice.toFixed(2));
        $("#totalOrder").text($('.foodItem').length);
    }

    $('#orderTable').on('click', 'button.btn-show', function() {
        var data = table.row($(this).parents('tr')).data();
        var order_no = data.order_no;

        $.ajax({
            url: 'process/admin_action.php',
            method: 'POST',
            data: {
                order_no: order_no,
                action: 'retrievedOrderListbyID'
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#modalTableNo').text(data.table_no);
                    $('#modalCustomerName').text(data.customer_name);

                    var orderItemsHtml = '';
                    var totalPrice = 0;
                    response.data.forEach(function(item) {
                        orderItemsHtml += '<tr>' +
                            '<td class="text-dark">' + item.menu_name + '</td>' +
                            '<td class="text-dark">' + item.variation_name + '</td>' +
                            '<td class="text-dark">' + item.qty + '</td>' +
                            '<td class="text-dark">' + item.price + '</td>' +
                            '</tr>';
                        totalPrice += parseFloat(item.price * item.qty);
                    });
                    $('#modalOrderTable tbody').html(orderItemsHtml);
                    $('#modalTotalPrice').text(totalPrice.toFixed(2));
                    $('#orderModal').modal('show');
                } else {
                    alert('Failed to retrieve order details.');
                }
            },
            error: function() {
                alert('Failed to retrieve order details.');
            }
        });
    });

    $('#printButton').click(function() {
        var modalContent = $('#orderContent').clone(); // Clone modal content
        var printWindow = window.open('', '', 'height=400,width=800');
        printWindow.document.write('<html><head><title>Print</title>');
        printWindow.document.write('</head><body>');
        printWindow.document.write(modalContent.html()); // Write modal content to new window
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print(); // Print the new window
    });

    $('#orderTable').on('click', 'button.btn-process', function() {
        var data = table.row($(this).parents('tr')).data();
        var order_no = data.order_no;

        $.ajax({
            url: "process/admin_action.php",
            method: "POST",
            data: {
                order_no: order_no,
                action: "order_to_process"
            },
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    LoadTable();
                    toastr.success(response.message);
                } else {
                    toastr.error(response.message);
                }
            }
        });
    });

    $('#orderTable').on('click', 'button.btn-cancel', function() {
        var data = table.row($(this).parents('tr')).data();
        var order_no = data.order_no;

        $.ajax({
            url: "process/admin_action.php",
            method: "POST",
            data: {
                order_no: order_no,
                action: "order_to_cancel"
            },
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    LoadTable();
                    toastr.success(response.message);
                } else {
                    toastr.error(response.message);
                }
            }
        });
    });

    $('#orderTable').on('click', 'button.btn-edit', function() {
        var data = table.row($(this).parents('tr')).data();
        var order_no = data.order_no;

        $('#editOrder').modal('show');
        loadFoodListbyOrderNo(order_no);
    });

    function loadFoodListbyOrderNo(order_no) {
        $.ajax({
            url: 'process/admin_action.php',
            method: 'POST',
            data: {
                action: 'getFoodOrderbyID',
                order_no: order_no
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#foodList').empty(); // Clear the existing list
                    var totalPrice = 0;
                    response.orderList.forEach(function(orList) {
                        addFoodList(orList.menu_id, orList.qty);
                        var subtotal = parseFloat(orList.qty) * parseFloat(orList.price);
                        totalPrice += subtotal;
                    });
                    $("#totalOrder").text(response.orderList.length);
                    $("#totalPrice").text(totalPrice.toFixed(2));
                } else {
                    toastr.error('Failed to load menu lists.');
                }
            },
            error: function(xhr, status, error) {
                toastr.error('Error occurred while loading menu variations.');
                console.error(xhr.responseText);
            }
        });
    }

    function LoadTable() {
        $.ajax({
            url: 'process/table.php?table_type=customer-order',
            dataType: 'json',
            success: function(data) {
                table.clear().rows.add(data.data).draw(false); // Update data without redrawing
                setTimeout(function() {
                    table.ajax.reload(null, false); // Reload the DataTable without resetting current page
                }, 1000); // Adjust delay as needed
            },
            error: function() {
                alert('Failed to retrieve brands.');
            }
        });
    }
});
</script>
