<?php 

include("connection.php");

require("mail/SMTP.php");
require("mail/PHPMailer.php");
require("mail/Exception.php");

use PHPMailer\PHPMailer\PHPMailer;

if(isset(($_POST["e"]))){
    $email = $_POST["e"];

    $admin_rs = Database::search("SELECT * FROM `admin` WHERE `email` = '".$email."'");
    $admin_num = $admin_rs->num_rows;

    if($admin_num == 1){

        $admin_data = $admin_rs->fetch_assoc();

        $code = uniqid();
        Database::iud("UPDATE `admin` SET `vcode` = '".$code."' WHERE `email` = '".$email."'");

        try {
            //Server settings
            $mail = new PHPMailer;
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'personal.charuka@gmail.com';                     //SMTP username
            $mail->Password   = 'qeqhzlsfbhuccmcu';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('personal.charuka@gmail.com', 'Reset paasword');
            $mail->addAddress($email);     //Add a recipient

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'eShop forgot password verification code';
            $bodyContent = '<h1 style="color:red">Your verification code is ' . $code . '</h1>';
            $mail->Body    = $bodyContent;


            $mail->send();
            echo "success";
        } catch (Exception $e) {
            echo "Verification Code Sending Faild. Mailer Error: {$mail->ErrorInfo}";
        }


    }else{
        echo "invalid user!";
    }

}else{
    echo "please insert your email";
}

?>