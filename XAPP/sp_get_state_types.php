<?php
require_once 'db_connection.php';

$result = $conn->query("CALL sp_get_state_types()");

if ($result) {
    $data = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($data);
} else {
    echo json_encode(['error' => $conn->error]);
}

$conn->close();
?>
