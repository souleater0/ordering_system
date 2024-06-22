<?php
session_start();
require_once '../../config.php';
require_once 'function.php';
if (!empty($_POST['action']) && $_POST['action'] == 'loginProcess') {
    if (loginProcess($pdo)) {
        $response = array(
            'success' => true,
            'message' => 'Login successful.',
            'redirectUrl' => '../index.php?route=dashboard'
        );
    } else {
        $response = array(
            'success' => false,
            'message' => 'Invalid Credentials!'
        );
    }
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
if (!empty($_POST['action']) && $_POST['action'] == 'addUser') {
    if (empty($_POST['user_display'])) {
        $response = array(
            'success' => false,
            'message' => 'Please enter a display name!'
        );
    } else if (empty($_POST['username'])) {
        $response = array(
            'success' => false,
            'message' => 'Please enter a display name!'
        );
    } else {
        if (addUser($pdo)) {
            $response = array(
                'success' => true,
                'message' => 'User has been created.'
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Failed to create new user!'
            );
        }
    }
    // Send response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
if (!empty($_POST['action']) && $_POST['action'] == 'updateUser') {
    if (empty($_POST['user_display'])) {
        $response = array(
            'success' => false,
            'message' => 'Please enter a display name!'
        );
    } else if (empty($_POST['username'])) {
        $response = array(
            'success' => false,
            'message' => 'Please enter a display name!'
        );
    } else {
        if (updateUser($pdo)) {
            $response = array(
                'success' => true,
                'message' => 'User has been updated.'
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Failed to update user!'
            );
        }
    }
    // Send response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
if (!empty($_POST['action']) && $_POST['action'] == 'updateUserPassword') {
    if (empty($_POST['password'])) {
        $response = array(
            'success' => false,
            'message' => 'Please enter a password!'
        );
    } else if (empty($_POST['c_password'])) {
        $response = array(
            'success' => false,
            'message' => 'Please enter a confirm password!'
        );
    } else {
        if (updateUserPassword($pdo)) {
            $response = array(
                'success' => true,
                'message' => 'User password has been updated.'
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Failed to update password!'
            );
        }
    }
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
if (!empty($_POST['action']) && $_POST['action'] == 'addFood') {
    if (empty($_POST['food_name'])) {
        $response = array(
            'success' => false,
            'message' => 'Please enter a food name!'
        );
    } else {
        if (addFood($pdo)) {
            $response = array(
                'success' => true,
                'message' => 'Food has been Added.'
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Failed to add Food!.'
            );
        }
    }
    // Send response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
if (!empty($_POST['action']) && $_POST['action'] == 'updateFood') {
    if (empty($_POST['food_name'])) {
        $response = array(
            'success' => false,
            'message' => 'Please enter a food name!'
        );
    } else {
        if (updateFood($pdo)) {
            $response = array(
                'success' => true,
                'message' => 'Food has been Updated.'
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Failed to update Food!.'
            );
        }
    }
    // Send response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
if (!empty($_POST['action']) && $_POST['action'] == 'updateFood') {
    if (empty($_POST['food_name'])) {
        $response = array(
            'success' => false,
            'message' => 'Please enter a food name!'
        );
    } else if (empty($_POST['food_price'])) {
        $response = array(
            'success' => false,
            'message' => 'Please enter a food price!'
        );
    } else {
        if (updateFood($pdo)) {
            $response = array(
                'success' => true,
                'message' => 'Food has been updated.'
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Failed to update Food!.'
            );
        }
    }
    // Send response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
if (!empty($_POST['action']) && $_POST['action'] == 'deleteFood') {
    if (empty($_POST['delete_id'])) {
        $response = array(
            'success' => false,
            'message' => 'No food id found!'
        );
    } else {
        if (deleteFood($pdo)) {
            $response = array(
                'success' => true,
                'message' => 'Food has been deleted.'
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Failed to delete Food!.'
            );
        }
    }
    // Send response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
if (!empty($_POST['action']) && $_POST['action'] == 'addVariation') {
    if (empty($_POST['variation_name'])) {
        $response = array(
            'success' => false,
            'message' => 'Please enter a variation name!'
        );
    } else {
        if (addVariation($pdo)) {
            $response = array(
                'success' => true,
                'message' => 'variation has been Added.'
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Failed to add variation!.'
            );
        }
    }
    // Send response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
if (!empty($_POST['action']) && $_POST['action'] == 'updateVariation') {
    if (empty($_POST['variation_name'])) {
        $response = array(
            'success' => false,
            'message' => 'Please enter a variation name!'
        );
    } else {
        if (updateVariation($pdo)) {
            $response = array(
                'success' => true,
                'message' => 'variation has been Updated.'
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Failed to update variation!.'
            );
        }
    }
    // Send response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
if (!empty($_POST['action']) && $_POST['action'] == 'deleteVariation') {
    if (empty($_POST['delete_id'])) {
        $response = array(
            'success' => false,
            'message' => 'No variation id found!'
        );
    } else {
        if (deleteVariation($pdo)) {
            $response = array(
                'success' => true,
                'message' => 'Variation has been deleted.'
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Failed to delete Variation!.'
            );
        }
    }
    // Send response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
if (!empty($_POST['action']) && $_POST['action'] == 'addCategory') {
    if (empty($_POST['category_name'])) {
        $response = array(
            'success' => false,
            'message' => 'Please enter a category name!'
        );
    } else {
        if (addCategory($pdo)) {
            $response = array(
                'success' => true,
                'message' => 'category has been Added.'
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Failed to add category!.'
            );
        }
    }
    // Send response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
if (!empty($_POST['action']) && $_POST['action'] == 'updateCategory') {
    if (empty($_POST['category_name'])) {
        $response = array(
            'success' => false,
            'message' => 'Please enter a category name!'
        );
    } else {
        if (updateCategory($pdo)) {
            $response = array(
                'success' => true,
                'message' => 'category has been Updated.'
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Failed to update category!.'
            );
        }
    }
    // Send response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
if (!empty($_POST['action']) && $_POST['action'] == 'deleteCategory') {
    if (empty($_POST['delete_id'])) {
        $response = array(
            'success' => false,
            'message' => 'No food id found!'
        );
    } else {
        if (deleteCategory($pdo)) {
            $response = array(
                'success' => true,
                'message' => 'Category has been deleted.'
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Failed to delete Category!.'
            );
        }
    }
    // Send response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}

if (!empty($_POST['action']) && $_POST['action'] == 'getMenuVariations') {
    $menuId = $_POST['menu_id'];
    // Fetch variations from the database
    $query = $pdo->prepare("SELECT * 
    FROM menu_variations a 
    INNER JOIN variations b ON b.id = a.variation_id 
    WHERE a.menu_id = :menu_id");
    $query->execute(['menu_id' => $menuId]);
    $variations = $query->fetchAll(PDO::FETCH_ASSOC);

    if ($variations) {
        echo json_encode(['success' => true, 'variations' => $variations]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No variations found']);
    }
    exit();
}
if (!empty($_POST['action']) && $_POST['action'] == 'order_to_process') {
    if (empty($_POST['order_no'])) {
        $response = array(
            'success' => false,
            'message' => 'No order no. found!'
        );
    } else {
        if (Order_to_Process($pdo)) {
            $order_no = $_POST['order_no'];
            $response = array(
                'success' => true,
                'message' => 'Order No#' . $order_no . ' has been Processed '
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Failed to process Order!.'
            );
        }
    }
    // Send response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
if (!empty($_POST['action']) && $_POST['action'] == 'order_to_cancel') {
    if (empty($_POST['order_no'])) {
        $response = array(
            'success' => false,
            'message' => 'No order no. found!'
        );
    } else {
        if (Order_to_Cancel($pdo)) {
            $order_no = $_POST['order_no'];
            $response = array(
                'success' => true,
                'message' => 'Order No#' . $order_no . ' has been Processed '
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Failed to cancel Order!.'
            );
        }
    }
    // Send response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
if (!empty($_POST['action']) && $_POST['action'] == 'process_to_serve') {
    if (empty($_POST['order_no'])) {
        $response = array(
            'success' => false,
            'message' => 'No order no. found!'
        );
    } else {
        if (Process_to_Serve($pdo)) {
            $order_no = $_POST['order_no'];
            $response = array(
                'success' => true,
                'message' => 'Order No#' . $order_no . ' has been Served '
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Failed to serve Order!.'
            );
        }
    }
    // Send response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
if (!empty($_POST['action']) && $_POST['action'] == 'process_to_cancel') {
    if (empty($_POST['order_no'])) {
        $response = array(
            'success' => false,
            'message' => 'No order no. found!'
        );
    } else {
        if (Process_to_Cancel($pdo)) {
            $order_no = $_POST['order_no'];
            $response = array(
                'success' => true,
                'message' => 'Order No#' . $order_no . ' has been Processed '
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Failed to cancel Order!.'
            );
        }
    }
    // Send response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
if (!empty($_POST['action']) && $_POST['action'] == 'serve_to_complete') {
    if (empty($_POST['order_no'])) {
        $response = array(
            'success' => false,
            'message' => 'No order no. found!'
        );
    } else {
        if (Serve_to_Complete($pdo)) {
            $order_no = $_POST['order_no'];
            $response = array(
                'success' => true,
                'message' => 'Order No#' . $order_no . ' has been completed '
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Failed to complete Order!.'
            );
        }
    }
    // Send response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
if (!empty($_POST['action']) && $_POST['action'] == 'cancel_to_order') {
    if (empty($_POST['order_no'])) {
        $response = array(
            'success' => false,
            'message' => 'No order no. found!'
        );
    } else {
        if (Cancel_to_Order($pdo)) {
            $order_no = $_POST['order_no'];
            $response = array(
                'success' => true,
                'message' => 'Order No#' . $order_no . ' has been Processed '
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Failed to process Order!.'
            );
        }
    }
    // Send response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
