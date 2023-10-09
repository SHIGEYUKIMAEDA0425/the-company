<?php

require_once "Database.php";

class User extends Database
{
    public function store($request)
    {
        $first_name = ucwords(strtolower($request['first_name']));
        // $_POST['first_name]
        $last_name = ucwords(strtolower($request['last_name']));
        $username = $request['username'];
        $password = password_hash($request['password'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO users(first_name, last_name, username, PASSWORD)
        VALUES ('$first_name', '$last_name', '$username', '$password')";

        if($this->conn->query($sql)){
            header('location: ../views'); //go to views/index.php
            exit;
        }else{
            die('Error creating new user: ' . $this->conn->error);
        }
    }

    public function login($request)
    {
        $username = $request['username'];
        $password = $request['password'];

        $sql = "SELECT * FROM users WHERE username = '$username'";

        $result = $this->conn->query($sql);

        if($result->num_rows == 1){
            $user = $result->fetch_assoc();

            /*
            $username = "spidey"
            $user = [
                'id' => 'Peter',
                'first_name' => 'parker',
                'password' => '111111',
                'photo' => ''
            ]

            $user['id']=6
            $user['first_name']='Peter'
            $user['password'] = "111111"
            */

            if(password_verify($password,$user['password'])){
                //Create session variables for future use
                session_start();
                $_SESSION['id']        = $user['id'];
                $_SESSION['username']  = $user=['username'];
                $_SESSION['full_name'] = ucwords(strtolower($user['first_name'])) . " " . ucwords(strtolower($user['last_name']));

                header('location: ../views/dashboard.php');
                exit;
                
            }else{
                die('INcorrect Password');
            }            
        }else{
            ('Username not found.');
        }

    }
}