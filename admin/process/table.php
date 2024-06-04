<?php
require_once '../../config.php';

// Check if a table type is provided in the request
if (isset($_GET['table_type'])) {
    $tableType = $_GET['table_type'];

    // Define SQL query based on the table type
    switch ($tableType) {
        case 'food-menu':
            $sql = 'SELECT * FROM menu a
                    INNER JOIN category b ON b.category_id = a.category_id
                    ORDER BY category_name ASC';
            break;
        case 'category':
            $sql = 'SELECT * FROM category
                    ORDER BY category_name ASC';
            break;
        case 'customer-detail':
            $sql = 'SELECT * FROM customer_detail
                    ORDER BY created_at DESC';
            break;
        case 'customer-feedback':
            $sql = 'SELECT * FROM customer_feedback
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
