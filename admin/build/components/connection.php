<?php
session_start();
$host='localhost';
$username='root';
$password='';
$database='db_sound';

$conn= new mysqli($host,$username,$password,$database);

if($conn->connect_error){
    die("connection failed".$conn->connect_error);
}
?>