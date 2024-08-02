<?php
function getCategory($pdo)
{
    try {
        $query = "SELECT * FROM category";
        $stmt = $pdo->prepare($query);

        $stmt->execute();
        $category = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $category;
    } catch (PDOException $e) {
        // Handle database connection error
        echo "Error: " . $e->getMessage();
        return array(); // Return an empty array if an error occurs
    }
}

function getFoodMenu($pdo)
{
    try {
        $query = "SELECT * FROM menu";
        $stmt = $pdo->prepare($query);

        $stmt->execute();
        $foodmenu = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $foodmenu;
    } catch (PDOException $e) {
        // Handle database connection error
        echo "Error: " . $e->getMessage();
        return array(); // Return an empty array if an error occurs
    }
}
function getFoodMenubyID($pdo)
{
    try {
        $category_id = isset($_POST['category_id']) ? $_POST['category_id'] : null;

        if ($category_id) {
            $query = "SELECT a.id, a.menu_name,
            IFNULL(MIN(b.price), 'undefined') AS menu_price,
            c.category_name,
            a.menu_img,
            a.created_at
            FROM menu a
            LEFT JOIN menu_variations b ON a.id = b.menu_id
            LEFT JOIN category c ON a.category_id = c.category_id
            WHERE a.category_id = :category_id AND a.isEnabled = '1'
            GROUP BY a.id, a.menu_name, a.category_id, c.category_name, a.created_at, a.updated_at";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        } else {
            $query = "SELECT a.id, a.menu_name,
            IFNULL(MIN(b.price), 'undefined') AS menu_price,
            c.category_name,
            a.menu_img,
            a.created_at
            FROM menu a
            LEFT JOIN menu_variations b ON a.id = b.menu_id
            LEFT JOIN category c ON a.category_id = c.category_id
            WHERE a.isEnabled = '1'
            GROUP BY a.id, a.menu_name, a.category_id, c.category_name, a.created_at, a.updated_at";
            $stmt = $pdo->prepare($query);
        }

        $stmt->execute();
        $foodmenulist_by_id = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $foodmenulist_by_id;
    } catch (PDOException $e) {
        // Handle database connection error
        echo "Error: " . $e->getMessage();
        return array(); // Return an empty array if an error occurs
    }
}
function getFoodDetailsbyID($pdo)
{
    try {
        $menu_id = isset($_POST['menu_id']) ? $_POST['menu_id'] : null;

        if ($menu_id) {
            $query = "SELECT
                a.id,
                a.menu_img,
                a.menu_name,
                a.menu_description,
                a.category_id,
                d.category_name,
                c.id AS variation_id,
                c.variation_name,
                b.price
            FROM menu a
            LEFT JOIN menu_variations b ON a.id = b.menu_id
            LEFT JOIN variations c ON b.variation_id = c.id
            LEFT JOIN category d ON a.category_id = d.category_id
            WHERE b.menu_id = :menu_id AND a.isArchive = 0";

            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':menu_id', $menu_id, PDO::PARAM_INT);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($results) {
                $menuItems = [];

                foreach ($results as $row) {
                    $menuID = $row['id'];
                    if (!isset($menuItems[$menuID])) {
                        $menuItems[$menuID] = [
                            'id' => $row['id'],
                            'img_path' => $row['menu_img'],
                            'menu_name' => $row['menu_name'],
                            'menu_description' => $row['menu_description'],
                            'category_name' => $row['category_name'],
                            'variations' => []
                        ];
                    }
                    $menuItems[$menuID]['variations'][] = [
                        'id' => $row['variation_id'],
                        'name' => $row['variation_name'],
                        'price' => (float) $row['price']
                    ];
                }

                // Return JSON-encoded data
                return array_values($menuItems);
            } else {
                return json_encode(['success' => false, 'message' => 'No menu items found for menu ID: ' . $menu_id]);
            }
        } else {
            return json_encode(['success' => false, 'message' => 'Menu ID is missing']);
        }
    } catch (PDOException $e) {
        // Handle database connection or query error
        return json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
}

