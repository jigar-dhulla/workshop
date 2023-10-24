<?php
try {
    $db_host = "db";
    $db_name = "todoapp";
    $db_user = "root";
    $db_pass = "secret";

    $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database connection error: ' . $e->getMessage()]);
    exit;
}

if (isset($_GET['id'])) {
    $taskId = $_GET['id'];

    $sql = "UPDATE todos SET completed = NOT completed WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $taskId, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Task completion toggle failed: ' . $stmt->errorInfo()[2]]);
    }
}
