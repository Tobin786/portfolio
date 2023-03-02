<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require '../mail/src/PHPMailer.php';
require '../mail/src/SMTP.php';
require '../mail/src/Exception.php';

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  
  $name = $_POST["name"];
  $email = $_POST["email"];
  $subject = $_POST["subject"];
  $message = $_POST["message"];
  $body = "<h2>New message from your website</h2>";
  $body .= "<p><strong>Name:</strong> " . $name . "</p>";
  $body .= "<p><strong>Email:</strong> " . $email . "</p>";
  $body .= "<p><strong>Subject:</strong> " . $subject . "</p>";
  $body .= "<p><strong>Message:</strong><br>" . nl2br($message) . "</p>";
  
  // Instantiate PHPMailer
  $mail = new PHPMailer();

  // Set mailer to use SMTP
  $mail->isSMTP();
  try{
  // Enable SMTP debugging
  // 0 = off (for production use)
  // 1 = client messages
  // 2 = client and server messages
  $mail->SMTPDebug = 0;  
  $mail->Mailer='smtp';                                      
  $mail->isSMTP();                                             
  $mail->Host       = 'smtp.gmail.com';                     
  $mail->SMTPAuth   = true;                              
  $mail->Username   = 'youremail@gmail.com';                  
  $mail->Password   = 'yourpass';                         
  $mail->SMTPSecure = 'tls';                               
  $mail->Port       = '587';   
  $mail->IsHTML(TRUE);
  $mail->setFrom($email, $name);
  $mail->addAddress('youremail@gmail.com');

  // Set email subject and message body
  $mail->Subject = "Email: ".$email." ".$subject;
  $mail->Body    = $body;

  // Send the email and check for errors
  if (!$mail->send()) {
    http_response_code(500);
      echo "Mailer Error: " . $mail->ErrorInfo;
  } else {
    http_response_code(200);
      echo "OK";
  }
}catch (Exception $e) { 
  //echo "<script>alert('I am here');</script";
  http_response_code(403);
  error_log("Error message: " . error_get_last(), 0);

  echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"; 
} 
}
?>
