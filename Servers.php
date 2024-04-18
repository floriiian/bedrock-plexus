<?php
require("db/connect.php");
class Servers
{
    public static function getServers($server_domain): array
    {

        # Send request to API
        $url = "https://api.mcsrvstat.us/bedrock/3/$server_domain";
        // Configure CURL
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true, // Follow any redirects
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json", // Specify content type
            ],
            CURLOPT_SSL_VERIFYPEER => false,
        ]);
        // Execute the request
        $response = curl_exec($curl);
        // Check for errors
        if ($response === false) {
            echo "Error: " . curl_error($curl);
            return array("0", "0", "Unknown");
        } else {
            // Decode JSON response && save data.
            $data = json_decode($response, true);
            if (
                isset($data["players"]["online"], $data["players"]["max"], $data["version"])
            ) {
                // Extract player count
                $playerCount = $data["players"]["online"];
                $maxPlayerCount = $data["players"]["max"];
                $serverVersion = $data["version"];

                return [$playerCount, $maxPlayerCount, $serverVersion];
            } else {
                curl_close($curl);
                return array("0", "0", "Unknown");
            }
        }
    }

    # 1 = True
    # -1 == Server Name / Domain is invalid
    # -2 == Server Description invalid
    public static function addServer($server_name, $server_domain, $server_description) : int
    {
        global $conn;
        if (strlen($server_name) > 22 || !preg_match("/[a-z0-9]+/i", $server_name) || strlen($server_description) > 50) {
            # echo("[!] Server Name is too long, Description too long, Server Domain/Name invalid");
            return -1;
        }
        else if(!filter_var($server_domain, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME)){
        return -2;
        }

        # Check if server already exists in database
        $sql = "SELECT name,address,description FROM servers WHERE name LIKE ? OR address LIKE ?";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $server_name);
        $stmt->bindParam(2, $server_domain);
        $stmt->execute();
        if ($stmt->rowCount() === 0) {
            # Prepare SQL Query
            $sql = "INSERT INTO servers (name,address,description) VALUES  (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(1, $server_name, PDO::PARAM_STR);
            $stmt->bindParam(2, $server_domain, PDO::PARAM_STR);
            $stmt->bindParam(3, $server_description, PDO::PARAM_STR);
            $stmt->execute();
            return 1;
        }
        return -3;
        }
    }

