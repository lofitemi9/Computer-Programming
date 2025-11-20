<?php
class User{
    private $db;
    public function __construct($db_connection){
        $this->db = $db_connection;
    }

    /**
     * Finds a user by their username
     * @param string $username
     * @return mixed
     */

    public function findUserByUsername($username){
        try{
            $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
            $stmt->execute();
            return $stmt->fetch();
        } catch(PDOException $e){
            return false;
        }
    }

    /**
     * Registers a new user
     * @param string $username
     * @param string $password
     * @param string $confirm_password
     * @return string success or error message
     */ 

    public function register($username, $password, $confirm_password){
        if(empty($username) || empty($password) || empty($confirm_password)){
            return "All fields are required.";
        }
        // confirm password
        if($password !== $confirm_password){
            return "Passwords do not match.";
        }
        // check if user already exists
        if($this->findUserByUsername($username)){
            return "Username already taken.";
        }
        // hash the password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        // now our CREATE method
        try{
            $stmt = $this->db->prepare("INSERT INTO users (username, password) VALUES(?, ?)");
            $stmt->execute([$username, $hashed_password]);
            return "User Created";
        } catch(PDOException $e){
            return "Registration failed: " . $e->getMessage();
        }
    }


    /**
     * Logs in a user
     * @param string $username
     * @param string $password
     * @return string success or error message
     */

    /**
     * Logs in a user
     * @param string $username
     * @param string $password
     * @return mixed user data array on success, false on failure
     */

    public function login($username, $password){
        if(empty($username) || empty($password)){
            return false;
        }
        $user = $this->findUserByUsername($username);
        if($user && password_verify($password, $user['password'])){
            // password is correct
            return $user;
        }else{
            // invalid credentials
            return false;
        }
    }
}
?>