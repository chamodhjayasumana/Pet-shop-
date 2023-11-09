<?php 
     include 'config.php';
     session_start();

 
     if(isset($_SESSION['user_id'])){
        $id=$_SESSION['user_id'];
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
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
        <link href='https://unpkg.com/boxicons@2.1.4/dist/boxicons.js' rel='stylesheet'>
        <link rel="stylesheet" href="assets/css/styles.css">

        <!-- =====BOX ICONS===== -->
        <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>

        <title>home</title>
    </head>
    <body>
        

       <!-- -------------------------------header--------------------------->
     <?php include 'header.php' ?>
     <!-- ////////////////////////////////////// -->
     <section id="feature" class="section-p1">

        <div class="fe-box">
            <img src="arrivals/Puppies for sale.png" alt="">
            <h6>Puppies for sale</h6>
        </div>
        <div class="fe-box">
            <img src="arrivals/Breeders Directory.png" alt="">
            <h6>Online Order</h6>
        </div>
        <div class="fe-box">
            <img src="arrivals/Breed Match.png" alt="">
            <h6>Save Money</h6>
        </div>
        <div class="fe-box">
            <img src="arrivals/Cutest Dog Contest.png" alt="">
            <h6>Promotions</h6>
        </div>
        <div class="fe-box">
            <img src="arrivals/Breed Match.png" alt="">
            <h6>Happy sell</h6>
        </div>
        <div class="fe-box">
            <img src="arrivals/Previus Listings.png" alt="">
            <h6>F24/7 Support</h6>
        </div>
    </section>

            


              <section class="outbox" id="arrivals">
              <?php  
             $select=mysqli_query($conn,"SELECT *FROM product_info ");
                 
             if(mysqli_num_rows($select)>0){
                while($row=mysqli_fetch_assoc($select)){
                  echo ' <div class="box">';


                    echo '
                    
                    <div class="inpic">
                    <img src="arrivals/'.$row['pImg'].'" alt="">
                    </div>';

                    echo '

                     
                    
                    <div class="intext">
                    <h1>'.$row['pName'].'</h1>
                    <p>'.$row['pDescription'].'</p>
                    <h1>Rs.'.$row['pPrice'].'</h1>
                    
                    </div>';


                    echo '</div>';


                }
             }
             
             ?>
              </section>     
              
            

            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
 
            <!-- newslattter -->


    <section id="newslatter" class="section-p1 section-m1" >
        <div class="newstext">
            <h4>Sign Up For Newsletters</h4>
            <p>Get E-mail updates about our latest shop and <span>special offers.</span></p>
        </div>
        <div class="form">
            <input type="text" placeholder="Your email address">
            <button class="normal">Sign Up</button>
        </div>
    </section>
           

        <!--===== FOOTER =====-->
<?php 
include 'footer.php';
?>
        
         


        <!--===== SCROLL REVEAL =====-->
        <script src="https://unpkg.com/scrollreveal"></script>

        <!--===== MAIN JS =====-->
        <script src="assets/js/main.js"></script>

         
    </body>
</html>
