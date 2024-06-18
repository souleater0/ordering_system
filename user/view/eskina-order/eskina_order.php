<?php
$categorys = getCategory($pdo);
?>
<style>
    .list-group-scrollable {

        padding-bottom: 10px;
        overflow-x: auto;
        white-space: nowrap;
        /* Prevent list items from wrapping */
    }

    .list-group-scrollable ul.list-group {
        display: inline-flex;
        /* Ensure the list items are in a row */
        padding-left: 0;
        /* Remove default padding */
        margin-bottom: 0;
        /* Remove default margin */
    }

    .list-group-item+.list-group-item {
        border-top-left-radius: inherit;
        border-top-right-radius: inherit;
        border-top-width: 1px;
    }

    /* .list-group-scrollable ul.list-group .list-group-item {
        margin-right: 10px; /* Adjust spacing between list items 
    }*/
</style>
<div class="container-fluid">
    <div class="text-center mt-5 fs-3">
        <h1>Welcome to Eskina</h1>
    </div>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="row p-2">
                    <div class="col-12" style="max-width: 100%;">
                        <div class="list-group-scrollable" data-simplebar="">
                            <ul class="list-group d-flex flex-row" id="list-menu">
                                <li class="list-group-item" aria-current="true" role="button" data-id="">All</li>
                                <?php foreach ($categorys as $category) : ?>
                                    <li class="list-group-item" aria-current="true" role="button" data-id="<?php echo $category['category_id'] ?>"><?php echo $category['category_name'] ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    <div class="col-12 bg-light overflow-auto" style="max-height: 480px;" data-simplebar="">
                        <div class="row gy-4 p-0" id="menuItems">
                            <!-- Cards content here -->
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
<!-- Modal Item -->
<div class="modal fade" id="itemModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <!-- Dynamic content will be inserted here -->
        </div>
    </div>
</div>

