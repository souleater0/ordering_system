<?php
$categorys = getCategory($pdo);
?>
<div class="container-fluid">
    <div class="text-center mt-5 fs-3">
        <h1>Welcome to Eskina</h1>
    </div>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="row p-2">
                    <div class="col-2 overflow-auto" style="max-height: 535px;" data-simplebar="">
                        <ul class="list-group" id="list-menu">
                            <li class="list-group-item" aria-current="true" role="button" data-id="">All</li>
                            <?php foreach ($categorys as $category) : ?>
                                <li class=" list-group-item" aria-current="true" role="button" data-id="<?php echo $category['category_id'] ?>"><?php echo $category['category_name'] ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="col-10 bg-light overflow-auto" style="max-height: 530px;" data-simplebar="">
                        <div class="row gy-4 p-5" id="menuItems">
                            <!-- <div class="col-lg-3">
                                <div class="card" style="width: 13rem;">
                                    <div class="card-body text-center">
                                        <img src="https://via.placeholder.com/100" class="img-fluid" alt="Bootstrap Image" style="width: 120px;">

                                        <h5 class="text-center fs-8">Chicken Inasal</h5>
                                        <button class="btn btn-sm rounded-4 btn-primary text-uppercase">Add to List</button>
                                    </div>
                                </div>
                            </div> -->
                            <!-- Repeat the above structure for each set of three cards -->
                        </div>
                    </div>
                    <div class="col-lg-12 pt-2">
                        <button class="btn btn-danger float-end" id="viewListButton">View List | 0</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cartModalLabel">Your Cart</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="cartItemsList">
                <!-- Cart items will be dynamically added here -->
            </div>
            <div class="modal-footer" id="cartFooter">
                <!-- Cart totals will be dynamically added here -->
            </div>
            <div class="modal-footer">
                <button type="button" id="orderNow" class="btn btn-danger">Order Now</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#orderNow').click(function () {  
            console.log(cartItems);
        });
        function updateViewListButton() {
            var itemCount = cartItems.length;
            $('#viewListButton').text(`View List | ${itemCount}`);
        }

        function openCartModal() {
            // Clear previous items and totals from the modal
            $('#cartItemsList').empty();
            $('#cartFooter').empty();

            // Initialize an object to store quantities of each item
            var itemQuantities = {};

            // Add each item in the cart to the modal
            var totalPrice = 0;
            cartItems.forEach(function(item) {
                // Increment quantity if the item already exists in the cart
                // if (item.id in itemQuantities) {
                //     itemQuantities[item.id]++;
                // } else {
                //     itemQuantities[item.id] = 1;
                // }
                totalPrice += parseFloat(item.price * item.quantity);

                // Display each item with its quantity
                var itemHtml = `
            <div class="row mb-2">
                <div class="col">${item.name}</div>
                <div class="col">${item.price}</div>
                <div class="col">${item.quantity}</div>
                <div class="col">
                    <button type="button" class="btn btn-success btn-sm increment-item" data-id="${item.id}">+</button>
                    <button type="button" class="btn btn-danger btn-sm decrement-item" data-id="${item.id}">-</button>
                    <button type="button" class="btn btn-danger btn-sm remove-item" data-id="${item.id}">Remove</button>
                </div>
            </div>`;
                $('#cartItemsList').append(itemHtml);
            });

            // Add totals to the footer
            var footerHtml = `
        <div class="row">
            <div class="col text-end">Total Price: ${totalPrice.toFixed(2)}</div>
        </div>`;
            $('#cartFooter').append(footerHtml);

            // Show the modal
            $('#cartModal').modal('show');
        }

        function addToCart(item) {
            // Check if the item already exists in the cart
            var existingItemIndex = cartItems.findIndex(cartItem => cartItem.id === item.id);
            if (existingItemIndex !== -1) {
                // If the item exists, increment its quantity
                cartItems[existingItemIndex].quantity++;
            } else {
                // If the item doesn't exist, add it to the cart
                item.quantity = 1; // Add a quantity field to the item
                cartItems.push(item);
            }
            // Update the modal to reflect the changes
            //openCartModal();
            // Update the text of the "View List" button
            updateViewListButton();
        }

        // Event handler for "Add to List" buttons
        $('#menuItems').on('click', '.addtoList', function() {
            var menuID = $(this).attr('menu-id');
            $.ajax({
                url: "process/user_action.php",
                method: "POST",
                data: {
                    action: "getMenubyMenuID",
                    menu_id: menuID
                },
                dataType: "json",
                success: function(response) {
                    if (response.success == true) {
                        response.menubyID.forEach(function(item) {
                            var menuItem = {
                            id: item.id,
                            name: item.menu_name,
                            price: item.menu_price,
                            }
                            addToCart(menuItem);
                        });
                    }
                }
            });
        });
        loadMenuItems(null);

        function loadMenuItems(categoryID) {
            $.ajax({
                url: "process/user_action.php",
                method: "POST",
                data: {
                    action: "getMenubyID",
                    category_id: categoryID
                },
                dataType: "json",
                success: function(response) {
                    if (response.success == true) {
                        
                        $('#menuItems').empty();
                        response.menuList.forEach(function(item) {
                                var menuItemHtml = `
                                <div class="col-lg-3">
                                    <div class="card" style="width: 13rem; background: radial-gradient(60% 60% at 50.25% 40%, #FF7979 0%, #F20000 100%);">
                                        <div class="card-body text-center">
                                            <img src="https://via.placeholder.com/100" class="img-fluid" alt="Bootstrap Image" style="width: 120px;">
                                            <h5 class="text-center fs-8 text-white mt-2 mb-2">${item.menu_name}</h5>
                                            <button class="btn btn-sm rounded-4 btn-light text-uppercase addtoList" menu-id="${item.id}">Add to List</button>
                                        </div>
                                    </div>
                                </div>
                            `;
                                $('#menuItems').append(menuItemHtml);
                            });
                        // LoadTable();
                        // $('#categoryModal').modal('hide');
                        // toastr.success(response.message);
                    }else{
                        $('#menuItems').empty();
                        
                        $('#menuItems').html('<p>No menu items available.</p>')
                    }
                }
            });
        }
        var $listMenu = $("#list-menu");
        $listMenu.find(".list-group-item:first").addClass("active");
        $('.list-group-item:first').click();
        $('.list-group-item').click(function() {
            $('.list-group-item').not(this).removeClass("active");
            $(this).addClass("active");

            var categoryID = $(this).attr("data-id");
            loadMenuItems(categoryID);
        });

        var cartItems = [];

        $('#viewListButton').click(function() {
            openCartModal();
        });
        $('#cartItemsList').on('click', '.increment-item', function() {
            var itemId = $(this).data('id');
            var itemIndex = cartItems.findIndex(item => item.id === itemId);

            if (itemIndex !== -1) {
                cartItems[itemIndex].quantity++;
                // updateModalContent(); // Update the modal content after incrementing
            }
            openCartModal();
        });

        // // Event handler for decrementing item quantity
        $('#cartItemsList').on('click', '.decrement-item', function() {
            var itemId = $(this).data('id');
            var itemIndex = cartItems.findIndex(item => item.id === itemId);
            if (itemIndex !== -1 && cartItems[itemIndex].quantity > 1) {
                cartItems[itemIndex].quantity--;
                // updateModalContent(); // Update the modal content after decrementing
                openCartModal();
            }
        });

        $('#cartItemsList').on('click', '.remove-item', function() {
            var index = $(this).data('index');
            // Remove the item from the cartItems array
            cartItems.splice(index, 1);
            // Update the modal to reflect the changes
            openCartModal();
            updateViewListButton();
        });
    });
</script>