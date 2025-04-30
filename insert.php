<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Database configuration
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "inventorydb";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO inventory (item_name, category, quantity, price) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    // Get form data with proper null coalescing
    $item_name = $_POST['item-name'] ?? '';
    $category = $_POST['item-category'] ?? '';
    $quantity = $_POST['item-quantity'] ?? 0;
    $price = $_POST['item-value'] ?? 0.00;

    // Bind parameters
    $bind_result = $stmt->bind_param("ssid", $item_name, $category, $quantity, $price);
    if (!$bind_result) {
        die("Bind failed: " . $stmt->error);
    }

    // Execute statement
    if ($stmt->execute()) {
        // Success - you could redirect or output success message
        echo "Item inserted successfully!";
    } else {
        die("Execute failed: " . $stmt->error);
    }

    // Close connections
    $stmt->close();
    $conn->close();
    
    // Exit script
    exit();
} else {
    die("Invalid request method");
}
?>