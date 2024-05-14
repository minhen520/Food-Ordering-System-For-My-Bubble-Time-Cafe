<?php
require_once '../config.php';

$sqlmainDishes = "SELECT * FROM Menu WHERE item_category = 'Main Dishes' AND item_status = 1 ;";
$resultmainDishes = mysqli_query($link, $sqlmainDishes);
$mainDishes = mysqli_fetch_all($resultmainDishes, MYSQLI_ASSOC);

$sqldrinks = "SELECT * FROM Menu WHERE item_category = 'Drinks' AND item_status = 1 ;";
$resultdrinks = mysqli_query($link, $sqldrinks);
$drinks = mysqli_fetch_all($resultdrinks, MYSQLI_ASSOC);

$sqlsides = "SELECT * FROM Menu WHERE item_category = 'Side Snacks' AND item_status = 1 ;";
$resultsides = mysqli_query($link, $sqlsides);
$sides = mysqli_fetch_all($resultsides, MYSQLI_ASSOC);


// Check if the user is logged in
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    echo '<div class="user-profile">';
    echo 'Welcome, ' . $_SESSION["member_name"] . '!';
    echo '<a href="../customerProfile/profile.php">Profile</a>';
    echo '</div>';
    
}

session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="index.css">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,1,0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>


    
    <!-- end-->

  <title>Home</title>
</head>

<body>
 <!-- Header -->
 
<section id="header">
  <div class="header container">
    <div class="nav-bar">
      <div class="brand">
          <a class="nav-link" href="../home/home.php#hero">
          <img src="../image/logo1.png" alt=""> </a>
          </a>
      </div>
      <div class="nav-list">
        <div class="hamburger">
          <div class="bar"></div>
        </div>
          <div class="navbar-container">
            
              <div class="navbar">
        <ul>
          <li><a href="#projects" data-after="Projects">Menu</a></li>
          <li><a href="#about" data-after="About">About</a></li>
          <li><a href="#contact" data-after="Contact">Contact</a></li>
          <li><a href="../../posBackend/posTable.php" data-after="Staff">Orders</a></li>
          
          
        <div class="dropdown">
            <button class="dropbtn">ACCOUNT <i class="fa fa-caret-down" aria-hidden="true"></i> </button>
        <div class="dropdown-content">
        
  <?php

// Get the member_id from the query parameters
$account_id = $_SESSION['account_id'] ?? null; // Change this to the way you obtain the member ID

// Create a query to retrieve the member's information
//$query = "SELECT member_name, points FROM memberships WHERE account_id = $account_id";

// Execute the query
//$result = mysqli_query($link, $query);

// Check if the user is logged in
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $account_id != null) {
    $query = "SELECT member_name, points FROM memberships WHERE account_id = $account_id";

// Execute the query
$result = mysqli_query($link, $query);
    // If logged in, show "Logout" link
    // Check if the query was successful
    if ($result) {
        // Fetch the member's information
        $row = mysqli_fetch_assoc($result);
        
        if ($row) {
            $member_name = $row['member_name'];
            $points = $row['points'];
            
            // Calculate VIP status
            $vip_status = ($points >= 1000) ? 'VIP' : 'Regular';
            
            // Define the VIP tooltip text
            $vip_tooltip = ($vip_status === 'Regular') ? ($points < 1000 ? (1000 - $points) . ' points to VIP ' : 'You are eligible for VIP') : '';
            
            // Output the member's information
            echo "<p class='logout-link' style='font-size:1.3em; margin-left:15px; padding:5px; color:white; '>$member_name</p>";
            echo "<p class='logout-link' style='font-size:1.3em; margin-left:15px;padding:5px;color:white; '>$points Points </p>";
            //echo "<p class='logout-link' style='font-size:1.3em; margin-left:15px;padding:5px; color:white; '>$vip_status";
            
            // Add the tooltip only for Regular status
            if ($vip_status === 'Regular') {
                echo " <span class='tooltip'>$vip_tooltip</span>";
            }
            
            echo "</p>";
        } else {
            echo "Member not found.";
        }
    } else {
        echo "Error: " . mysqli_error($link);
    }

    echo '<a class="logout-link" style="color: white; font-size:1.3em;" href="../customerLogin/logout.php">Logout</a>';
} else {
    // If not logged in, show "Login" link
    echo '<a class="signin-link" style="color: white; font-size:15px;" href="../customerLogin/register.php">Sign Up </a> ';
    echo '<a class="login-link" style="color: white; font-size:15px; " href="../customerLogin/login.php">Log In</a>';
}

