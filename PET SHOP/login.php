<?php 
     include 'config.php';
     session_start();
      

     if(isset($_POST['submit'])){

        
        $lemail = mysqli_real_escape_string($conn, $_POST['lemail']);
        $lpass = mysqli_real_escape_string($conn, md5($_POST['lpass']));
        
     
        $choose=mysqli_query($conn,"SELECT *FROM user_info WHERE email='$lemail' and epassword ='$lpass'");
     
        if(mysqli_num_rows($choose)>0){
            
         $row=mysqli_fetch_assoc($choose);
         $_SESSION['user_id'] = $row['uId'];
         header('Location:index.php');
        }
        else{
            $message[]='user input not match';
             
        }
    }

    if(isset($_GET['logout'])){
      session_destroy();
   }


     


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
      <!-- linking style sheets -->
      <link rel="stylesheet" href="assets/css/style2.css">
</head>
<body>
<div class="sign-form-container">
        <div id="close-login-btn" class="fa-solid fa-xmark"></div>

        <?php
          if(isset($_SESSION['user_id'])){
            $id=$_SESSION['user_id'];
            $choose=mysqli_query($conn,"SELECT *FROM user_info WHERE uId='$id'");
            $row=mysqli_fetch_assoc($choose);
            echo'<div class="logbox">
            <h style="font-size: 25px; color: green; font-weight: 1000;">Profile</h>  
            <span>'.$row['name'].'</span>
            <span>'.$row['email'].'</span>
            <span>0'.$row['number'].'</span>
            <a href="index.php?logout" class="btn">logout</a>
            </div>
            ';
          }
          else{
            echo ' <form action=""  method="POST" enctype="multipart/form-data">
                                         
                   <h3>Login</h3>;';

                   
                   if(isset($message)){
                    foreach($message as $message){
                       echo '<div class="message">'.$message.'</div>';
                    }
                 }
                 
                 echo '
                                          <span>Email</span>
                                          <input type="email" name="lemail" class="box" placeholder="Enter your email"  required>
                                          <span>Password</span>
                                          <input type="password" name="lpass" class="box" placeholder="Enter your password" required>
                                           
                                          <input type="submit" name="submit" value="login" class="btn" >   
                                 
                                          <p>Don"t have an account? <a href="sign.php">Create an account</a></p>
                    </form>';

                

              }
        ?>
        
                                     
        
    </div>


    
</body>
</html>