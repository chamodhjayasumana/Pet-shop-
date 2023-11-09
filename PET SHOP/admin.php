<?php 
     include 'config.php';
     session_start();

     //set user id
     if(isset($_SESSION['user_id'])){
        $id=$_SESSION['user_id'];
     }
   
     //check admin or not
     if(isset($_SESSION['user_id'])){
        $choose=mysqli_query($conn,"SELECT *FROM user_info WHERE uId='$id'");
        $row=mysqli_fetch_assoc($choose);

        $u=$row['email'];
        $p= $row['epassword'];

        $take=mysqli_query($conn,"SELECT *FROM normal_admin WHERE email='$u' and password='$p'");
        if(!mysqli_num_rows($take)>0){
            header('Location:index.php');
    
        }     
                   
    }
    else{
        header('Location:index.php');
    }


    //after submit the form of product
    if(isset($_POST['submit'])){

        $product=$_POST['name'];
        $quantity=$_POST['quantity'];
        $descript=$_POST['description'];
        $price=$_POST['price'];
        
        $p_image = $_FILES['p_image']['name'];
        $p_image_tmp_name = $_FILES['p_image']['tmp_name'];
       
        $p_image_folder = 'arrivals/'.$p_image;
        

        
        

        

        $insert=mysqli_query($conn,"INSERT INTO product_info(pName,pQuantity,pDescription,pPrice,pImg)
           VALUES('$product','$quantity','$descript','$price','$p_image')") or die('query failed');

           if($insert){
                    move_uploaded_file($p_image_tmp_name,$p_image_folder);
                    $message[]='product add succesfully into folder';

                
            }
            else{
                $message[]='image not uploaded';
            }
           

        
           



    }

    // ----------------------------deleting product--------------------------------------------------- 

    if(isset($_GET['delete'])){
        $delete_id = $_GET['delete'];
        $delete_query = mysqli_query($conn, "DELETE FROM product_info WHERE pId = $delete_id ") or die('query failed');
        if($delete_query){
         
           $message[] = 'product has been deleted';
        }else{
       
           $message[] = 'product could not  deleted';
        }
     }

     // -------------------------- select --------------------------------------------------------

     
        $select_products = mysqli_query($conn, "SELECT * FROM product_info ORDER BY pId desc");
     


    // ------------------ update product after submit-------------------------------------------------------

       if(isset($_POST['update_product'])){

         $update_id = $_SESSION['upid'];
         

         $update_p_name = $_POST['update_p_name'];
         $update_p_quantity = $_POST['update_p_quantity'];
         $update_p_description = $_POST['update_p_description'];

         $update_p_price = $_POST['update_p_price'];
         
         $update_p_image = $_FILES['update_p_image']['name'];
         $update_p_image_tmp_name = $_FILES['update_p_image']['tmp_name'];
         
     
         $update_p_arrivals = 'arrivals/'.$update_p_image;
         
         if($update_p_image){
            $update_query = mysqli_query($conn, "UPDATE product_info SET pName = '$update_p_name', pQuantity='$update_p_quantity', pDescription=' $update_p_description', pPrice = '$update_p_price', pImg = '$update_p_image' WHERE pId = '$update_id'");

         }
         else{
            $update_querynopic = mysqli_query($conn, "UPDATE product_info SET pName = '$update_p_name', pQuantity='$update_p_quantity', pDescription=' $update_p_description', pPrice = '$update_p_price' WHERE pId = '$update_id'");

         }
         
         if($update_query){
        
                move_uploaded_file($update_p_image_tmp_name, $update_p_arrivals);
                $message[] = 'product updated succesfully';
                header('location:admin.php');
         }
       }
       
         
     
         
     
     

     //------------------ rest popup box----------------------------------------------------------
     if(isset($_GET['cancel'])){

        echo "<script>document.querySelector('.edit-form-container').style.display = 'none';</script>";
        
     }



   //--------------------   admin details process------------------------------------------------------

   if(isset($_POST['add_admin'])){

      $aname = mysqli_real_escape_string($conn, $_POST['aname']);
      $aemail = mysqli_real_escape_string($conn, $_POST['aemail']);
      $anum = mysqli_real_escape_string($conn, $_POST['anum']);
      $apass = mysqli_real_escape_string($conn, md5($_POST['apassword']));
      $acpass = mysqli_real_escape_string($conn, md5($_POST['acpassword']));

      if($apass!= $acpass){
         $messageA[]='confirm password not match';
      }
      else{
         $check_admin=mysqli_query($conn,"SELECT *FROM normal_admin WHERE email='$aemail' and password='$apass'  ");

         if(mysqli_num_rows($check_admin)>0){
            $messageA[]='this admin already exists';
         }
         else{
            $add_am=mysqli_query($conn,"INSERT INTO `normal_admin`(`name`, `email`, `number`, `password`) VALUES ('$aname','$aemail','$anum','$apass')");
            $add_us=mysqli_query($conn,"INSERT INTO `user_info`(`name`, `email`, `number`, `epassword`) VALUES ('$aname','$aemail','$anum','$apass')");

            if($add_am and $add_us){
               $messageA[]='admin add sucsessfully';
            }
            else{
               $messageA[]='admin add fail';
            }
         }
      }

     

   }


     
?>

   <!-------------------------------------- //////////////////////////////--------------------- ----------------------->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin</title>

     <!-- linking fontawsome -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- linking style sheets -->
    <link rel="stylesheet" href="assets/css/style2.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <!-- linking style sheets -->
    <link rel="stylesheet" href="assets/css/stylesd.css">
    <!-- linking swiper -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"/>

    <style>
    
    
    .icon-eye {
        
        color: blue; /* Change the color to blue */
        font-size: 24px; /* Change the font size to 24 pixels */
        padding-bottom: 5px;
    }
</style>
</head>
<body>
 <!-- /////////////////////////////// -->

 <?php include 'header.php' ?>
 
    <!-- ----------------------------------------super admin button--------------------------------------- -->
    <div style="align-items: center; display:flex ;justify-content: space-evenly;">
    <?php  
    $knowing=mysqli_query($conn,"SELECT *FROM user_info WHERE uId='$id'");
    $look=mysqli_fetch_assoc($knowing);

    $ke=$look['email'];
    $kp=$look['epassword'];

    $check_super=mysqli_query($conn,"SELECT *FROM super_admin WHERE email='$ke' and password='$kp'");

    if(mysqli_num_rows($check_super)>0){
      echo '    <a style="width: 120px;" href="admin.php?add_admin"   class="option-btn-admin" > Add admin</a>
      <a style="width: 120px;" href="index.php"   class="option-btn-admin" >home</a>';
    }

    ?>
  </div>
  <!-- ---------------------------------------------admin adding------------------------------------------- -->
    <!-- sign form -->

    <?php   
    if(isset($_GET['add_admin'])){
       echo '<div class="add-form-container">
       <div id="" class="signdiv"></div>
       <form action="" method="POST" enctype="multipart/form-data">

       <a href="admin.php"  class="icon-eye fas fa-times"></a>
           <h3>Add Admin</h3>';

                 
      if(isset($messageA)){
         foreach($messageA as $messageA){
            echo '<div class="message">'.$messageA.'</div>';
         }
      }

         echo '
         
         <span>Name</span>
         <input type="text" name="aname" class="box" placeholder="User name" id="" required>
         <span>Email</span>
         <input type="email" name="aemail" class="box" placeholder="Enter your email" id="" required>
         <span>Mobile Number</span>

         <div class="box" >
         <input style="width: 28px;" type="tel" name="numf"  value="+94" disabled placeholder="number"  >
         <input type="tel" name="anum"   maxlength="9" placeholder="number" id="" required>
         </div>

         <span>Password</span>
         <input type="password" name="apassword" class="box" placeholder="Enter your password" id="" required>
         <span>Confirm Password</span>
         <input type="password" name="acpassword" class="box" placeholder="Enter your password" id="" required>
          
         <input type="submit" name="add_admin" value="add" class="btn" >
         
          
     </form>
 </div>';
      
echo  "<script>document.querySelector('.add-form-container').style.display = 'flex';</script>";
    }
    
    ?>

  
 
      <!-- ----------------------------------add product to tables ---------------------------------------->
      <div class="product-container">
        <div id="" class="signdiv"></div>
        <form action="" method="POST" enctype="multipart/form-data">

            <h3>add product</h3>

            <?php
      if(isset($message)){
         foreach($message as $message){
            echo '<div class="message">'.$message.'</div>';
         }
      }
      ?>

      <div class="indiv">
      <span>product name</span>
            <input type="text" name="name" class="box" placeholder="name" id="" required>
            <span>quantity</span>
            <input type="number" name="quantity" class="box" placeholder="quantity" id="" required>
            <span>description</span>
            <input type="text" name="description" class="box" placeholder="description" id="" required>
           


      </div>

      <div class="indiv">
      <span>price</span>
            <input type="number" min="0" name="price" class="box" placeholder="price" id="" required>

      <span>image</span>     
            <input type="file" name="p_image" accept="image/png, image/jpg, image/jpeg" class="box" required>       
            

      </div>

      <input type="submit" name="submit" value="add" class="btn" >
            
           
           
             
        </form>
    </div>
 

    <!------------------------------------------ product table show-------------------------------------------- -->
<section class="display-product-table" style="margin-bottom: 40px;">

<table>

   <thead>
      <th>image</th>
      <th>product</th>
      <th>quantity</th>
      <th>description</th>
      <th>price</th>
      <th>action</th>
   </thead>

   <tbody>
      <?php
      
         
         if(mysqli_num_rows($select_products) > 0){
            while($row = mysqli_fetch_assoc($select_products)){
      ?>

      <tr>
        <?php 
        echo '<td><img src="arrivals/'.$row['pImg'].'" height="100" alt=""></td>';
        ?>
         
         <td><?php echo $row['pName']; ?></td>
         <td><?php echo $row['pQuantity']; ?></td>
         <td><?php echo $row['pDescription']; ?></td>
         <td>$<?php echo $row['pPrice']; ?>/-</td>
         <td>
         <a href="admin.php?delete=<?php echo $row['pId']; ?>" class="delete-btn" onclick="return confirm('are your sure you want to delete this?');"> <i class="fas fa-trash"></i> delete</a>
            <a href="admin.php?edit=<?php echo $row['pId']; ?>" class="option-btn"> <i class="fas fa-edit"></i> update </a>
         </td>
      </tr>

      <?php
         };    
         }
         else{
            echo "<div class='empty'>no product added</div>";
         };
      ?>
   </tbody>
</table>

</section>



</section>
<!------------------------------------------------------ edit form  ------------------------------------------->
<section class="edit-form-container">

   <?php
   
   if(isset($_GET['edit'])){
      $edit_id = $_GET['edit'];
      $edit_query = mysqli_query($conn, "SELECT * FROM product_info WHERE pId = $edit_id");
      if(mysqli_num_rows($edit_query) > 0){
        while( $fetch_edit = mysqli_fetch_assoc($edit_query)){
            
   ?>

   <form action="" method="post" enctype="multipart/form-data">
      
   <?php  
   echo '<img src="arrivals/'.$fetch_edit['pImg'].'" height="100" alt="">';
   ?>
    
      
      <input type="text" class="box" required name="update_p_name" value="<?php echo $fetch_edit['pName']; ?>">
      <input type="number" min="0" class="box" required name="update_p_quantity" value="<?php echo $fetch_edit['pQuantity']; ?>">
      <input type="text" class="box" required name="update_p_description" value="<?php echo $fetch_edit['pDescription']; ?>">
      <input type="number" min="0" class="box" required name="update_p_price" value="<?php echo $fetch_edit['pPrice']; ?>">

       
      
      <?php $_SESSION['upid']=$fetch_edit['pId']; ?>  
      <input type="file" class="box"  name="update_p_image" accept="image/png, image/jpg, image/jpeg">
      <input type="submit" value="update the prodcut" name="update_product" class="btn">
       
      <a href="admin.php?reset='reset'" class="btn">cansel</a>
   </form>

   <?php
            
         };
        };
         echo "<script>document.querySelector('.edit-form-container').style.display = 'flex';</script>";
      };
   ?>

</section>






    
  
    
<!------------------------------bottom nan------------------------------------------- -->

      
 
    

    

<!-- loader -->

<div class="loader-container">
<img src="loader.gif" alt="">
</div> 

<!--===== FOOTER =====-->
<?php 
include 'footer.php';
?>
    

<!-- swiper linking -->
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

   <!-- linking the javascript -->
   <!-- <script src="js.js"></script> -->
    
</body>
</html>