// Close the database connection
mysqli_close($link);
?>

     
    </div>
  </div> 
        </ul>
          </div>
          </div>
      </div>
    </div>
  </div>
</section>
<!-- End Header -->





<!-- Hero Section with Video Background and Text Overlay -->
<section id="hero" style="position: relative;">
    <video autoplay loop muted playsinline poster="your-poster-image.jpg" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">
        <source src="../image/SteakOnGrillCloseup1.mp4" type="video/mp4">
        <!-- Add additional source elements for 
        1.  SteakOnGrillCloseup

        other video formats if needed -->
    </video>
    <div class="hero container" style="position: relative; z-index: 1;">
        <div>
            <h1><strong><h1 class="text-center" style="font-family:Copperplate; color:whitesmoke;-webkit-text-stroke: 1px black;"> My Bubble Time Cafe</h1><span></span></strong></h1>
            <p style="color:black;">Indulge in Joy at My Bubble Time Cafe! <br> Where Flavors Bloom, Bubbles Burst, and Every Bite is a Feast. 
								<br> Celebrate Every Sip and Savor Every Bite, Your Oasis of Deliciousness and Relaxation.</p>
            <a href="#projects" type="button" class="cta">MENU</a>
        </div>
    </div>
</section>
<!-- End Hero Section -->
  
  
  
  <!-- menu Section -->
  <section id="projects">
    <div class="projects container">
      <div class="projects-header">
        <h1 class="section-title">Me<span>n</span>u</h1>
        <?php if (!empty($_SESSION["selected_id"])) {

          $latestBillID = $_SESSION['selected_id']; 
          $table_id = $_SESSION['selected_table'];

          echo '<h2>Click <a href="../../posBackend/orderItem.php?bill_id=' . $latestBillID . '&table_id=' . $table_id . '" type="button"><u>Here</u></a> To Orders </h2>';
        }else{
          echo '<h2>Click <a href="../../posBackend/posTable.php" type="button"><u>Here</u></a> To Orders </h2>';
        }
        ?>
      </div>
      <br>  <br>
       <select style="text-align:center;" id="menu-category" class="menu-category">
        <option  value="blue">ALL ITEMS</option>
        <option value="yellow">MAIN DISHES</option>
        <option value="red">SIDE DISHES</option>
        <option value="green">DRINKS</option>
      </select>
    
    <div class="yellow message"> 
     
        <div></div>
      <div class="mainDish">
           <h1 style="text-align:center;border: 1px solid black;">MAIN DISHES</h1>
           
          <?php foreach ($mainDishes as $item): ?>
      <p>
      <div style="display: flex; flex-direction: column;font-size: large;">
      <strong><?php echo '(' . $item['item_id'] . ')' .'&nbsp'.  $item['item_name'] ; ?></strong>
      <strong style="border: 1px solid black; align-self: flex-end;">RM<?php echo $item['item_price']; ?></strong>
      </div><br>
      <h4><u><?php echo $item['item_description']; ?></u><h4>
        <img src="../../../adminSide/menuCrud/Res_img/<?php echo $item['item_img']; ?>" alt="<?php echo $item['item_name']; ?>" style="max-width: 100px; max-height: 100px;">    
        <hr>
        
      </p>
    <?php endforeach; ?>
      </div>
    </div>
      
      
    <div class="red message">
        <div></div>
      <div class="sideDish">
           <h1 style="text-align:center; border: 1px solid black;">SIDE DISHES</h1>
          <?php foreach ($sides as $item): ?>
      <p>
      <div style="display: flex; flex-direction: column;font-size: large;">
      <strong><?php echo '(' . $item['item_id'] . ')' .'&nbsp'.  $item['item_name'] ; ?></strong>
      <strong style="border: 1px solid black; align-self: flex-end;">RM<?php echo $item['item_price']; ?></strong>
      </div><br>
      <h4><u><?php echo $item['item_description']; ?></u><h4>
      <img src="../../../adminSide/menuCrud/Res_img/<?php echo $item['item_img']; ?>" alt="<?php echo $item['item_name']; ?>" style="max-width: 100px; max-height: 100px;">    
        <hr>
      </p>
    <?php endforeach; ?>
      </div>
    </div>
        
      
      
    <div class="green message">
        <div></div>
      <div class="drinks">
           <h1 style="text-align:center; border: 1px solid black;">DRINKS</h1>
          <?php foreach ($drinks as $item): ?>
      <p>
      <div style="display: flex; flex-direction: column;font-size: large;">
      <strong><?php echo '(' . $item['item_id'] . ')' .'&nbsp'.  $item['item_name'] ; ?></strong> 
      <strong style="border: 1px solid black; align-self: flex-end;">RM<?php echo $item['item_price']; ?></strong>
      </div><br>
      <h4><u><?php echo $item['item_description']; ?></u><h4>
        <img src="../../../adminSide/menuCrud/Res_img/<?php echo $item['item_img']; ?>" alt="<?php echo $item['item_name']; ?>" style="max-width: 100px; max-height: 100px;">
        <hr>
      </p>
    <?php endforeach; ?>
      </div>
    </div>
      
      
       <div class="blue message">
          
      <div class="mainDish">
           <h1 style="text-align:center; border: 1px solid black;">MAIN DISHES</h1>
          <?php foreach ($mainDishes as $item): ?>
      <p>
      <div style="display: flex; flex-direction: column;font-size: large;">
      <strong><?php echo '(' . $item['item_id'] . ')' .'&nbsp'.  $item['item_name'] ; ?></strong>
      <strong style="border: 1px solid black; align-self: flex-end;">RM<?php echo $item['item_price']; ?></strong>
      </div><br>
      <h4><u><?php echo $item['item_description']; ?></u><h4>
        <img src="../../../adminSide/menuCrud/Res_img/<?php echo $item['item_img']; ?>" alt="<?php echo $item['item_name']; ?>" style="max-width: 100px; max-height: 100px;">
        <hr>
      </p>
    <?php endforeach; ?>
      </div>
             
           
     
      <div class="sideDish">
           <h1 style="text-align:center; border: 1px solid black;">SIDE DISHES</h1>
          <?php foreach ($sides as $item): ?>
      <p>
      <div style="display: flex; flex-direction: column;font-size: large;">
      <strong><?php echo '(' . $item['item_id'] . ')' .'&nbsp'.  $item['item_name'] ; ?></strong>
      <strong style="border: 1px solid black; align-self: flex-end;">RM<?php echo $item['item_price']; ?></strong>
      </div><br>
      <h4><u><?php echo $item['item_description']; ?></u><h4>
      <img src="../../../adminSide/menuCrud/Res_img/<?php echo $item['item_img']; ?>" alt="<?php echo $item['item_name']; ?>" style="max-width: 100px; max-height: 100px;">
        <hr>
      </p>
    <?php endforeach; ?>
      </div>
            
      
      <div class="drinks">
           <h1 style="text-align:center; border: 1px solid black;">DRINKS</h1>
          <?php foreach ($drinks as $item): ?>
      <p>
      <div style="display: flex; flex-direction: column;font-size: large;">
      <strong><?php echo '(' . $item['item_id'] . ')' .'&nbsp'.  $item['item_name'] ; ?></strong>
      <strong style="border: 1px solid black; align-self: flex-end;">RM<?php echo $item['item_price']; ?></strong>
      </div><br>
      <h4><u><?php echo $item['item_description']; ?></u><h4>
        <img src="../../../adminSide/menuCrud/Res_img/<?php echo $item['item_img']; ?>" alt="<?php echo $item['item_name']; ?>" style="max-width: 100px; max-height: 100px;">
        <hr>
      </p>
    <?php endforeach; ?>
      </div>
          
      </div>
    </div>
  </section>
  <!-- End menu Section -->

