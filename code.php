<?php
session_start();
include('dbcon.php');

// Load Composer's autoloader for PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Function to send verification email
function sendemail_verify($name, $email, $verify_token){
    $mail = new PHPMailer(true);
    
    try {
        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'manoranjaninproject@gmail.com';        //Your Gmail address
        $mail->Password   = 'grzrfaffrwngabwz';                     //Your Gmail app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to

        //Recipients
        $mail->setFrom('manoranjaninproject@gmail.com', 'Manoranjan');
        $mail->addAddress($email);                                  //Add the recipient

        //Content
        $mail->isHTML(true);                                        //Set email format to HTML
        $mail->Subject = 'Email Verification for Manoranjan';
        $email_template = "
            <h2>Hello $name,</h2>
            <h5>Thank you for registering with Manoranjan. Please verify your email address using the link below:</h5>
            <br/>
            <a href='http://localhost/projectsocialmedia/verify-email.php?token=$verify_token'>Click here to verify your email</a>
        ";

        $mail->Body = $email_template;
        $mail->send();
    } catch (Exception $e) {
        // Log or handle the error here if needed
    }
}

if(isset($_POST['register_btn'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];  // Plain text password

    // Generate verification token
    $verify_token = md5(rand());

    // Check if email already exists
    $check_email_query = "SELECT email FROM users WHERE email='$email'";
    $check_email_query_run = mysqli_query($con, $check_email_query);

    if(mysqli_num_rows($check_email_query_run) > 0) {
        $_SESSION['status'] = "Email ID already exists";
        header("Location: register.php");
    } else {
        // Insert the registered user's data (without hashing the password)
        $query = "INSERT INTO users (name, phone, email, password, verify_token) 
                  VALUES ('$name', '$phone', '$email', '$password', '$verify_token')";  // Using plain text password
        $query_run = mysqli_query($con, $query);

        if($query_run) {
            // Send verification email
            sendemail_verify($name, $email, $verify_token);
            $_SESSION['status'] = "Registration succeeded! Please verify your email address.";
            header("Location: register.php");
        } else {
            $_SESSION['status'] = "Registration failed";
            header("Location: register.php");
        }
    }
}
?>
