<?php

require_once("core/httprequests/Httprequests.php");
    // Sending the contact us email
    include('include_fr/header.php');
    include('include_fr/topnav.php');

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

            ?> 
                <script>
                    Swal.fire(
                        "Cher <?=$name?>",
                        "Merci de nous avoir contactés. Nous reviendrons vers vous dans les plus brefs délais",
                        "success"
                    );
                </script>
            
<?php


        } else{
            // Data validation
        }

        
        
    }





include('include_fr/section/service.php');
include('include_fr/section/mineral.php');
include('include_fr/section/about.php');
include('include_fr/section/diligence.php');
include('include_fr/section/team.php');
include('include_fr/section/contact.php');
include('include_fr/footer.php');
include('include_fr/js.php');

?>

<script>

    $(document).ready(function(){
        new WOW().init();
    });
</script>