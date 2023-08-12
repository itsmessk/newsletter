<?php
    $email = $_POST['email'];

    $dbc = mysqli_connect('localhost', 'root', '', 'email')
        or die('Couldn\'t connect to the database');
    
    $query = "INSERT INTO email_list( email) " .
        "VALUES('$email')";

    $result = mysqli_query($dbc, $query) 
        or die("Couldn't query the database");

    echo 'Customer successfully added to the database';

    mysqli_close($dbc);
?>
