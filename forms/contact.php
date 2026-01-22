<?php

  // Only allow POST
  if ($_SERVER["REQUEST_METHOD"] !== "POST") {
      http_response_code(403);
      echo "Forbidden";
      exit;
  }

  // Sanitize inputs
  $name    = strip_tags(trim($_POST["name"] ?? ''));
  $email   = filter_var($_POST["email"] ?? '', FILTER_SANITIZE_EMAIL);
  $subject = strip_tags(trim($_POST["subject"] ?? ''));
  $message = strip_tags(trim($_POST["message"] ?? ''));

  // Validate
  if (empty($name) || empty($subject) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
      http_response_code(400);
      echo "Please complete the form correctly.";
      exit;
  }

  // Email settings
  $to = "sales@pearlcon.com";   // Receiver email
  $from = "no-reply@pearlcon.com"; 
  $email_subject = "New Website Enquiry: $subject";

  // Email body
  $email_body = "
  You have received a new enquiry from the website.

  Name: $name
  Email: $email
  Subject: $subject

  Message:
  $message
  ";

  // Headers
  $headers = "From: Pearlcon Website <$from>\r\n";
  $headers .= "Reply-To: $email\r\n";
  $headers .= "Content-Type: text/plain; charset=UTF-8";

  // Send mail
  if (mail($to, $email_subject, $email_body, $headers)) {
      echo "OK";
  } else {
      http_response_code(500);
      echo "Mail could not be sent.";
  }

  // $receiving_email_address = 'contact@example.com';

  // if( file_exists($php_email_form = '../assets/vendor/php-email-form/php-email-form.php' )) {
  //   include( $php_email_form );
  // } else {
  //   die( 'Unable to load the "PHP Email Form" Library!');
  // }

  // $contact = new PHP_Email_Form;
  // $contact->ajax = true;
  
  // $contact->to = $receiving_email_address;
  // $contact->from_name = $_POST['name'];
  // $contact->from_email = $_POST['email'];
  // $contact->subject = $_POST['subject'];
  // $contact->add_message( $_POST['name'], 'From');
  // $contact->add_message( $_POST['email'], 'Email');
  // isset($_POST['phone']) && $contact->add_message($_POST['phone'], 'Phone');
  // $contact->add_message( $_POST['message'], 'Message', 10);

  // echo $contact->send();
?>
