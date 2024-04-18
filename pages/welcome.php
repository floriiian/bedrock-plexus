<?php
session_start();
require('navbar.php');
require("../Servers.php");
global $conn;
?>
<html lang="en">
<head>
    <!-- CSS -->
    <link rel="stylesheet" href="../scripts/style.css" />
    <!-- Icons CSS -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title id="title">BedrockPlexus | Welcome</title>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>
        function getRandomWelcome() {
            const welcome_texts = [
                "BedrockPlexus | Whats up!  ",
                "BedrockPlexus | Good Day!  ",
                "BedrockPlexus | Welcome!  ",
            ];
            return welcome_texts[Math.floor(Math.random() * welcome_texts.length)];
        }
        const welcomeTextElement = document.getElementById("title");
        welcomeTextElement.textContent = getRandomWelcome();
    </script>
</head>
<body>
<div class = "start_text">
<h1 class="title" style="font-size:60px;">Bedrock Plexus</h1>
    <div class="info-text">
        <p style="font-size:20px;">High Quality Minecraft Bedrock Server list</p>
        <br>
    </div>
</div>
<br>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
    <div class="input-box">
        <i style="color: #443768;" class="uil uil-search"></i>
        <label>
            <input name= "search" type="text" placeholder="Search for a server.." />
        </label>
        <button class="button">Search</button>
    </div>
    <br>
    <div>
        <h2 class="title2" style="font-size:30px;">
            <span class="changing_text">No more </span>
        </h2
    </div>
</form>

<div class="card_container">
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        # Prepare SQL Query
        $sql = "SELECT name,address,description FROM servers";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        # Check if username exists in database
        if ($stmt->rowCount() === 0) {
            # echo "No servers found"
            echo("There is no servers yet, be the first one!");
        }
        else{
            $servers = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $servers[] = $row; // Add each row to the servers array
            }

            $server_count = count($servers, COUNT_RECURSIVE);
            foreach($servers as $server) {
                $server_info = Servers::getServers($server['address']);
                $player_count = $server_info[0];
                $max_player_count = $server_info[1];
                $server_version = $server_info[2];
                echo("<div class='card'>
        <h3>" . $server["name"] . "</h3><p>" . $server["description"] . "</p><br><p>IP: " . $server["address"] ."</p><p>" . "Players: $player_count / $max_player_count" . "</p><p>" . "Version: $server_version" . "</p></div>");
            }
        }
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $user_query = $_POST["search"];
        if(!(empty($user_query)))
        {
            $sql = "SELECT name,address,description FROM servers WHERE name LIKE ? OR address LIKE ?";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(1, $user_query);
            $stmt->bindParam(2, $user_query);
            $stmt->execute();
            # Check if username exists in database
            if ($stmt->rowCount() === 0)
            {
                echo("<p style='font-size:20px;'>Sorry we can't find that server. If you are the owner you can add it <a class='hyperlink' href='add_server.php'>here</a>!</p>");
            }
            else{
                $servers = [];
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
                {
                    $servers[] = $row; // Add each row to the servers array
                }

                $server_count = count($servers, COUNT_RECURSIVE);
                foreach($servers as $server)
                {
                    $server_info = Servers::getServers($server['address']);
                    $player_count = $server_info[0];
                    $max_player_count = $server_info[1];
                    $server_version = $server_info[2];
                    echo("<div class='card'><h3>" . $server["name"] . "</h3><p>" . $server["description"] . "</p><br><p>IP :" . $server["address"] ."</p><p>" . "Players: $player_count / $max_player_count" . "</p><p>" . "Version: $server_version" . "</p></div>");
                }
            }
        }
    } ?>
</div>

</body>
</html>

