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