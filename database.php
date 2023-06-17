<?php
function get_connection(){
    $connection = mysqli_connect("localhost", "root", "", "webshoplv44");
    if (!$connection) {
      die("Connection failed: " . mysqli_connect_error());
    }
    return $connection;
  }
?>