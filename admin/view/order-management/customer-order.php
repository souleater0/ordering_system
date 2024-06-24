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
                <table id="orderTable" class="table table-hover table-cs-color">
                </table>
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
<script>
    $(document).ready(function() {
        // let table = new DataTable('#myTable');
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
                        // Parsing the timestamp
                        const date = new Date(data);

                        // Formatting options
                        const options = {
                            year: 'numeric',
                            month: 'long',
                            day: '2-digit',
                            hour: '2-digit',
                            minute: '2-digit',
                            second: '2-digit',
                            hour12: true
                        };

                        // Formatting the date
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

        function LoadTable() {
            $.ajax({
                url: 'process/table.php?table_type=customer-order',
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
                            totalPrice += parseFloat(item.price);
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
        $('#orderTable').on('click', 'button.btn-edit', function() {
            var data = table.row($(this).parents('tr')).data();
            // // Populate modal with data
            $('#brand_name').val(data.brand_name);
            $('#addCategory').hide();
            $('#updateCategory').show();
            $('#categoryModal').modal('show');
            // var update_id = $(this).attr("update-id");
            $("#updateCategory").attr("update-id", data.brand_id);
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
                    if (response.success == true) {
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
                    if (response.success == true) {
                        LoadTable();
                        toastr.success(response.message);
                    } else {
                        toastr.error(response.message);
                    }
                }
            });
        });

    });
</script>