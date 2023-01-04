<?php

$errors = array('email_used' => '', 'email_required' => '', 'database_error' => '');

$success_p ='';

$email = $_POST['email'];

if(!empty($email) || filter_var($email, FILTER_VALIDATE_EMAIL)){
    
    //$host = "localhost";
    //$dbUsername = "kayode";
    //$dbPassword = "test1234";
    //$dbname = "ninja_pizza";

    $host = "sql304.epizy.com";
    $dbUsername = "epiz_30153549";
    $dbPassword = "coQrXQQrURc5Wp";
    $dbname = "epiz_30153549_sbpblockchain";


    //create connection
    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

    if (mysqli_connect_error()){
        $errors['database_error'] = 'Unable to connect to database';
        die("Connect Error('mysqli_connect_error().')".mysqli_connect_error());
    }else {

        $email = mysqli_real_escape_string($conn, $_POST['email']);

        $SELECT = "SELECT email from polargrid where email = ? limit 1";
        $INSERT = "INSERT Into polargrid(email)values(?)";

        //prepare statement 
        $stmt = $conn->prepare($SELECT);
        $stmt -> bind_param("s",$email);
        $stmt -> execute();
        $stmt -> bind_result($email);
        $stmt -> store_result();
        $rnum = $stmt -> num_rows;

        if($rnum == 0){
            $stmt -> close();

            $stmt = $conn -> prepare($INSERT);
            $stmt -> bind_param("s",$email);
            $stmt -> execute();
            //echo "New record inserted successfully";
            $success_p ='Submitted';
        } else{
            //echo "Someone already registered using this email";
            $errors['email_used'] = 'Someone already registered using this email';
        }

        $stmt -> close();
        $conn -> close();
        
    }
}else{
    //echo "All fields are required";
    $errors['email_required'] = 'All fields are required';
    die();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Status</title>
    <link rel="stylesheet" href="../assets/css/style_3.css">
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
</head>
<body>
   <div class="container">

        <?php if($errors['email_used']=='Someone already registered using this email') {?>
            <div class="alert_email">
                <div class="sorry_msg">
                    <h2>Oops</h2>
                    <h4>Someone already Subscribed using this email</h4>
                </div>
                 <div class="link_back">
                 <a href="../index.html"> Return to Homepage</a>
                </div>
            </div>

        <?php } elseif($errors['email_required']=='All fields are required') {?>

            <div class="alert_email">

                    <h2>Submit your Email</h2>
                    <img src="../images/database.gif" alt="">
                    <div class="link_back">
                        <a href="../index.html"> Return to Homepage</a>
                    </div>
             </div>

        <?php } elseif($errors['database_error']=='Unable to connect to database'){?>

            <div class="alert_email">
                <h2>Unable to connect to database</h2>
                <img src="../images/database.gif" alt="">
                <div class="link_back">
                    <a href="../index.html"> Return to Homepage</a>
                </div>
            </div>
        <?php } elseif($success_p =='Submitted'){?>
            <div class="alert_email">
                <div class="Submitted_msg">
                    <h2>Congratulation</h2>
                    <h4>Your Email has been submitted</h4>
                </div>
                <img src="../images/animation_successful.gif" alt="">
                <div class="link_back">
                    <a href="../index.html"> Return to Homepage</a>
                </div>
            </div>
        <?php } else{?>

         <?php } ?>
            

    </div>
    
</body>
</html>