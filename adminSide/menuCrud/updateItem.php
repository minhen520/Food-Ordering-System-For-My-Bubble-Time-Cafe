
<?php
session_start(); // Ensure session is started
?>
<?php
// Include config file
require_once "../config.php";
$upload_directory = getcwd() . '/uploads/';

// Initialize variables for form validation and item data
$item_id = $item_name = $item_category = $item_price = $item_description = "";
$item_id_err = "";

// Check if item_id is provided in the URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $item_id = $_GET['id'];

    // Retrieve item details based on item_id
    $sql = "SELECT * FROM Menu WHERE item_id = ?";
    
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $param_item_id);
        $param_item_id = $item_id;
        
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_assoc($result);
                $item_name = $row['item_name'];
                $item_category = $row['item_category'];
                $item_price = $row['item_price'];
                $item_description = $row['item_description'];
            } else {
                echo "Item not found.";
                exit();
            }
        } else {
            echo "Error retrieving item details.";
            exit();
        }
     
    }
}

// Process form submission when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   // echo "Received POST data: <pre>";
//print_r($_POST);
//echo "</pre>";
    // Validate and sanitize input
    $item_name = trim($_POST["item_name"]);
    $item_category = trim($_POST["item_category"]);
    $item_price = floatval($_POST["item_price"]); // Convert to float
    $item_description = $_POST["item_description"];

    // Process file upload
    if ($_FILES['file']['size'] > 0) {
        $fname = $_FILES['file']['name'];
        $temp = $_FILES['file']['tmp_name'];
        $fsize = $_FILES['file']['size'];
        $extension = explode('.', $fname);
        $extension = strtolower(end($extension));  
        $fnew = uniqid().'.'.$extension;
        $store = "Res_img/" . basename($fnew);
        
        // Move uploaded file to destination
        if (move_uploaded_file($temp, $store)) {
            // Update the item in the database
            $update_sql = "UPDATE Menu SET item_name=?, item_category=?, item_price=?, item_description=?, item_img=? WHERE item_id=?";
            if ($stmt = mysqli_prepare($link, $update_sql)) {
                mysqli_stmt_bind_param($stmt, "ssssss", $item_name, $item_category, $item_price, $item_description, $fnew, $item_id);
                if (mysqli_stmt_execute($stmt)) {
                    // Item updated successfully
                    header("Location: ../panel/menu-panel.php");
                    exit();
                } else {
                    echo "Error updating item: " . mysqli_error($link);
                }
                mysqli_stmt_close($stmt);
            } else {
                echo "Error preparing update statement: " . mysqli_error($link);
            }
        } else {
            echo "Error moving uploaded file.";
        }
    } else {
        // Update the item in the database without changing the image
        $update_sql = "UPDATE Menu SET item_name=?, item_category=?, item_price=?, item_description=? WHERE item_id=?";
        if ($stmt = mysqli_prepare($link, $update_sql)) {
            mysqli_stmt_bind_param($stmt, "sssss", $item_name, $item_category, $item_price, $item_description, $item_id);
            if (mysqli_stmt_execute($stmt)) {
                // Item updated successfully
                header("Location: ../panel/menu-panel.php");
                exit();
            } else {
                echo "Error updating item: " . mysqli_error($link);
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "Error preparing update statement: " . mysqli_error($link);
        }
    }
}
    
    /*
     $result_tables = mysqli_query($link, $select_query_tables);
                                $resultCheckTables = mysqli_num_rows($result_tables);
                                if ($resultCheckTables > 0) {
                                    while ($row = mysqli_fetch_assoc($result_tables)) {
                                        echo '<option value="' . $row['table_id'] . '">For ' . $row['capacity'] . ' people. (Table Id: ' . $row['table_id'] . ')</option>';
                                    }
                                }  else {
                                    echo '<option disabled>No tables available, please choose another time.</option>';
                                    echo '<script>alert("No reservation tables found for the selected time. Please choose another time.");</script>';
                                }
     */

    // Close the database connection
    

?>

<!-- Create your HTML form for updating the item details -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">  
    <title>Update Item</title>
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
     <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: black;
            color: white;
        }

        .login-container {
            padding: 50px; /* Adjust the padding as needed */
            border-radius: 10px; /* Add rounded corners */
            margin: 100px auto; /* Center the container horizontally */
            max-width: 500px; /* Set a maximum width for the container */
        }

      

    



    </style>
</head>
<body>
     <div class="login-container">
        <div class="login_wrapper">
   
    <div class="wrapper">
    <h2 style="text-align: center;">Update Item</h2>
    <h5>Admin Credentials needed to Edit Item</h5>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="item_name"  class="form-label" >Item Name:</label>
            <input type="text" name="item_name" id="item_name" class="form-control"  placeholder="Spaghetti" value="<?php echo htmlspecialchars($item_name); ?>" required>
        </div>
        <div class="form-group"  class="form-label">
            <label for="item_category" >Item Category:</label>
            <input type="text" name="item_category" id="item_category" class="form-control" placeholder="Main Dish/ Side Dish/ Drinks" value="<?php echo htmlspecialchars($item_category); ?>" required>
        </div>
        <div class="form-group" class="form-label">
            <label for="item_price">Item Price:</label>
            <input min=0.01 step="0.01" name="item_price" id="item_price" placeholder="Enter Item Price"class="form-control" value="<?php echo htmlspecialchars($item_price);?>" required>
        </div>
        <div class="form-group" >
            <label for="item_description" class="form-label" >Item Description:</label>
            <textarea name="item_description" id="item_description" placeholder="The dish...." required class="form-control"> <?php echo htmlspecialchars($item_description); ?> </textarea>
        </div>
        <div class="form-group" class="form-label">
            <label class="control-label">Image</label>
            <input type="file" name="file" id="lastName" class="form-control form-control-danger" placeholder="Upload Image">
        </div>
        <br>
        <input type="hidden" name="item_id" value="   class="form-control">
        <button class="btn btn-light" type="submit" name="submit" value="submit">Update</button>
        <a class="btn btn-danger" href="../panel/menu-panel.php" >Cancel</a>
    </form>
    </div>
        </div>
    </div>
</body>
</html>