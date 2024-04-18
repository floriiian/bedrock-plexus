<link rel="stylesheet" href="../scripts/navbar.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/3.0.3/normalize.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.2.3/animate.css">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script>
    function resizeNav() {
        // Set the nav height to fill the window
        $("#nav-fullscreen").css({"height": window.innerHeight});

        // Set the circle radius to the length of the window diagonal,
        // this way we're only making the circle as big as it needs to be.
        var radius = Math.sqrt(Math.pow(window.innerHeight, 2) + Math.pow(window.innerWidth, 2));
        var diameter = radius * 2;
        $("#nav-overlay").width(diameter);
        $("#nav-overlay").height(diameter);
        $("#nav-overlay").css({"margin-top": -radius, "margin-left": -radius});
    }
    // Set up click and window resize callbacks, then init the nav.
    $(document).ready(function() {
        $("#nav-toggle").click(function() {
            $("body, #nav-toggle, #nav-overlay, #nav-fullscreen").toggleClass("open"); // Add body to the toggle list
        });

        $(window).resize(resizeNav);

        resizeNav();

        // window.setTimeout(function() {
        //     $("#nav-toggle").click();
        // }, 1000);
    });
</script>

<div id="nav-container">
    <div id="nav-overlay"></div>
    <nav id="nav-fullscreen">
        <ul>
            <li><a href="welcome.php">Browse Servers</a></li>
            <?php if (!empty($_SESSION["id"])) {
            echo '<li><a href="add_server.php">Add your Server</a></li>';
            } ?>
            <li><a href="contact.php">Contact us</a></li>
            <?php
            if(empty($_SESSION["id"])){
                echo "<li><a href='login.php'>Login</a></li>";
            }
            if (!empty($_SESSION["id"])) {
                echo "    <form action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='POST'><li><button type='submit' name='logout' class='logout_button'>Logout</button></li></form>";
            }
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                if(isset($_POST['logout']) && !empty($_SESSION["id"]) && !empty($_SESSION["username"]) && $_SESSION["loggedin"]){
                    $_SESSION["loggedin"] = false;
                    $_SESSION["id"] = Null;
                    $_SESSION["username"] = Null;
                    header("location: login.php");
                    exit;
                }
            }
            ?>
        </ul>
    </nav>


    <a id="nav-toggle">
        <span></span>
        <span></span>
        <span></span>
    </a>
</div>