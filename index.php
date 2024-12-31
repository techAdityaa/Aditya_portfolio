<?php
// Database connection variables
$server = "localhost";
$username = "root";
$password = "";
$database = "aditya_port_folio"; 

// Establish the connection
$con = mysqli_connect($server, $username, $password, $database);

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Use isset() or null coalescing operator to avoid undefined key warnings
    $Name = $_POST['Name'] ?? '';
    $Email = $_POST['Email'] ?? '';
    $Massage = $_POST['Massage'] ?? '';

    // Validate that none of the fields are empty
    if (!empty($Name) && !empty($Email) && !empty($Massage)) {
        // Escape input to prevent SQL injection
        $Name = mysqli_real_escape_string($con, $Name);
        $Email = mysqli_real_escape_string($con, $Email);
        $Massage = mysqli_real_escape_string($con, $Massage);

        // Insert the data into the database
        $sql = "INSERT INTO `contact` (`Name`, `Email`, `Massage`) 
                VALUES ('$Name', '$Email', '$Massage')";

        // Execute the query and return success or error as JSON
        if (mysqli_query($con, $sql)) {
            echo json_encode(['status' => 'success', 'message' => 'Data submitted successfully!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error: ' . mysqli_error($con)]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Please fill in all fields!']);
    }
    exit; // Stop further processing
}

// Close the connection
mysqli_close($con);
?>
