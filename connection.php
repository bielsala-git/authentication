<?php
$connection = mysqli_connect("localhost","root","Salabiel88$","registration");
if(mysqli_connect_errno()){
    echo "An error has appear" . mysqli_connect_errno();
}else echo "connection establish";


?>