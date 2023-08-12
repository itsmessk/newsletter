<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

$host = 'your_db_host';
$db_user = 'your_db_user';
$db_pass = 'your_db_password';
$db_name = 'your_db_name';

$connection = new mysqli('localhost', 'root', '', 'email' );

if ($connection->connect_error) {
  die("Connection failed: " . $connection->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $subject = $_POST["subject"];
  $message = $_POST["message"];

  $query = "SELECT email FROM email_list";
  $result = $connection->query($query);

  $mail = new PHPMailer();

  $mail->isSMTP();
  $mail->Host = 'smtp-relay.brevo.com'; // Your SMTP server's hostname
  $mail->SMTPAuth = true;
  $mail->Username = ''; // Your SMTP username
  $mail->Password = ''; // Your SMTP password // Your SMTP password
  $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // or ENCRYPTION_SMTPS for SSL
  $mail->Port = 587; // or 465 for SSL

  while ($row = $result->fetch_assoc()) {
    $to = $row["email"];

    $mail->setFrom('alumni@panimalar.ac.in', 'Panimalar Alumni Association`');
    $mail->addAddress($to);
    $mail->Subject = $subject;
    $mail->Body = $message;

    if ($mail->send()) {
      echo "Email sent to: $to<br>";
    } else {
      echo "Error sending email to: $to<br>";
      echo "Error: " . $mail->ErrorInfo . "<br>";
    }

    $mail->clearAddresses();
  }

  $result->free();
}

$connection->close();
?>

<!DOCTYPE html>
<html>

<head>
  <title>Email Sending Form</title>
</head>

<body>
  <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <label for="subject">Subject:</label><br>
    <input type="text" id="subject" name="subject"><br>
    <label for="message">Message:</label><br>
    <textarea id="message" name="message" rows="4" cols="50"></textarea><br>
    <input type="submit" value="Send Emails">
  </form>
</body>

</html>