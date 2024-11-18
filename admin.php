<?php
require("cntdb.php");
$page_title = "Admin Panel";
include('includes/header.php');
include('includes/navbar.php');
include('includes/footer.php');
?>

<div class="content" style="margin-top: 0;"> <!-- Changed margin-top to 0 -->
    <section class="contact">
        <div class="content">
            <h2 style="color: #333;">Admin Login</h2> <!-- Ensured heading color is visible -->
            <hr>
            <p style="font-family: Poppins, sans-serif; font-weight: 600; ">
                Please enter your credentials to access the admin panel.
            </p>
        </div>

        
        <div class="container" style="font-family: Poppins, sans-serif; font-weight: 600;">
            <div class="contactForm">
                <form action="cntdb.php" method="POST" autocomplete="off">
                    <h2>Login</h2>
                    <div class="inputBox">
                        <input type="text" name="username" required="required">
                        <span>Admin Name</span>
                    </div>
                    <div class="inputBox">
                        <input type="password" name="password" required="required">
                        <span>Password</span>
                    </div>
                    <div class="inputBox">
                        <button type="submit">LOGIN</button>
                    </div>
                    <a href="forget-password.php" class="float-end">Forgot your password?</a>
                   
                </form>
            </div>
        </div>
    </section>

    <style>
        .contact {
            position: relative;
            min-height: 100vh;
            padding: 50px 150px; /* Keep this padding for side spacing */
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            background-size: cover;
            background-color: #f2f2f2; /* Added light background color for visibility */
        }

        .contact .content {
            max-width: 800px;
            text-align: center;
        }

        .contact .content h2 {
            font-size: 36px;
            font-weight: 500;
            color: #333; /* Ensure contrast with background */
        }

        .container {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 30px; /* Keep this for spacing between sections */
        }

        .contactForm {
            width: 40%;
            padding: 40px;
            background: #fff;
            border-radius: 10px; /* Rounded corners for the form */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
        }

        .contactForm h2 {
            font-size: 24px;
            color: #333;
            font-weight: 500;
        }

        .contactForm .inputBox {
            position: relative;
            width: 100%;
            margin-top: 10px;
        }

        .contactForm .inputBox input {
            width: 100%;
            padding: 5px 0;
            font-size: 16px;
            margin: 10px 0;
            border: none;
            border-bottom: 2px solid #333;
            outline: none;
        }

        .contactForm .inputBox span {
            position: absolute;
            left: 0;
            padding: 5px 0;
            font-size: 16px;
            margin: 10px 0;
            pointer-events: none;
            transition: 0.5s;
            color: #666;
        }

        .contactForm .inputBox input:focus ~ span,
        .contactForm .inputBox input:valid ~ span {
            color: #e91e63;
            font-size: 12px;
            transform: translateY(-20px);
        }

        .contactForm .inputBox button[type="submit"] {
            width: 100px;
            background: #e91e63;
            color: #fff;
            border: none;
            cursor: pointer;
            padding: 10px;
            font-size: 18px;
        }

        @media (max-width: 991px) {
            .contact {
                padding: 40px;
            }

            .container {
                flex-direction: column;
            }

            .contactForm {
                margin-bottom: 40px;
                width: 100%;
            }
        }
    </style>
</div>
