<?php
session_start();
ob_start();
global $conn;
require("../Servers.php");
require("../db/connect.php");
require('navbar.php');
if(!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === false){
    header("location: login.php");
    exit;
}
?>
<html lang="en">
<head>
    <link rel="stylesheet" href="../scripts/style.css" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>BedrockPlexus | Add Server</title>
</head>
<body>
<div class="start_text">
    <br>
    <h1 class="title" style="font-size:50px;">Add your Server</h1>
    <div class="welcome-text">
        <br>
    </div>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
        <div class="input-box">
            <i class="uil uil-tag"></i>
            <label>
                <input name= "server_name" type="text" placeholder="Server-Name (Max 22 Characters)" />
            </label>
        </div>
        <div style="margin: 10px 0;"></div>
        <div class="input-box">
            <i class="uil uil-server"></i>
            <label>
                <input name= "server_domain" type="text" placeholder="Server-Domain"/>
            </label>
        </div>
        <div style="margin: 10px 0;"></div>
        <div class="input-box">
            <i class="uil uil-pen"></i>
            <label>
                <input name= "server_description" type="text" placeholder="Server-Description (Max 50 Characters)" />
            </label>
        </div>
        <div class="add_server_div">
            <button style="align-content: center" class="standard_button">Add Server</button>
        </div>
    </form>
    <div class="info-text">
        <br>
        <h1 style="font-size:35px;">Can't add your server?</h1>
        <p style="font-size:20px;">Contact our support <a class="hyperlink" href="mailto:bedrockplexus@gmail.com?subject=I can't add my server&body=Message">here</a>.</p>
        <br>
    </div>
    <br>
</div>
<script>
    document.getElementById("registerForm").addEventListener("submit", function(event) {
        event.preventDefault();
    }
</script>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $server_name = $_POST["server_name"];
    $server_domain =  $_POST["server_domain"];
    $server_description = $_POST["server_description"];
    if (!empty($_SESSION["id"]))
    {
        if(!empty($server_name) && !empty($server_domain) && !empty($server_description))
        {
            switch(Servers::addServer($server_name, $server_domain, $server_description))
            {
                case 1:
                    echo '<div class="server"><h1 style="font-size:20px; text-align: center">Your Server has been added!</h1></div>';
                    break;
                case -1:
                    echo '<div class="server"><h1 style="font-size:20px; text-align: center">Invalid Server-name or Description .</h1></div><br>';
                    break;
                case -2:
                    echo '<div class="server"><h1 style="font-size:20px; text-align: center">Invalid Server-Domain.</h1></div>';
                    break;
                case -3:
                    echo '<div class="server"><h1 style="font-size:20px; text-align: center">Server already exists.</h1></div>';
                    break;
                default:
                    echo '<div class="server"><h1 style="font-size:20px; text-align: center">Internal Server Error</h1></div><br>';
                    break;
            }
        }
        else
        {
            echo '<div class="server"><h1 style="font-size:20px; text-align: center">Some values are empty.</h1></div><br>';
        }
    }
    else
    {
        echo '<div class="server"><h1 style="font-size:20px; text-align: center">Please <a class="hyperlink" href="login.php">log in</a> to add a server.</h1></div><br>';
    }
}
?>



</body>
</html>

