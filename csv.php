<?php
    // Database connection parameters
    
    // Create connection
    $conn = new mysqli('localhost', 'root', '', 'email');
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Query to retrieve email addresses
    $sql = "SELECT email FROM email_list"; // Update 'alumni' with your table name
    
    $result = $conn->query($sql);
    
    // Prepare CSV data
    $csvData = "Email\n"; // CSV header
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $email = $row["email"];
            $csvData .= "$email\n";
        }
        
        // Close the result set
        $result->close();
    }
    
    // Close the connection
    $conn->close();
    
    // Define the file name
    $filename = "alumni_emails.csv";
    
    // Set appropriate headers for download
    header('Content-Type: application/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    
    // Output the CSV data
    echo $csvData;
?>