<!-- Chatbot -->
<button id="init">
<span class="material-symbols-rounded">mode_comment</span>
</button>
    <div id="test" class="position" style="display: none;">
        <div class="child" id="chatbot">
            <div class="headeres">
                <div class="h-child">
                    <img src="chatbot (1).png" alt="avatar" id="avatar">
                    <div>
                        <span class="name">Chatbot</span>
                        <br>
                        <span style="color:lawngreen">online</span>
                    </div>
                    <button class="refBtn"><i class="fa fa-refresh" onclick="initChat()"></i></button>
                </div>
                <div>
                    
                </div>
                <div id="chat-box">

                </div>
            </div>
        </div>
    </div>

  <!-- About Section -->
  <section id="about">
  <h1 class="section-title" >About <span>Us</span></h1>
  <div class="about container" style="display: flex; aalign-items: center;min-height:50vh;">

    <div class="col-left">
      <img style="width:100%; height: 100%" src="../image/about-img.jpg" alt="">
    </div>
    <div class="col-right">
      <h1>Welcome To My Bubble Time Cafe</h1><br><br>
      <p style="text-align: justify;">My Bubble Time Cafe, a cafe or restaurant for you to enjoy and relax. It located in Taman Rona, Parit Raja, Johor. We specialize in serving delectable Western cuisine and indulgent bubble milk tea, catering to a variety of tastes. Our food has garnered praise for its delicious taste, while our prices remain budget-friendly. We also frequently provide amazing deals and discounts to treat our customers. We are dedicated to providing a memorable experience to our valued customers. Experience the charm of My Bubble Time Cafe and indulge in flavors that will leave you craving for more. Visit us today and let us take your taste buds on a delightful adventure.</p>
    </div>
  </div>
