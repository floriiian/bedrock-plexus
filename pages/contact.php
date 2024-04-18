<?php
session_start();
require('navbar.php');
require("../Servers.php");
global $conn;
?>
<html lang="en">
<head>
    <link rel="stylesheet" href="../scripts/style.css" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title id="title">BedrockPlexus | Welcome</title>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
</head>
<body>
<div class = "start_text">
    <h1 class="title" style="font-size:60px;">Contact Us</h1>
    <div class="info-text">
        <p style="font-size:20px;">Have any questions or other regards? Feel free to contact us here.</p>
    </div>
</div>
<form class="contact_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
    <label>
        <input name="cf_name" type="text" class="feedback-input" placeholder="Name" style="width: 600px;"/>
    </label>
    <label>
        <input name="cf_email" type="text" class="feedback-input" placeholder="Email" style="width: 600px";/>
    </label>
    <label>
        <textarea name="cf_text" class="feedback-input" placeholder="Comment" style="width: 600px;"></textarea>
    </label>
    <input  type="submit"  class="feedback_submit" value="Submit" style="width: 600px;"/>
</form>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["cf_name"];
    $email = $_POST["cf_email"];
    $message = $_POST["cf_text"];

    if($name)
        if (strlen($name) < 100)
        {
            if(filter_var($email,FILTER_VALIDATE_EMAIL) && strlen($email) < 320)
            {
                if(strlen($message) > 30)
                {
                    echo '<div class="server"><h1 style="font-size:20px; text-align: center">Submitted! Thank you for  contacting us.</h1></div><br>';
                }
                else
                {
                    echo '<div class="server"><h1 style="font-size:20px; text-align: center">Please be more exact. (Enter at least 30 Characters).</h1></div><br>';
                }
            }
            else
            {
                echo '<div class="server"><h1 style="font-size:20px; text-align: center">Invalid Email</h1></div><br>';
            }
        }
    else
    {
        echo '<div class="server"><h1 style="font-size:20px; text-align: center">Invalid Name</h1></div><br>';
    }
}
?>