<!-- Modal Cart -->
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
        var cartItems = [];
        $('#orderNow').click(function() {
            console.log(cartItems);
        });

        function updateViewListButton() {
            var itemCount = cartItems.length;
            $('#viewListButton').text(`View List | ${itemCount}`);
        }
        $('#menuItems').on('click', '.card', function() {
            var menuID = $(this).attr('menu-id');
            console.log('Menu ID:', menuID); // Log menu ID to confirm it's correct

            $.ajax({
                url: "process/user_action.php",
                method: "POST",
                data: {
                    action: "getFoodDetailsbyID",
                    menu_id: menuID
                },
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        var menuItem = response.menubyID[0];

                        // console.log(menuItem.menu_name);
                        // Create the modal content dynamically
                        var modalContent = `
                        <div class="modal-header">
                            
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <img src="../assets/images/menu/${menuItem.img_path}" class="img-fluid" alt="Image of ${menuItem.menu_name}" style="width: 120px;">
                            <h5 class="fs-2 fw-bold">${menuItem.menu_name}</h5>
                        </div>
                        <div class="modal-body text-start">
                            <span class="mt-2"><strong>Description:</strong></span>
                            <p class="description" style="white-space:pre-wrap;">${menuItem.menu_description || 'No description available'}</p>
                            <span class="mt-2"><strong>Size:</strong></span>
                            <div class="size-options">
                                ${generateSizeOptionsHtml(menuItem.variations)}
                            </div>
                            <div class="quantity mt-3">
                                <label for="quantity">Quantity:</label>
                                <div class="input-group">
                                    <button class="btn btn-outline-secondary" type="button" id="btn-minus">-</button>
                                    <input type="number" id="quantity" class="form-control text-center" value="1" min="1">
                                    <button class="btn btn-outline-secondary" type="button" id="btn-plus">+</button>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-sm btn-add-to-cart" data-menu-id="${menuItem.id}">Add to Cart</button>
                        </div>`;

                        // Insert the modal content into the modal
                        $('#itemModal .modal-content').html(modalContent);
                        $('input[name="size"]:first').prop('checked', true);
                        // Show the modal
                        $('#itemModal').modal('show');
                        // Quantity increment and decrement logic
                        var quantityInput = $('#quantity');

                        $('#btn-plus').click(function() {
                            var currentValue = parseInt(quantityInput.val());
                            quantityInput.val(currentValue + 1);
                        });

                        $('#btn-minus').click(function() {
                            var currentValue = parseInt(quantityInput.val());
                            if (currentValue > 1) {
                                quantityInput.val(currentValue - 1);
                            }
                        });
                        $('.btn-add-to-cart').click(function() {
                            var menuID = $(this).attr('data-menu-id');
                            var sizeOptionName = $('input[name="size"]:checked').siblings('label').text().trim();
                            var sizeOption = $('.size-options').find('input[name="size"]:checked').val();
                            var quantity = parseInt($('#quantity').val());

                            // Prepare data to send to server
                            var cartItem = {
                                menu_id: menuID,
                                menu_name: menuItem.menu_name + " " + sizeOptionName,
                                variation_id: sizeOption,
                                quantity: quantity,
                                price: menuItem.variations[sizeOption - 1].price
                            };
                            //console.log(cartItem);
                            $('#itemModal').modal('hide');
                            addToCart(cartItem);
                            // console.log('Adding to cart:', cartItem);

                            // Send cartItem data to server via AJAX or handle as needed
                            // Example AJAX call to save cartItem to server
                            // $.ajax({
                            //     url: 'process/add_to_cart.php',
                            //     method: 'POST',
                            //     data: {
                            //         action: 'add_to_cart',
                            //         cart_item: cartItem
                            //     },
                            //     dataType: 'json',
                            //     success: function(response) {
                            //         if (response.success) {
                            //             // Optionally, update UI to reflect item added to cart
                            //             console.log('Item added to cart successfully.');
                            //             // Close the modal after adding to cart
                            //             $('#itemModal').modal('hide');
                            //         } else {
                            //             console.error('Failed to add item to cart:', response.message);
                            //         }
                            //     },
                            //     error: function(jqXHR, textStatus, errorThrown) {
                            //         console.error('AJAX Error:', textStatus, errorThrown);
                            //     }
                            // });
                        });
                    } else {
                        console.error('Failed to load menu item details:', response.message);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('AJAX Error:', textStatus, errorThrown);
                }
            });
        });

        // Function to generate size options HTML
        function generateSizeOptionsHtml(variations) {
            if (!variations || variations.length === 0) {
                return '<p>No size variations available</p>';
            }

            var sizeOptionsHtml = '';
            variations.forEach(function(variation) {
                sizeOptionsHtml += `
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="size" id="size-${variation.id}" value="${variation.id}">
                        <label class="form-check-label" for="size-${variation.id}">
                            ${variation.name} - ₱${variation.price.toFixed(2)}
                        </label>
                    </div>`;
            });
            return sizeOptionsHtml;
        }


        function openCartModal() {
            // Clear previous items and totals from the modal
            $('#cartItemsList').empty();
            $('#cartFooter').empty();

            // Initialize an object to store quantities of each item
            var itemQuantities = {};

            // Add each item in the cart to the modal
            var totalPrice = 0;
            cartItems.forEach(function(item, index) {
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
                    <div class="col">${item.menu_name}</div>
                    <div class="col-auto">${item.price}</div>
                    <div class="col-auto">${item.quantity}</div>
                    <div class="col">
                        <button type="button" class="btn btn-success btn-sm increment-item" data-index="${index}">+</button>
                        <button type="button" class="btn btn-danger btn-sm decrement-item" data-index="${index}">-</button>
                        <button type="button" class="btn btn-danger btn-sm remove-item" data-index="${index}"><i class='fa-solid fa-trash'></i></button>
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

        function addToCart(cartItem) {
            // Check if cartItem with same menu_id and variation_id already exists
            var existingCartItemIndex = cartItems.findIndex(item => item.menu_id == cartItem.menu_id && item.variation_id == cartItem.variation_id);

            if (existingCartItemIndex !== -1) {
                // Item with same menu_id and variation_id already exists, increment quantity
                cartItems[existingCartItemIndex].quantity += cartItem.quantity;
            } else {
                // Item does not exist in cart, add new item
                cartItems.push(cartItem);
            }

            // Optionally, update UI or send data to server
            console.log('Cart updated:', cartItems);
            updateViewListButton();
        }



        // Event handler for "Add to List" buttons
        // $('#menuItems').on('click', '.addtoList', function() {
        //     var menuID = $(this).attr('menu-id');
        //     $.ajax({
        //         url: "process/user_action.php",
        //         method: "POST",
        //         data: {
        //             action: "getMenubyMenuID",
        //             menu_id: menuID
        //         },
        //         dataType: "json",
        //         success: function(response) {
        //             if (response.success == true) {
        //                 response.menubyID.forEach(function(item) {
        //                     var menuItem = {
        //                     id: item.id,
        //                     name: item.menu_name,
        //                     price: item.menu_price,
        //                     }
        //                     addToCart(menuItem);
        //                 });
        //             }
        //         }
        //     });
        // });
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
                                    <div class="card" style=" background: radial-gradient(60% 60% at 50.25% 40%, #FF7979 0%, #F20000 100%);" menu-id="${item.id}">
                                        <div class="card-body text-center">
                                            <img src="../assets/images/menu/${item.menu_img}" class="img-fluid" alt="Bootstrap Image" style="height: 120px; width: auto;">
                                            <h5 class="text-center fs-8 text-white mt-2 mb-2">${item.menu_name}</h5>
                                            <h5 class="text-center text-white mt-2 mb-2" style="font-size: 16px;">₱ ${item.menu_price}</h5>
                                            <!-- <button class="btn btn-sm rounded-4 btn-light text-uppercase addtoList" menu-id="${item.id}">Add to List</button> -->
                                        </div>
                                    </div>
                                </div>
                            `;
                            $('#menuItems').append(menuItemHtml);
                        });
                        // LoadTable();
                        // $('#categoryModal').modal('hide');
                        // toastr.success(response.message);
                    } else {
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

        $('#viewListButton').click(function() {
            openCartModal();
        });
        // Event handler for incrementing item quantity in cart modal
        $('#cartItemsList').on('click', '.increment-item', function() {
            var index = $(this).data('index');
            //console.log("Index: " + index);
            cartItems[index].quantity++;
            openCartModal(); // Update cart modal
        });

        // Event handler for decrementing item quantity in cart modal
        $('#cartItemsList').on('click', '.decrement-item', function() {
            var index = $(this).data('index');
            //console.log("Index: " + index);
            if (cartItems[index].quantity > 1) {
                cartItems[index].quantity--;
            }
            openCartModal(); // Update cart modal
        });

        // Event handler for removing item from cart modal
        $('#cartItemsList').on('click', '.remove-item', function() {
            var index = $(this).data('index');
            cartItems.splice(index, 1); // Remove item from cartItems array
            openCartModal(); // Update cart modal
            updateViewListButton(); // Update "View List" button
        });

    });
</script>