<?php

	// define('SECRET_KEY', '6LdmOvoZAAAAACyFgyf1gDwBmbaoz9wRSCCkqTwo');

	if(isset($_POST['submit'])){

		// function getCaptcha($SecretKey){
		// 	$Response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".SECRET_KEY."&response={$SecretKey}");
		// 	$Return = json_decode($Response);
		// 	return $Return;
		// }

		// $Return = getCaptcha($_POST['g-recaptcha-response']);			

		$name=$_POST['uname'];
		$email=$_POST['uemail'];
		$mobile=$_POST['uphone'];
		$msg=$_POST['umessage'];

		$to='webindianlion@gmail.com, roopitonline@gmail.com'; // Receiver Email ID, Replace with your email ID

		$subject='Nandan Kids Query';
		$message="Name :".$name."\n"."Mobile :".$mobile."\n\n"."Query :".$msg;
		$headers="Nandan Kids Query From: ".$email;

		if(mail($to, $subject, $message, $headers)){
			// echo "<h1>Succes!</h1>";
			// mail($to, $subject, $message, $headers);
			echo "<h1>Sent Successfully! Thank you"." ".$name.", We will contact you shortly!</h1>";
			header('Refresh: 5; URL=https://inwebservice.com/nandankids/');		

		}else{
			echo "You are a Robot!!";
		}		
	}
?>
