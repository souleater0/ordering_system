<?php
require_once '../config.php';
require '../vendor/autoload.php'; // Include Composer's autoloader

use FPDF\FPDF; // Use the FPDF namespace

$pdf = new \FPDF();
$pdf->AddPage();

// Use the built-in Arial font
$pdf->SetFont('Arial', '', 12);

if (isset($_GET['order_no'])) {
    $orderNo = intval($_GET['order_no']);

    // Fetch order details
    $stmt = $pdo->prepare("SELECT * FROM customer_order WHERE order_no = :order_no");
    $stmt->bindParam(':order_no', $orderNo, PDO::PARAM_INT);
    $stmt->execute();
    $orderDetails = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$orderDetails) {
        $pdf->Cell(0, 10, 'Order not found.', 0, 1, 'C');
        $pdf->Output('D', 'receipt_' . $orderNo . '.pdf');
        exit();
    }

    $stmt = $pdo->prepare("SELECT b.menu_name, a.qty, a.price
        FROM ordered_menu a
        INNER JOIN menu b ON a.menu_id = b.id
        WHERE a.order_no = :order_no");
    $stmt->bindParam(':order_no', $orderNo, PDO::PARAM_INT);
    $stmt->execute();
    $orderItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Add a title
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'Eskina Order Receipt', 0, 1, 'C');
    $pdf->Ln(10);

    // Add order details
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'Order No: ' . $orderDetails['order_no'], 0, 1);
    $pdf->Cell(0, 10, 'Customer Name: ' . $orderDetails['customer_name'], 0, 1);
    $pdf->Cell(0, 10, 'Table No: ' . $orderDetails['table_no'], 0, 1);

    // Add order date and time
    $currentDateTime = date('Y-m-d h:i:s A'); // 12-hour format with AM/PM
    $pdf->Cell(0, 10, 'Order Date: ' . $currentDateTime, 0, 1);
    $pdf->Ln(10);

    // Add items header
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(80, 10, 'Item', 1);
    $pdf->Cell(30, 10, 'Qty', 1);
    $pdf->Cell(30, 10, 'Price', 1);
    $pdf->Cell(30, 10, 'Total', 1);
    $pdf->Ln();

    // Initialize total amount
    $totalAmount = 0;

    // Add items data
    $pdf->SetFont('Arial', '', 12);
    foreach ($orderItems as $item) {
        $itemTotal = $item['qty'] * $item['price'];
        $totalAmount += $itemTotal;

        $pdf->Cell(80, 10, $item['menu_name'], 1);
        $pdf->Cell(30, 10, $item['qty'], 1);
        $pdf->Cell(30, 10, 'Php ' . number_format($item['price'], 2), 1);
        $pdf->Cell(30, 10, 'Php ' . number_format($itemTotal, 2), 1);
        $pdf->Ln();
    }

    // Add total amount
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(140, 10, 'Total Amount:', 1);
    $pdf->Cell(30, 10, 'Php ' . number_format($totalAmount, 2), 1);
    
    // Output the PDF as a download
    $pdf->Output('D', 'receipt_' . $orderNo . '.pdf');
    exit();
} else {
    // If no order_no is provided, display an error message
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'Order number is missing.', 0, 1, 'C');
    $pdf->Output('D', 'receipt_error.pdf');
    exit();
}
?>
