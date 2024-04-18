<?php
require("db/connect.php");
class Login
{
    # Check if username exists in database
    # Check if username matches the password to the database username

    public static function checkPass($username, $password) : bool {
        global $conn;
        if (strlen($username) > 64 || strlen($password) > 128 || !preg_match("/[a-z0-9]+/i", $username)) {
            # echo("[!] Username is too long, Password too long, Username invalid");
            return false;
        }
        # Prepare SQL Query
        $sql = "SELECT username,password FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $username, PDO::PARAM_STR);
        $stmt->execute();


        // Fetch user data (if existing)
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (empty($row["username"]) || empty($row["password"])) {
            return false;
        }
        if(!password_verify($password, $row["password"])){
            # echo "[!] Password Incorrect";
            return false;
        };

        return true;
    }

    public static function getID($username) : int {
        global $conn;

        $sql = "SELECT UserId FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $username, PDO::PARAM_STR);
        $stmt->execute();

        if(!$stmt->rowCount() == 0){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row["UserId"];
        }
        return -1;
    }
}
