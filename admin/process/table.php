<?php
require_once '../../config.php';

// Check if a table type is provided in the request
if (isset($_GET['table_type'])) {
    $tableType = $_GET['table_type'];

    // Define SQL query based on the table type
    switch ($tableType) {
        // case 'food-menu':
        //     $sql = 'SELECT * FROM menu a
        //             INNER JOIN category b ON b.category_id = a.category_id
        //             ORDER BY category_name ASC';
        //     break;
        case 'food-menu':
            $sql = 'SELECT a.id, a.menu_name,
            GROUP_CONCAT(b.price ORDER BY b.price SEPARATOR ", ") AS all_prices,
            a.category_id,
            c.category_name,
            a.created_at
            FROM menu a
            LEFT JOIN menu_variations b ON a.id = b.menu_id
            LEFT JOIN category c ON a.category_id = c.category_id
            GROUP BY a.id, a.menu_name, a.category_id, c.category_name, a.created_at, a.updated_at';
            break;
        case 'category':
            $sql = 'SELECT * FROM category
                    ORDER BY category_name ASC';
            break;
        case 'variation':
            $sql = 'SELECT * FROM variations
                    ORDER BY variation_name ASC';
            break;
        case 'customer-detail':
            $sql = 'SELECT * FROM customer_detail
                    ORDER BY created_at DESC';
            break;
        case 'customer-feedback':
            $sql = 'SELECT * FROM customer_feedback
                    ORDER BY created_at DESC';
            break;
        case 'users':
            $sql = 'SELECT
            a.id,
            a.display_name,
            a.username,
            a.role_id,
            b.role_name,
            a.isEnabled,
            CASE 
                WHEN a.isEnabled = 1 THEN "Enabled"
                ELSE "Disabled"
            END as status
            FROM users a
            INNER JOIN roles b ON b.id = a.role_id
            ORDER BY display_name ASC';
            break;
        case 'customer-order':
            $sql = 'SELECT * FROM customer_order
                    ORDER BY created_at DESC';
            break;
        default:
            // If an invalid or unsupported table type is provided, return an error
            echo json_encode(['error' => 'Unsupported table type']);
            exit;
    }
    // Execute the query
    $stmt = $pdo->query($sql);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['data' => $data]);
} else {
    echo json_encode(['error' => 'Table type not specified']);
}
