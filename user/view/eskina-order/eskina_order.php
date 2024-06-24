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
    .gfg {
    height: 50px;
    width: 50px;
    }

.mynav {
    color: #fff;
}

.mynav li a {
    color: #fff;
    text-decoration: none;
    width: 100%;
    display: block;
    border-radius: 5px;
    padding: 8px 5px;
}

.mynav li a.active {
    background: rgba(255, 255, 255, 0.2);
}

.mynav li a:hover {
    background-color:white;
    color: red;
}

.mynav li a i {
    width: 25px;
    text-align: center;
}

.notification-badge {
    background-color: rgba(255, 255, 255, 0.7);
    float: right;
    color: #222;
    font-size: 14px;
    padding: 0px 8px;
    border-radius: 2px;
}
li.list-group-item.nav-item.mb-1.lead:hover {
    color: white;
    font-size: 25px;
}
.bg-danger1{
    background-color: #dc3545;
}
</style>
<!--  -->
<div class="container-fluid p-0 d-flex h-100">
        <div id="bdSidebar" 
             class="d-flex flex-column 
                    flex-shrink-0 
                    p-3 bg-danger1
                    text-white offcanvas-md offcanvas-start">
            <a href="#" 
               class="navbar-brand">
            </a><hr>
            <ul class="mynav nav nav-pills flex-column mb-auto" id="list-menu">
                <li class="list-group-item nav-item mb-1" aria-current="true" role="button" data-id="">All</li><hr>
                                <?php foreach ($categorys as $category) : ?>
                                    <li class="list-group-item nav-item mb-1 lead"aria-current="true" role="button" data-id="<?php echo $category['category_id'] ?>"><?php echo $category['category_name'] ?></li><hr>
                                <?php endforeach; ?>
  
            </ul>
           
        </div>

        <div class="bg-light flex-fill">
            <div class="p-2 d-md-none d-flex text-white bg-danger">
                <a href="#" class="text-white" 
                   data-bs-toggle="offcanvas"
                   data-bs-target="#bdSidebar">
                    <i class="fa-solid fa-bars"></i>
                </a>
                <span class="ms-3">Eskina</span>
            </div>
            <div class="p-4">
                <!-- <nav style="--bs-breadcrumb-divider:'>';font-size:14px">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <i class="fa-solid fa-house"></i>
                        </li>
                        <li class="breadcrumb-item">Learning Content</li>
                        <li class="breadcrumb-item">Next Page</li>
                    </ol>
                </nav>
 -->
                <!-- <hr> -->
                <div class="row">
                    <div class="col">
                        <!--  -->
                        <main>
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="4" aria-label="Slide 5"></button>
            </div>
 
            <!-- Image Sliders -->
            <div class="carousel-inner">
            <!-- Image one-->
              <div class="carousel-item active">
                <img src="../assets/images/one.jpg" class="d-block w-100" alt="...">
              </div>
 
              <!-- image two -->
              <div class="carousel-item">
                <img src="../assets/images/two.jpg" class="d-block w-100" alt="...">
              </div>
 
              <!-- Image Three -->
              <div class="carousel-item">
                <img src="../assets/images/three.jpg" class="d-block w-100" alt="...">
              </div>
 
              <!-- Image Four -->
              <div class="carousel-item">
                <img src="../assets/images/one.jpg" class="d-block w-100" alt="...">
              </div>
 
              <!-- Image Five -->
              <div class="carousel-item">
                <img src="../assets/images/two.jpg" class="d-block w-100" alt="...">
              </div>
            </div>
 
            <!-- Carousel Controls -->
           <section>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
              </button>
              
              <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
              </button>
           </section>
          </div>
    </main>
 
    <!-- Option 2: Separate Popper and Bootstrap JS -->
   
<!--  -->
<!-- <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="../assets/images/b2.jpg" class="d-block w-100" alt="...">
    </div>
</div>
  <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div> -->
<!--  -->
    <div class="text-center mt-5 fs-3">
        <!-- <h1>Welcome to Eskina</h1> -->
    </div>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="row p-2">
                    <!-- <div class="col-12" style="max-width: 100%;">
                        <div class="list-group-scrollable" data-simplebar="">
                            <ul class="list-group d-flex flex-row" id="list-menu">
                                <li class="list-group-item" aria-current="true" role="button" data-id="">All</li>
                                <?php foreach ($categorys as $category) : ?>
                                    <li class="list-group-item" aria-current="true" role="button" data-id="<?php echo $category['category_id'] ?>"><?php echo $category['category_name'] ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div> -->
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
<!-- MODAL THANK YOU -->
<div class="modal" id="thankModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Thank You for Your Order!</h5>
      </div>
      <div class="modal-body">
         <p id="customerName"></p>
        <p style="white-space: pre-wrap;">Thank you for your purchase! Your order has been received and is being processed.

Please wait a moment while we confirm your order details. A representative will be with you shortly to finalize everything.

We appreciate your patience and look forward to serving you!</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
                        <!--  -->
                    </div>
                </div>
            </div>

        </div>
    </div>

<script>
    $(document).ready(function() {
        var cartItems = [];
        function findPriceById(variations, id) {
            let variation = variations.find(variation => variation.id === id);
            return variation ? variation.price : null; // Return null if the variation is not found
        }
        $('#orderNow').click(function() {
            let formData = localStorage.getItem('formData');
            let tableNumber = localStorage.getItem('tableNumber');

            // Parse the form data
            let params = new URLSearchParams(formData);
            let fullname = params.get('fullname');
            let contactno = params.get('contactno');
            let email = params.get('email');

            document.getElementById("customerName").innerText = "Dear " + fullname + ",";

            $.ajax({
                url: "process/user_action.php",
                method: "POST",
                data: {
                    tableNo : tableNumber,
                    fullname : fullname,
                    cartList : cartItems,
                    action : "orderNow"
                },
                dataType: "json",
                success: function(response) {
                    if(response.success==true){
                        clearCart();
                        $('#cartModal').modal('hide');
                        $('#thankModal').modal('show');
                        toastr.success(response.message);
                    }else{
                        toastr.error(response.message);
                    }
                }
            });
            // // console.log(fullname+' '+contactno+' '+email+' '+tableNumber);
            // clearCart();
            // $('#cartModal').modal('hide');
            // $('#thankModal').modal('show');
            
            // console.log(cartItems);
        });

        function updateViewListButton() {
            var itemCount = cartItems.length;
            $('#viewListButton').text(`View List | ${itemCount}`);
        }
        $('#menuItems').on('click', '.card', function() {
            var menuID = $(this).attr('menu-id');
            // console.log('Menu ID:', menuID); // Log menu ID to confirm it's correct

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
// console.log(menuItem.variations);
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
                            var variations = menuItem.variations;
                            var variationIdToFind = parseInt(sizeOption);
                            // console.log('selected:', variationIdToFind);
                            var variation = variations.find(variation => variation.id === variationIdToFind);
                            // console.log('Found variation:', variation);
                            // Prepare data to send to server
                            var cartItem = {
                                menu_id: menuID,
                                menu_name: menuItem.menu_name + " " + sizeOptionName,
                                variation_id: sizeOption,
                                quantity: quantity,
                                price: variation.price
                            };
                            // console.log();
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
            // console.log('Cart updated:', cartItems);
            updateViewListButton();
        }
        function clearCart() {
            cartItems = [];
            updateViewListButton(); // Optionally update the UI after clearing the cart
            // console.log('Cart cleared:', cartItems); // Confirm that the cart is cleared
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
</div>