<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cloud";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}else{
     echo "Connected successfully";
    // $sql = "SELECT * FROM users";
    // $result = $conn->query($sql);
    // if ($result->num_rows > 0) {
    //     while($row = $result->fetch_assoc()) {
    //         echo "id: " . $row["id"]. " - Name: " . $row["name"]. "<br>";
    //     }
    // } else {
    //     echo "0 results";
    // }
    // $conn->close();
}
?>
