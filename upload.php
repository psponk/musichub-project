<?php
// Set output directory
$output_directory = "C:/xampp/htdocs/musichub-master/output";
date_default_timezone_set('Asia/Bangkok');

// Execute Python script with uploaded file path
$uploaded_file = $_FILES['file']['tmp_name'];
$python_script = "C:/xampp/htdocs/musichub-master/main.py";
shell_exec("python $python_script $uploaded_file $output_directory");

// Check if user is logged in
session_start();
if(isset($_SESSION['email'])) {
    // Connect to MySQL database
    $conn = new mysqli("localhost", "root", "", "musichub");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement to insert data into wavfile table
    $sql = "INSERT INTO wavfile (file_path, id_user, timestamp) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $file_path = $output_directory . '/' . basename($uploaded_file);
    $id_user = $_SESSION['id'];
    $timestamp = date("Y-m-d H:i:s"); // Get current timestamp
    $stmt->bind_param("sis", $file_path, $id_user, $timestamp);

    // Execute statement
    if ($stmt->execute()) {
        // Close statement
        $stmt->close();
        
        // Close connection
        $conn->close();
        
        // Send back the file path to the client
        echo $file_path;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "Error: User not logged in!";
}
?>
