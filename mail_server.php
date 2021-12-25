


<?php

// define('SITE_KEY', '6LebC4YUAAAAAOrNz0c1CGPUU3wl3lH3ZqCjnur3');

// define('SECRET_KEY', '6LebC4YUAAAAACudHW8SRk9XDIPs59hlLUOtLddO');

// define('SITE_KEY', '6LdmOvoZAAAAAKUCJsdxeCXPHLxWp-uPVUNKVADK');
// define('SECRET_KEY', '6LdmOvoZAAAAACyFgyf1gDwBmbaoz9wRSCCkqTwo');

// if($_POST){
//     function getCaptcha($SecretKey){
//         $Response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".SECRET_KEY."&response={$SecretKey}");
//         $Return = json_decode($Response);
//         return $Return;
//     }
//     $Return = getCaptcha($_POST['g-recaptcha-response']);
//     //var_dump($Return);
//     if($Return->success == true && $Return->score > 0.5){
//         echo "<h1>Succes!</h1>";
//     }else{
//         echo "You are a Robot!!";
//     }
// }
?>


<?php

	define('SECRET_KEY', '6LdmOvoZAAAAACyFgyf1gDwBmbaoz9wRSCCkqTwo');

	if(isset($_POST['submit'])){

		function getCaptcha($SecretKey){
			$Response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".SECRET_KEY."&response={$SecretKey}");
			$Return = json_decode($Response);
			return $Return;
		}

		$Return = getCaptcha($_POST['g-recaptcha-response']);
		//var_dump($Return);
		
		

		$name=$_POST['name'];
		$email=$_POST['email'];
		$mobile=$_POST['mobile'];
		$msg=$_POST['umessage'];

		$to='webindianlion@gmail.com'; // Receiver Email ID, Replace with your email ID

		$subject='Inwebservice Query';
		$message="Name :".$name."\n"."Mobile :".$mobile."\n\n"."Query :".$msg;
		$headers="Inwebservice Query From: ".$email;


		if($Return->success == true && $Return->score > 0.5){
			// echo "<h1>Succes!</h1>";
			mail($to, $subject, $message, $headers);
			echo "<h1>Sent Successfully! Thank you"." ".$name.", We will contact you shortly!</h1>";
			header('Refresh: 5; URL=https://inwebservice.com/');		

		}else{
			echo "You are a Robot!!";
		}

		
	}
?>
