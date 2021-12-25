<?php 
$host="localhost:3306";
$user="root";
$password="";
$db="inwebservice";

$cname=$_POST['cname'];
$email=$_POST['email'];
$mobile=$_POST['mobile'];

$conn = new mysqli($host,$user,$password,$db);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }
  
  else {

  }
  $sql = "INSERT INTO contact (cname, email, mobile) VALUES ('$cname', '$email', '$mobile')";

  if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
  $conn->close();
  // header( "refresh:2; url=contact.php" );

?>




<!DOCTYPE html>
<html>
<?php include './common/head.php' ?>
<body>
    <?php include './common/topmenu.php' ?>
    <div class="containerr videoContainer"> <br><br><br><br><br><br><br>
        <h1 class="successMessage">We will connect you soon</h1>       
    </div>


</body>
</html>


<?php

if(isset($_POST['submit']))
{

function CheckCaptcha($userResponse) {
        $fields_string = '';
        $fields = array(
            'secret' => 6LfMz2EUAAAAAF5VwFWDGRfsyj6Ik0ngJrhHKK3w
            'response' => $userResponse
        );
        foreach($fields as $key=>$value)
        $fields_string .= $key . '=' . $value . '&';
        $fields_string = rtrim($fields_string, '&');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, True);

        $res = curl_exec($ch);
        curl_close($ch);

        return json_decode($res, true);
    }


    // Call the function CheckCaptcha
    $result = CheckCaptcha($_POST['g-recaptcha-response']);

    if ($result['success']) {
        //If the user has checked the Captcha box
        echo "Captcha verified Successfully";
	
    } else {
        // If the CAPTCHA box wasn't checked
       echo '<script>alert("Error Message");</script>';
    }
}
    ?>