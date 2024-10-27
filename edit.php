<?php
include("config.php");
error_reporting(0);
$id = $_GET['id'];
$un= $_GET['un'];
$em = $_GET['em'];
$pw = $_GET['pw'];
?>

<html>
    <head>
        <title></title>

        <style>
            table 
            {
                color:white;
                border-radius:20px;
            }

            #button
            {
                background-color:green;
                color:white;
                height:32px;
                width:125px;
                border-radius:25px;
                font-size:16px;
            }

            body
            {
                background:linear-gradient(blue,purple);
            }
        </style>
        </head>

        <body>
        <br><br><br><br><br><br><br>

        <form action="" method="GET">
        <table border="0" bgcolor="black" align="center" cellspacing="20">

        <tr>
        <td>ID</td>
        <td><input type="text" value="<?php echo "$id" ?>" name="id" required></td>
        </tr>

        <tr>
        <td>Username</td>
        <td><input type="text" value="<?php echo "$un" ?>" name="username" required></td>
        </tr>
        
        <tr>
        <td>Email</td>
        <td><input type="text" value="<?php echo "$em" ?>" name="email" required></td>
        </tr>

        <tr>
        <td>Password</td>
        <td><input type="text" value="<?php echo "$pw" ?>" name="password" required></td>
        </tr>

        <tr>
        <td colspan="2" align="center"><input type="submit" id="button" name="submit" value="Update Details"></td>
        </tr>
        </form>
        </table>
        </body>
        </html>

        <?php

        if($_GET['submit'])
        {
            $id = $_GET['id'];
            $username = $_GET['username'];
            $email = $_GET['email'];
            $pw = $_GET['pw'];

            $query = "UPDATE users SET id='$id', username='$username', email='$email', pw='$pw' WHERE id='$id'";
        }

        $data = mysqli_query($conn,$query);

        if($data) 
        {
            echo "<script>alert('Record Updated')</script>";
            
        }
