<?php
    require_once("core/httprequests/Httprequests.php");
    // Sending the contact us email

    if(isset($_POST['contactus'])){
        $name=$_POST['name'];
        $email=$_POST['email'];
        $message=htmlspecialchars($_POST['message']);
        $phone=$_POST['phone'];

       
        if(trim($name)!="" || trim($email)!="" || trim($message)!="" || trim($phone)!=""){
            
            $emailData=array(
                "sendmail"=>"true",
                "message"=>$message,
                "phone"=>$phone,
                "name"=>$name,
                "email"=>$email
            );
    
            $url="http://172.20.10.3:81/congojx/core/mail/mails/gmail.php";
    
            Httprequests::curl_post_async($url, $emailData);

        } else{
            // Data validation
        }

        
        
    }




    include('include/header.php');
    include('include/topnav.php');
    include('include/section/service.php');
    include('include/section/mineral.php');
    include('include/section/about.php');
    include('include/section/diligence.php');
    include('include/section/team.php');
    include('include/section/contact.php');
    include('include/footer.php');
    include('include/js.php');

?>


<script>

$(document).ready(function(){
    new WOW().init();
});
</script>