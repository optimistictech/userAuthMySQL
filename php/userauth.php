<?php

session_start();
require_once "../config.php";

//register users
function registerUser($fullnames, $email, $password, $gender, $country){
    //create a connection variable using the db function in config.php
    $conn = db();
   //check if user with this email already exist in the database
   $query=mysqli_query($conn, "SELECT * FROM Students WHERE email = '$email'");

   if(mysqli_num_rows($query)>0){

    echo "<script> alert('Email already exist') </script>";

   }

   else{

    $query= "INSERT INTO `Students` (`full_names`, `country`, `email`, `gender`, `password`)
     VALUES ( '$fullnames', '$country', '$email', '$gender', '$password')";
    
    if(mysqli_query($conn, $query)){

        echo "<script> alert('User Successfully registered') </script>";
    
       }

       else{

        echo "<script> alert('Registration failed') </script>";

       }


    
   }

}


//login users
function loginUser($email, $password){
    //create a connection variable using the db function in config.php
    $conn = db();

    //open connection to the database and check if username exist in the database
    //if it does, check if the password is the same with what is given
    //if true then set user session for the user and redirect to the dasbboard
    $query=mysqli_query($conn, "SELECT * FROM Students WHERE email = '$email' ");

    if(mysqli_num_rows($query)>0){
 
        $query=mysqli_query($conn, "SELECT * FROM Students WHERE `password` = '$password' ");

        if(mysqli_num_rows($query)>0){

            $_SESSION['username'] = $email;

            header("Location: ../dashboard.php");

        }

        else{

            echo "<script> alert('Wrong Password'); window.location.href='../forms/login.html' </script>";
            

        }
 
    }

    else{

        echo "<script> alert('User does not Exist'); window.location.href='../forms/login.html' </script>";

       


    }

    


}


function resetPassword($email, $password){
    //create a connection variable using the db function in config.php
    $conn = db();
   
    //open connection to the database and check if username exist in the database
    //if it does, replace the password with $password given

    $query=mysqli_query($conn, "SELECT * FROM Students WHERE email = '$email' ");

    if(mysqli_num_rows($query)>0){

        $query= "UPDATE `Students` SET `password` = '$password' WHERE `Students`.`email` = '$email'; ";
    
    if(mysqli_query($conn, $query)){

        echo "<script> alert('Password Updated'); window.location.href='../forms/login.html' </script>";
    
       }

       else{
        echo "<script> alert('An Error occured') </script>";

       }


    }

    else{

        echo "<script> alert('User does not Exist'); window.location.href='../forms/resetpassword.html' </script>";

    }

}

function getusers(){
    $conn = db();
    $sql = "SELECT * FROM Students";
    $result = mysqli_query($conn, $sql);
    echo"<html>
    <head></head>
    <body>
    <center><h1><u> ZURI PHP STUDENTS </u> </h1> 
    <table border='1' style='width: 700px; background-color: magenta; border-style: none'; >
    <tr style='height: 40px'><th>ID</th><th>Full Names</th> <th>Email</th> <th>Gender</th> <th>Country</th> <th>Action</th></tr>";
    if(mysqli_num_rows($result) > 0){
        while($data = mysqli_fetch_assoc($result)){
            //show data
            echo "<tr style='height: 30px'>".
                "<td style='width: 50px; background: blue'>" . $data['id'] . "</td>
                <td style='width: 150px'>" . $data['full_names'] .
                "</td> <td style='width: 150px'>" . $data['email'] .
                "</td> <td style='width: 150px'>" . $data['gender'] . 
                "</td> <td style='width: 150px'>" . $data['country'] . 
                "</td>
                <form action='action.php' method='post'>
                <input type='hidden' name='id'" .
                 "value=" . $data['id'] . ">".
                "<td style='width: 150px'> <button type='submit', name='delete'> DELETE </button>".
                "</tr>";
        }
        echo "</table></table></center></body></html>";
    }
    //return users from the database
    //loop through the users and display them on a table
}

 function deleteaccount($id){
     $conn = db();
     //delete user with the given id from the database

     $query=mysqli_query($conn, "DELETE FROM Students WHERE `Students`.`id` = '$id' ");

    if($query){

        echo "<script> alert('User deleted')</script>";
    }
 }
