<?php
$servername = "localhost"; // 
$username = "root";
$password = "";
$database = "mhs";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set header for Excel file
header ("Content-Type: text/csv");
header ("Content-Disposition: attachment; filename=mhs_data.csv");

$output = fopen("php://output","w");

// Write the header row
fputcsv($output, ["NamaMhs", "NIPD", "TanggalLahir", "Alamat"]);

// fetch data from teh table
$sql = "SELECT namaMhs, NIPD, tanggalLahir, alamat FROM mhs";
$result = $conn->query($sql);

if ($result->num_rows > 0){
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, $row);
    }
}

fclose($output);
$conn->close();
exit;
?>