</section>
  <!-- End About Section -->

  
  
  
  
 <!-- Contact Section -->
<section id="contact">
  <div class="contact container">
    <div>
      <h1 class="section-title">Contact <span>info</span></h1>
    </div>
    <div class="contact-items">
      <div class="contact-item contact-item-bg">
        <div class="contact-info">
          <div class='icon'><img src="../image/icons8-phone-100.png" alt=""/></div>
          <h1>Phone</h1>
          <h2>+610-555 0666</h2>
        </div>
      </div>
      
      <div class="contact-item contact-item-bg"> 
        <div class="contact-info">
          <div class='icon'><img src="../image/icons8-email-100.png" alt=""/></div>
          <h1>Email</h1>
          <h2>mybubbletimecafe@gmail.com</h2> 
        </div>
      </div>
      
      <div class="contact-item contact-item-bg">
        <div class="contact-info">
          <div class='icon'> <img src="../image/icons8-home-address-100.png" alt=""/></div>
          <h1>Address</h1>
          <h2>8, Jalan Rona 5, Taman Rona, 86400 Parit Raja, Johor</h2>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- End Contact Section -->


  

  
  
  
  
  <!-- Footer -->
  <section id="footer">
    <div class="footer container">
        <div class="brand">
          <h1>Thanks For Coming!</h1>
      </div>
        <h2>Follow our Socials</h2>
      <div class="social-icon">
        <div class="social-item">
          <a href="https://www.facebook.com/p/My-Bubble-Time-Cafe-100066757010865/"><img src="https://img.icons8.com/color/48/facebook.png" alt="facebook"/></a>
        </div>
        <div class="social-item">
          <a href="https://www.instagram.com/my.bubble.time.cafe/"><img src="https://img.icons8.com/color/48/instagram-new.png" alt="instagram-new"/></a>
        </div>
          
        
      </div>
      <p>© 2024 My Bubble Time Cafe</p>
      
      
    </div>
  </section>
  <!-- End Footer -->
  <script src="../js/app.js"></script>
   <style type="text/css">

    .position{
  position: fixed;
  right: 35px;
  bottom: 90px;
  width: 420px;
  background: #fff;
  border-radius: 15px;
  transform-origin: bottom right;
  box-shadow: 0 0 128px 0 rgba(0,0,0,0.1),
              0 32px 64px -48px rgba(0,0,0,0.5);
}

       .navbar-container {
  width: 100%;
  padding: 0;
  margin: 0;
}
      .message {
        font-family: 'Montserrat', sans-serif;
        margin-top: 25px;
        padding: 25px;
        display: none;
        color: black;
      }
      .yellow {
        background: #fff;
      }
      .green {
        background: #fff;
      }
      .red {
        background: #fff;
      }

      /* Styling the select button */
   .menu-category {
  font-size: 24px;
  padding: 10px;
  border: 2px solid black; /* Red border */
  outline: none;
  cursor: pointer;
  transition: border-color 0.3s ease, background-color 0.3s ease, color 0.3s ease;
  color: #000; /* Black text */
  background-color: #fff; /* White background */
  border-radius: 0; /* No border radius (sharp corners) */
}

/* Style the option text in the select dropdown */
.menu-category option {
  font-size: 20px;
}

/* Hover effect */
.menu-category:hover {
  background-color: black; /* Red background on hover */
  color: white; /* Black text on hover */
}

      /* Use CSS Grid to create three columns */
      .message {
        display: grid;
        grid-template-columns: repeat(3, 1fr); /* Three columns with equal width */
        grid-gap: 24px; /* Adjust the gap between items */
      }

      /* Style the menu item content */
      .message p {
        margin: 5px 0;
      }
      
    .item-name {
  display: inline-block; /* Ensure items are displayed on separate lines */
  width: 100%; /* Adjust the width as needed */
  float: left;
}

.item-price {
  display: inline-block; /* Ensure prices are displayed on separate lines */
  width: 30%; /* Adjust the width as needed */
  float: right;
}

.user-profile {
    display: flex;
    align-items: center;
    color: white;
    margin-right: 20px;
}

