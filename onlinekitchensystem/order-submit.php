<?php
include 'db.php';

$sql = "SELECT * FROM foodie_db ORDER BY id DESC"; // use your table name
$result = $conn->query($sql);

$foodie_db = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $foodie_db[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($foodie_db);

$conn->close();
?>

