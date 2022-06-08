<?php

require_once('../config.php');
require_once('../class/users.php');
require_once('../class/qrCode.php');

class Database {
    protected $con;
    private $host;
    private $database;
    private $username;
    private $password;
 
    function __construct()
    {
        $this->host = DBHOST;
        $this->database = DBNAME;
        $this->username = DBUSER;
        $this->password = DBPASS;
        $this->createConnection();
    }
    
    private function createConnection(){
        try {
            $this->con = new mysqli($this->host, $this->username, $this->password, $this->database);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

class UserDatabase extends Database {
    function selectAllUsers(){
        $data = [];

        $sql = "SELECT * FROM users";
        $result = mysqli_query($this->con, $sql);

        //Check if result is not empty
        if (mysqli_num_rows($result) > 0) {
            $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
            return $data;
        } else {
            throw new Exception("No data for table");
            return false;
        }
        mysqli_close($this->con);

    }

    function selectUserById($id){
        $id = mysqli_real_escape_string($this->con, $id);
        $data = [];

        $sql = "SELECT * FROM users WHERE idusers = ".$id;
        $result = mysqli_query($this->con, $sql);

        //Check if result is not empty
        if (mysqli_num_rows($result) > 0) {
            $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
            return $data;
        } else {
            return false;
        }
        mysqli_close($this->con);

    }

    function loginUser($email, $pass){
        $email = mysqli_real_escape_string($this->con, $email);
        $pass = mysqli_real_escape_string($this->con,  $pass);
        $data = [];

        $sql = "SELECT * FROM users WHERE email = SHA('".$email."') AND password = SHA('".$pass."')";
        $result = mysqli_query($this->con, $sql);

        //Check if result is not empty
        if (mysqli_num_rows($result) > 0) {
            $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
            $user = new Users($data[0]['name'], $data[0]['email'], $data[0]['password'], $data[0]['token']);
            return $user->getUserToken();
        } else {
            return false;
        }
        mysqli_close($this->con);
    }

    function insertUser(Users $user){
        $name = mysqli_real_escape_string($this->con, $user->getName());
        $email = mysqli_real_escape_string($this->con, $user->getEmail());
        $pass = mysqli_real_escape_string($this->con,  $user->getPass());
        $token = mysqli_real_escape_string($this->con,  $user->getUserToken());

        $sql = "INSERT INTO users (name, email, password, token) VALUES (?, ?, SHA(?), ?)";
        $stmt = mysqli_stmt_init($this->con);

        if(!mysqli_stmt_prepare($stmt, $sql)) {
            return false;
        } else {
            mysqli_stmt_bind_param($stmt, 'ssss', $name, $email, $pass, $token);
            mysqli_stmt_execute($stmt);
            return true;
        }
        mysqli_close($this->con);

    }

    function updateUser($id, $column, $value){
        $id = mysqli_real_escape_string($this->con, $id);
        $column = mysqli_real_escape_string($this->con, $column);
        $value = mysqli_real_escape_string($this->con, $value);

        if ($column == 'password') {
            $sql = "UPDATE users SET ".$column." = SHA('".$value."') WHERE idusers = ".$id;
            mysqli_query($this->con, $sql);
        } else if($column == 'email' || $column == 'name') {
            $sql = "UPDATE users SET ".$column." = '".$value."' WHERE idusers = ".$id;
            mysqli_query($this->con, $sql);
        } else {
            exit('Column not found');
        }


        if (mysqli_affected_rows($this->con) > 0) {
            return true;
        } else {
            return false;
        }
        mysqli_close($this->con);

    }

    function deleteUser($id){
        $id = mysqli_real_escape_string($this->con, $id);
        $sql = "DELETE FROM users WHERE idusers = ".$id;
        mysqli_query($this->con, $sql);

        if (mysqli_affected_rows($this->con) > 0) {
            return true;
        } else {
            return false;
        }
        mysqli_close($this->con);
    }
}

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

class QrCodeDatabase extends Database {
    function selectAllQrCodes(){
        $data = [];

        $sql = "SELECT * FROM qrcode";
        $result = mysqli_query($this->con, $sql);

        //Check if result is not empty
        if (mysqli_num_rows($result) > 0) {
            $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
        } else {
            throw new Exception("No data for table");
        }

        mysqli_close($this->con);
        return $data;
    }

    function selectQrCodeById($id, $token){ //Need userToken
        $id = mysqli_real_escape_string($this->con, $id);
        $userToken = mysqli_real_escape_string($this->con, $token);
        $data = [];

        $sql = "SELECT * FROM qrcode WHERE idqrcode = ".$id;
        $result = mysqli_query($this->con, $sql);

        //Check if result is not empty
        if (mysqli_num_rows($result) > 0) {
            $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
        } else {
            throw new Exception("No data for table");
        }

        mysqli_close($this->con);
        return $data;
    }

    function selectQrCodeByUserToken($token){
        $userToken = mysqli_real_escape_string($this->con, $token);
        $data = [];

        $sql = "SELECT * FROM qrcode WHERE userToken = '".$userToken."'";
        $result = mysqli_query($this->con, $sql);

        //Check if result is not empty
        if (mysqli_num_rows($result) > 0) {
            $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
        } else {
            echo $sql;
            throw new Exception("No data for table");
        }

        mysqli_close($this->con);
        return $data;
    }

    function inserQrCode(QrCode $qrcode){
        $title = mysqli_real_escape_string($this->con, $qrcode->getTitle());
        $description = mysqli_real_escape_string($this->con, $qrcode->getDescription());
        $link = mysqli_real_escape_string($this->con,  $qrcode->getLink());
        $ref = mysqli_real_escape_string($this->con,  $qrcode->getRef());
        $userToken = mysqli_real_escape_string($this->con,  $qrcode->getUserToken());

        $userData = [];
        $sql = "SELECT * FROM users WHERE token = '".$userToken."'";
        $result = mysqli_query($this->con, $sql);

        //Check if result is not empty
        if (mysqli_num_rows($result) > 0) {
            $userData = mysqli_fetch_all($result, MYSQLI_ASSOC);
            if ($userData[0]['acess'] <= 2) {
                $sql = "INSERT INTO qrcode (title, description, link, reference, userToken) VALUES (?, ?, ?, ?, ?)";
                $stmt = mysqli_stmt_init($this->con);
        
                if(!mysqli_stmt_prepare($stmt, $sql)){
                    return false;
                } else {
                            mysqli_stmt_bind_param($stmt, 'sssss', $title, $description, $link, $ref, $userToken);
                mysqli_stmt_execute($stmt);
                return true;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
        mysqli_close($this->con);
    }

    function updateQrCode($id, $token, $column, $value){
        $id = mysqli_real_escape_string($this->con, $id);
        $token = mysqli_real_escape_string($this->con, $token);
        $column = mysqli_real_escape_string($this->con, $column);
        $value = mysqli_real_escape_string($this->con, $value);

        $userData = [];
        $sql = "SELECT * FROM users WHERE token = '".$token."'";
        $result = mysqli_query($this->con, $sql);

        if (mysqli_num_rows($result) > 0) {
            $userData = mysqli_fetch_all($result, MYSQLI_ASSOC);
            if ($userData[0]['acess'] <= 1) {
                if ($column == 'title' || $column == 'description' || $column == 'link') {
                    $sql = "UPDATE qrcode SET ".$column." = '".$value."' WHERE idqrcode = '".$id."' AND userToken = '".$token."'";
                    mysqli_query($this->con, $sql);
                } else {
                    exit('Column not found or not available to change');
                }

                if (mysqli_affected_rows($this->con) > 0) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
        mysqli_close($this->con);
}

    function deleteQrCode($id, $token){
        $id = mysqli_real_escape_string($this->con, $id);
        $token = mysqli_real_escape_string($this->con, $token);

        $userData = [];
        $sql = "SELECT * FROM users WHERE token = '".$token."'";
        $result = mysqli_query($this->con, $sql);

        if (mysqli_num_rows($result) > 0) {
            $userData = mysqli_fetch_all($result, MYSQLI_ASSOC);
            if ($userData[0]['acess'] == 0) {
                $sql = "DELETE FROM qrcode WHERE idqrcode = '".$id."' AND userToken = '".$token."'";
                mysqli_query($this->con, $sql);

                if (mysqli_affected_rows($this->con) > 0) {
                    return true;
                } else {
                    return false;
                }
            }                

        } else {
            return false;
        }
        mysqli_close($this->con);
    }

    function refQrCode($ref){
        $ref = mysqli_real_escape_string($this->con, $ref);
        $data = [];

        $sql = "SELECT * FROM qrcode WHERE reference = '".$ref."'";
        $result = mysqli_query($this->con, $sql);

        //Check if result is not empty
        if (mysqli_num_rows($result) > 0) {
            $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
        } else {
            echo $sql;
            throw new Exception("No data for table");
        }
        $qrCodeRef = new QrCode($data[0]['title'], $data[0]['link'], $data[0]['userToken'], $data[0]['ref'], $data[0]['description']);
        mysqli_close($this->con);
        return $qrCodeRef;
    }
}