.user-profile a {
    margin-left: 10px;
    color: white;
    text-decoration: none;
}

/* Style for the profile link */
.profile-link {
  border: 1px solid #fff; /* Smaller border style and color */
  padding: 3px 8px; /* Smaller padding inside the border */
  border-radius: 3px; /* Rounded corners for the border */
  text-decoration: none; /* Remove the default underline */
  color: #fff; /* Text color */
  margin-left: auto; /* Automatically push the link to the right */
  margin-right: 10px; /* Add a small right margin for spacing */
}


#contact .col-right h2 {
  font-size: 24px; /* Adjust the font size */
  color: white; /* Text color for the right column */
}

#contact .col-right p {
  font-size: 18px; /* Adjust the font size */
  color: white; /* Text color for the right column */
}

/* Style for the contact-item containers */
.contact-item-bg {
  background-color: rgba(0, 0, 0, 0.7); /* Semi-transparent black background */
  padding: 20px;
  border-radius: 5px;
  margin-bottom: 20px; /* Add margin between contact items */
}

.contact-item-bg h1,
.contact-item-bg h2 {
  color: white; /* Text color for the contact items */
}

.contact-item-bg i {
  color: #fff; /* Icon color */
}

.contact-item-bg .icon img {
  width: 80px; /* Adjust the width of the icon images */
  height: 80px; /* Adjust the height of the icon images */
}



.navbar {
  overflow: hidden;
  
}

.navbar a {
  float: left;
  font-size: 16px;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

.dropdown {
  float: right;
  overflow: hidden;
}

.dropdown .dropbtn {
  font-size: 17px;  
  border: none;
  outline: none;
  color: white;
  padding: 13.9px 16px;
  background-color: inherit;
  font-family: inherit;
  margin: 0;
  margin-top: 6px;
}

 .dropdown:hover .dropbtn {
  color: crimson;
  
}

.dropdown-content {
  display: none;
  position: absolute;
    background-color: rgba(0, 0, 0, 0.5);
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
  color: black;
}

.dropdown-content a {
  float: none;
  color: white;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  text-align: left;
}

.dropdown-content a:hover {
  background-color: #ddd;
}
/* Style for the dropdown content text */
.dropdown-content a {
  float: none;
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  text-align: left;
}

/* Hover effect for dropdown content text */
.dropdown-content a:hover {
  background-color: #ddd;
  color: black; /* Set the text color to black on hover if needed */
}

.dropdown:hover .dropdown-content {
  display: block;
}

 .tooltip {
    display: none;
    position: absolute;
    background-color: rgba(0, 0, 0, 0.8);
    color: white;
    padding: 5px;
    border-radius: 3px;
    font-size: 0.9em;
    margin-top: 50px; /* Add margin to move the tooltip below the element */
    left: 0; /* Set left to 0 to align with the element */
    width: 100%; /* Make the tooltip span the width of the element */
    text-align: center; /* Center the text within the tooltip */
  }

    </style>
    
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function(){
        $("select").change(function(){
            $(this).find("option:selected").each(function(){
                var val = $(this).attr("value");
                if(val){
                    $(".message").not("." + val).hide();
                    $("." + val).show();
                } else{
                    $(".message").hide();
                }
            });
        }).change();
    });
    
    


  $(document).ready(function(){
    // Function to filter menu items based on search input
    function filterMenuItems(searchTerm) {
      $(".item-name").each(function() {
        var itemName = $(this).text().toLowerCase();
        if (itemName.includes(searchTerm)) {
          $(this).closest(".message").show();
        } else {
          $(this).closest(".message").hide();
        }
      });
    }
    

    // Search button click event
    $("#search-button").click(function() {
      var searchTerm = $("#search-input").val().toLowerCase();
      filterMenuItems(searchTerm);
    });
    
    // Search input keyup event
    $("#search-input").keyup(function() {
      var searchTerm = $(this).val().toLowerCase();
      filterMenuItems(searchTerm);
    });
  });

$(document).ready(function() {
    $('.dropdown-toggle').dropdown();
});

    </script>

<script>
  $(document).ready(function () {
    $('.logout-link').hover(function () {
      var $tooltip = $(this).find('.tooltip');
      var elementHeight = $(this).height();
      $tooltip.css('top', elementHeight + 10 + 'px'); // Position the tooltip below the element
      $tooltip.css('display', 'block');
    }, function () {
      $(this).find('.tooltip').css('display', 'none');
    });
  });
</script>

    <!-- adding-->
    <script src="index.js"></script>
</body>

</html>
