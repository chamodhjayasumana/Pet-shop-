<!--===== HEADER =====-->
<header class="l-header">
            <nav class="nav bd-grid">
                <div class="main_logo">
                <a href="#"><img src="arrivals/logo.jpg" class="logo" ></a>
                    <a href="#" class="nav__logo">gooddog.com</a>
                </div>
                 

                <div class="nav__menu" id="nav-menu">
                    <ul class="nav__list">
                        <li class="nav__item"><a href="index.php#home">Home</a></li>
                        <li class="nav__item"><a href="index.php#arrivals">Arrivals</a></li>
                                         

                        <?php
//checking ,if user is admin or not-------------------

            if(isset($_SESSION['user_id'])){
                $choose=mysqli_query($conn,"SELECT *FROM user_info WHERE uId='$id'");
                $row=mysqli_fetch_assoc($choose);

                $u=$row['email'];
                $p= $row['epassword'];

                $take=mysqli_query($conn,"SELECT *FROM normal_admin WHERE email='$u' and password='$p'");
                if(mysqli_num_rows($take)>0){
                    echo '<li class="nav__item"><a href="login.php">profile</a></li>';
                    echo '<li class="nav__item"><a href="admin.php">admin panel</a></li>';  
            
                } 
                           
            }else{
                echo '<li class="nav__item"><a href="login.php">login</a></li>'; 
            }
                ?>
                      <li class="nav__item"><a href="index.php#arrivals"><img src="arrivals/cart-solid-24.png" alt=""></a></li>   
                         
                
                     
                    </ul>
                </div>

                <div class="nav__toggle" id="nav-toggle">
                    <i class='bx bx-menu'></i>
                </div>
            </nav>
        </header>

        <main class="l-main">
             
 