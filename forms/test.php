<?php
    echo "<pre>";

    print_r($_POST);

    
    //get data from form  
    $name = $_POST['name'];
    $email= $_POST['email'];
    $subject= $_POST['subject'];
    $message= $_POST['message'];

    $to = "awekayodeemmanuel@gmail.com";
    $subject = "Mail From website";
    $txt ="Name = ". $name . "\r\n  Email = " . $email . "\r\n Message =" . $message;
    $headers = "From: noreply@sbpblockchain.com" . "\r\n" .
    "CC: somebodyelse@example.com";
    if($email!=NULL){
        mail($to,$subject,$txt,$headers);
    }
    //redirect
    header("Location:thankyou.html");
   

    echo "<pre>";
?>