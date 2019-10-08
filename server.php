<?php 
include('connection.php');
session_start();
//register form datra


$errors = array();
if(isset($_POST['register'])){

    $username = mysqli_real_escape_string($connection,$_POST['username']);
    $pass = mysqli_real_escape_string($connection,$_POST['pass']);
    $pass2 = mysqli_real_escape_string($connection,$_POST['pass2']);
    $email = mysqli_real_escape_string($connection,$_POST['email']);
    $phone = mysqli_real_escape_string($connection,$_POST['phone']);

    if(empty($username)) array_push($errors,"username is required");
    if(empty($pass)) array_push($errors,"password is required");
    if(empty($email)) array_push($errors,"password is required");
    if($pass != $pass2) array_push($errors,"password do not match");

    $checkUser = "select * from user where username='$username'";
    $result = mysqli_query($connection,$checkUser);
    $user = mysqli_fetch_assoc($result);

    if($user){
        if($username == $user['username']) array_push($errors,"Username already exists");
        if($email == $user['email']) array_push($errors,"email already exists");
    }
    if(count($errors) == 0)
        $password = encryptingPass($pass1);
        $insertQuery = "insert into users(username,password,email,phone) values('$username','$password','$email','$phone')";

        $result = mysqli_query($connection,$insertQuery);
        if($result) echo "user register succefully";
        else echo "we cannot register de user";
        $_SESSION['username'] = $username;
        $_SESSION['succes'] = "Youre logged in";
        
 
    }


if(isset($_POST['login'])){
    $username = mysqli_real_escape_string($connection,$_POST['username']);
    $password = mysqli_real_escape_string($connection,$_POST['password']);

    if(empty($_POST['username'])) array_push($errors,"username is required");
    if(empty($_POST['password'])) array_push($errors,"password is requires");

    $encryptPassword = encryptingPass($password);
    $checkUser = "select * from users where username='$username' and password='$encryptPassword'";
    $result = mysqli_query($connection,$checkUser);
    
    if(mysqli_num_rows($result) == 1){
        echo "log in corectly";
        $_SESSION['username'] = $username;
        $_SESSION['succes'] = "log in";
    }else array_push($errors,"wrong password or username");

}





function encryptingPass($pass){
    $encryptPassword = md5($pass);
    return $encryptPassword;
}

?>