function getFoodMenubyMenuID($pdo)
{
    try {
        $menu_id = isset($_POST['menu_id']) ? $_POST['menu_id'] : null;
        $variation_id = isset($_POST['variation_id']) ? $_POST['variation_id'] : null;

        if ($menu_id) {
            $query = "SELECT
            a.id,
            a.menu_name,
            c.id AS variation_id,
            c.variation_name,
            b.price
            FROM menu a
            LEFT JOIN menu_variations b ON a.id = b.menu_id
            LEFT JOIN variations c ON b.variation_id = c.id
            WHERE b.menu_id = :menu_id AND b.variation_id = :variation_id AND a.isArchive = 0";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':menu_id', $menu_id, PDO::PARAM_INT);
            $stmt->bindParam(':variation_id', $variation_id, PDO::PARAM_INT);
        }
        $stmt->execute();
        $menubyid = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $menubyid;
    } catch (PDOException $e) {
        // Handle database connection error
        echo "Error: " . $e->getMessage();
        return array(); // Return an empty array if an error occurs
    }
}
function orderNow($pdo) {
    try {
        // Begin transaction
        $pdo->beginTransaction();

        $tableNo = $_POST['tableNo'];
        $fullname = $_POST['fullname'];
        $orderItems = $_POST['cartList']; // Assuming this is already an array

        // Check if orderItems is an array
        if (!is_array($orderItems)) {
            // Handle the error or decode it if needed
            $pdo->rollBack();
            return false;
        }

        // Insert customer order and retrieve the generated order ID
        $stmt = $pdo->prepare("INSERT INTO customer_order (table_no, customer_name) VALUES (:table_no, :customer_name)");
        $stmt->bindParam(':table_no', $tableNo, PDO::PARAM_INT);
        $stmt->bindParam(':customer_name', $fullname);
        if (!$stmt->execute()) {
            // If the insert fails, rollback the transaction and return false
            $pdo->rollBack();
            return false;
        }
        $orderNo = $pdo->lastInsertId(); // Retrieve the last inserted order ID

        // Prepare the statement for inserting into ordered_menu
        $stmt = $pdo->prepare("INSERT INTO ordered_menu (order_no, menu_id, variation_id, qty, price) VALUES (:order_no, :menu_id, :variation_id, :qty, :price)");

        // Iterate through the order items and insert each one
        foreach ($orderItems as $item) {
            $stmt->bindParam(':order_no', $orderNo, PDO::PARAM_INT);
            $stmt->bindParam(':menu_id', $item['menu_id'], PDO::PARAM_INT);
            $stmt->bindParam(':variation_id', $item['variation_id'], PDO::PARAM_INT);
            $stmt->bindParam(':qty', $item['quantity'], PDO::PARAM_INT);
            $stmt->bindParam(':price', $item['price'], PDO::PARAM_STR);
            if (!$stmt->execute()) {
                // If the insert fails, rollback the transaction and return false
                $pdo->rollBack();
                return false;
            }
        }

        // Commit the transaction
        $pdo->commit();
        return $orderNo; // Return the order number if successful

    } catch (PDOException $e) {
        // Handle database connection error
        $pdo->rollBack();
        return false; // Return false if an error occurs
    }
}

function saveCustomerDetails($pdo) {
    try {
        // Begin transaction
        $pdo->beginTransaction();
        $fname = $_POST['fullname'];
        $contactNo = isset($_POST['contactno']) ? $_POST['contactno'] : null;
        $email = isset($_POST['email']) ? $_POST['email'] : null;

        // Insert customer details
        $stmt = $pdo->prepare("INSERT INTO customer_detail (customer_name, customer_contact, customer_email) VALUES (:customer_name, :customer_contact, :customer_email)");
        $stmt->bindParam(':customer_name', $fname);
        $stmt->bindParam(':customer_contact', $contactNo);
        $stmt->bindParam(':customer_email', $email);
        $stmt->execute(); // Execute the query

        // Commit the transaction
        $pdo->commit();
        return true;
        
    } catch (PDOException $e) {
        // Handle database connection or query error
        echo "Error: " . $e->getMessage();
        // Rollback the transaction if an error occurs
        $pdo->rollBack();
        return false; // Return false if an error occurs
    }
}

function saveCustomerFeedback($pdo) {
    try {
        // Begin transaction
        $pdo->beginTransaction();
        $fname = $_POST['fullname'];
        $contactNo = isset($_POST['contactno']) ? $_POST['contactno'] : null;
        $email = isset($_POST['email']) ? $_POST['email'] : null;
        $rating = $_POST['rating'];
        $remarks = $_POST['remarks'];

        // Insert customer details + feedback
        $stmt = $pdo->prepare("INSERT INTO customer_feedback (customer_name, customer_contact, customer_email, customer_rate, customer_remarks) VALUES (:customer_name, :customer_contact, :customer_email, :customer_rate, :customer_remarks)");
        $stmt->bindParam(':customer_name', $fname);
        $stmt->bindParam(':customer_contact', $contactNo);
        $stmt->bindParam(':customer_email', $email);
        $stmt->bindParam(':customer_rate', $rating, PDO::PARAM_INT);
        $stmt->bindParam(':customer_remarks', $remarks);
        $stmt->execute(); // Execute the query

        // Commit the transaction
        $pdo->commit();
        return true;
        
    } catch (PDOException $e) {
        // Handle database connection or query error
        echo "Error: " . $e->getMessage();
        // Rollback the transaction if an error occurs
        $pdo->rollBack();
        return false; // Return false if an error occurs
    }
}
