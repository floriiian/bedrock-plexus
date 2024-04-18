<?php
require("db/connect.php");
class Register
{
    static public function check_username($username): bool
    {
        global $conn;
        if (strlen($username) > 64) {
            # echo("[!] Username is too long! (Max 64 Characters)");
            return false;
        }
        if (!preg_match("/[a-z0-9]+/i", $username)){
            # echo("[!] Username has invalid characters!");
            return false;
        }
            # Prepare SQL Query
            $sql = "SELECT username FROM users WHERE username = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(1, $username, PDO::PARAM_STR);
            $stmt->execute();
            # Check if username exists in database
            if ($stmt->rowCount() > 0) {
                # echo("[!] Username already exists!");
                return false;
            }
                 # echo "[!] Username does not exist, " . '"' . "$username" . '"' . " is valid.";
                return true;
        }

    static public function check_email ($email) : bool
    {
        global $conn;
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            # echo("[!] Email is not valid!");
            return false;
        }
        if(strlen($email) > 320){
            # echo("[!] Email is not valid! (Max 320 Characters)");
            return false;
        }
        # Prepare SQL Query
        $sql = "SELECT email FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $email, PDO::PARAM_STR);
        $stmt->execute();
        # Check if username exists in database
        if ($stmt->rowCount() > 0) {
            # echo("[!] Username already exists!");
            return false;
        }
        # echo "[!] Username does not exist, " . '"' . "$email" . '"' . " is valid.";
        return true;
    }


    static public function check_password($password) : bool {

        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number    = preg_match('@[0-9]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);

        if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8 || strlen($password) > 128) {
          # echo '[!] Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.';
            return false;
        }
        else{
            return true;
        }
    }
    static public function add_user($username, $email, $password): bool{
        global $conn;
        $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 15));
        # Prepare SQL Query
        $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
        if($conn->query($sql)){
           # echo "[!] User added.";
            return true;
        }
        else{
            echo("Error: " . $sql . "<br>" . $conn->error);
            return false;
        }
    }
}

