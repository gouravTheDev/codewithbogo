<?php
echo "asdfnj";
// include '././CONFIG/config.php';
// Check for empty fields
$link = new mysqli('localhost','codewit2_BOGO','smileplz@1234','codewit2_BOGO');
$link->set_charset("utf8");
if(mysqli_connect_error()){
   die("ERROR: UNABLE TO CONNECT: ".mysqli_connect_error());
}

if(empty($_POST['name']) || empty($_POST['email']) || empty($_POST['phone']) || empty($_POST['message']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
  http_response_code(500);
  exit();
}

$name = strip_tags(htmlspecialchars($_POST['name']));
$email = strip_tags(htmlspecialchars($_POST['email']));
$phone = strip_tags(htmlspecialchars($_POST['phone']));
$message = strip_tags(htmlspecialchars($_POST['message']));

$currDate = date("Y-m-d h:i:sa");

$stmt = $link->prepare("INSERT INTO CONTACT (`NAME`, `EMAIL`, `PHONE`, `MESSAGE`, `DATE`)VALUES(?, ?, ?, ?, ?)");

$stmt->bind_param("sssss", $name, $email, $phone, $message, $currdate);

$result = $stmt->execute();
if ($result) {
	echo "<script>console.log('It done!')</script>";
}else{
	echo "<script>console.log('It not done!')</script>";
}

// Create the email and send the message
$to = "chatterjeegouravking@gmail.com"; // Add your email address inbetween the "" replacing yourname@yourdomain.com - This is where the form will send a message to.
$subject = "Website Contact Form:  $name";
$body = "You have received a new message from your website contact form.\n\n"."Here are the details:\n\nName: $name\n\nEmail: $email\n\nPhone: $phone\n\nMessage:\n$message";
$header = "From: noreply@codewithbogo.in\n"; // This is the email address the generated message will be from. We recommend using something like noreply@yourdomain.com.
$header .= "Reply-To: $email";	
// echo "asdadbg";

if(!mail($to, $subject, $body, $header))
  http_response_code(500);
?>
