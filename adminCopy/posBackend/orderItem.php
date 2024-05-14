
    <?php
    session_start(); // Ensure session is started
    ?>
    <?php
    require_once '../config.php';
    include '../inc/dashHeader.php'; 

    $bill_id = $_GET['bill_id'];
    $table_id = $_GET['table_id'];

    $_SESSION['latest_b'] = $bill_id;
    $_SESSION['latest_t'] = $table_id;

    function createNewBillRecord($table_id) {
        global $link; // Assuming $link is your database connection
        
        $bill_time = date('Y-m-d H:i:s');
        
        $insert_query = "INSERT INTO Bills (table_id, bill_time) VALUES ('$table_id', '$bill_time')";
        if ($link->query($insert_query) === TRUE) {
            return $link->insert_id; // Return the newly inserted bill_id
        } else {
            return false;
        }
    }

    $confirm_status_query = "SELECT kit_status FROM Kitchen WHERE table_id = '$table_id' AND time_ended IS NULL";
    $confirm_status_result = mysqli_query($link, $confirm_status_query);
    $order_confirmed= false;



    if ($confirm_status_result && mysqli_num_rows($confirm_status_result) > 0) {
        $confirm_time_row = mysqli_fetch_assoc($confirm_status_result);

        if (($confirm_time_row['kit_status'] == 1) && (isset($_GET['add_order']) && $_GET['add_order'] === 'true')) {
            $order_confirmed = true;
        }else{
            $order_confirmed = false;
        }
    }

    $_SESSION['total1'] = 0;
    $checkValid = 0;

    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
        $memberId = $_SESSION['logged_customer_id']; // Fill the input field with logged-in customer's ID
    } else {
        $memberId = ''; // Otherwise, keep the input field empty
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_POST['MemberCheck'])){
        // Retrieve member ID from form submission
        $memberId = !empty($_POST['memberId']) ? $_POST['memberId'] : 0;

        // Check if the member ID exists in the membership records
        $query = "SELECT * FROM Memberships WHERE member_id = '$memberId'";
        $result = mysqli_query($link, $query);
        
        if (!$result) {
            echo "Error: " . mysqli_error($link);
        } else {
            // If the member exists, store the member ID in the session
            if (mysqli_num_rows($result) > 0) {
                $_SESSION['memberId'] = $memberId;
            }else{
                $checkValid = 1;
            }
        }
        }
        if(isset($_POST['clearMemberId'])) {
            // Unset the session variable for memberID
            unset($_SESSION['memberId']);
            $checkValid = 0;
        }
    }

    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <link href="../css/pos.css" rel="stylesheet" />
        <script>
        function hideConfirmButton() {
            // Hide the confirm order form
            document.getElementById("confirm-order-form").style.display = "none";
            // Display the payment buttons
            document.getElementById("payment-buttons").style.display = "block";
        }
        </script>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 order-md-1 m-1" id="item-select-section ">
                    <div class="container-fluid pt-4 pl-500 row" style=" margin-left: 10rem;width: 81% ;">
                        <div class="mt-5 mb-2">
                        <h3 class="pull-left">Food & Drinks</h3>
                            
                        </div>
                        <div class="mb-3">
                            <form method="POST" action="#">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" required="" id="search" name="search" class="form-control" placeholder="Search Food & Drinks">
                                    </div>
                                    <div class="col-md-3">
                                        <button type="submit" class="btn btn-dark">Search</button>
                                    </div>
                                    <div class="col" style="text-align: right;" >
                                        <a href="orderItem.php?bill_id=<?php echo $bill_id; ?>&table_id=<?php echo $table_id; ?>" class="btn btn-light">Show All</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div style="max-height: 45rem;overflow-y: auto;">
                            <?php
                            // Include config file
                            
                            require_once "../config.php";
                            if (isset($_POST['search'])) {
                                if (!empty($_POST['search'])) {
                                    $search = $_POST['search'];

                                    $query = "SELECT * FROM Menu WHERE item_category LIKE '%$search%' OR item_name LIKE '%$search%' OR item_id LIKE '%$search%' ORDER BY item_id;";
                                    $result = mysqli_query($link, $query);
                                }else{
                                    // Default query to fetch all menu items
                                    $query = "SELECT * FROM Menu ORDER BY item_id;";
                                    $result = mysqli_query($link, $query);
                                }
                            } else {
                                // Default query to fetch all menu items
                                $query = "SELECT * FROM Menu ORDER BY item_id;";
                                $result = mysqli_query($link, $query);
                            }
                            $bill_id = $_GET['bill_id'];
                            if ($result) {
                                if (mysqli_num_rows($result) > 0) {
                                    echo '<table class="table table-bordered table-striped">';
                                    echo "<thead>";
                                    echo "<tr>";
                                    echo "<th>ID</th>";
                                    echo "<th>Item Name</th>";
                                    echo "<th>Category</th>";
                                    echo "<th>Price (RM)</th>";
                                    echo "<th>Add</th>";
                                    echo "</tr>";
                                    echo "</thead>";
                                    echo "<tbody>";
                                    // ...

                                    while ($row = mysqli_fetch_array($result)) {
                                        echo "<tr>";
                                        echo "<td>" . $row['item_id'] . "</td>";
                                        echo "<td>" . $row['item_name'] . "</td>";
                                        echo "<td>" . $row['item_category'] . "</td>";
                                        echo "<td>" . number_format($row['item_price'],2) . "</td>";

                                        // Check if the bill has been paid
                                        $payment_time_query = "SELECT payment_time FROM Bills WHERE bill_id = '$bill_id'";
                                        $payment_time_result = mysqli_query($link, $payment_time_query);
                                        $has_payment_time = false;

                                        if ($payment_time_result && mysqli_num_rows($payment_time_result) > 0) {
                                            $payment_time_row = mysqli_fetch_assoc($payment_time_result);
                                            if (!empty($payment_time_row['payment_time'])) {
                                                $has_payment_time = true;
                                            }
                                        }

                                        // Display the "Add to Cart" button 
                                        if (!$has_payment_time && !$order_confirmed ) {
                                            echo '<td><form method="get" action="addItem.php">'
                                                . '<input type="text" hidden name= "table_id" value="' . $table_id . '">'
                                                . '<input type="text" name= "item_id" value=' . $row['item_id'] . ' hidden>'
                                                . '<input type="number" name= "bill_id" value=' . $bill_id . ' hidden>'
                                                . '<input type="number" name= "add_order" value= false hidden>'
                                                . '<input type="number" name="quantity" style="width:120px" placeholder="1 to 1000" required min="1" max="1000">'
                                                . '<input type="hidden" name="addToCart" value="1">'
                                                .'<textarea name="remark" rows="2" cols="20" placeholder="Remarks"></textarea>'
                                                . '<button type="submit" class="btn btn-primary">Add to Cart</button>';
                                            echo "</form></td>";
                                        } else {
                                            echo '<td> - </td>';
                                        }

                                        echo "</tr>";
                                    }

                                    // ...

                                    echo "</tbody>";
                                    echo "</table>";
                                } else {
                                    echo '<div class="alert alert-danger"><em>No menu items were found.</em></div>';
                                }
                            } else {
                                echo "Oops! Something went wrong. Please try again later.";
                            }
                            // Close connection
                            
                            ?>
                        </div>

                    </div>
                </div>
                <div class="col-md-4 order-md-2 m-1" id="cart-section" >
                    <div class="container-fluid pt-5 pl-600 pr-6 row mt-3" style="max-width: 200%; width:150%;">
                        <div class="cart-section" >
                            <h3>Cart</h3>
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Item ID</th>
                                    <th>Item Name</th>
                                    <th>Price (RM)</th>
                                    <th>Quantity</th>
                                    <th>Total (RM)</th>
                                    <th>Remark</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                
                                <div style="max-height: 40rem;overflow-y: auto;">
                                    <tbody>
                                    <?php
                                    // Query to fetch cart items for the given bill_id
                                    $cart_query = "SELECT bi.*, m.item_name, m.item_price FROM bill_items bi
                                                JOIN Menu m ON bi.item_id = m.item_id
                                                WHERE bi.bill_id = '$bill_id'";
                                    $cart_result = mysqli_query($link, $cart_query);
                                    $cart_total = 0;//cart total
                                    $tax = 0.1; // 10% tax rate
                                    

                                    if ($cart_result && mysqli_num_rows($cart_result) > 0) {
                                        while ($cart_row = mysqli_fetch_assoc($cart_result)) {
                                            $item_id = $cart_row['item_id'];
                                            $item_name = $cart_row['item_name'];
                                            $item_price = $cart_row['item_price'];
                                            $quantity = $cart_row['quantity'];
                                            $total = $item_price * $quantity;
                                            $_SESSION['total1'] = $total; //record total for validation
                                            $bill_item_id = $cart_row['bill_item_id'];
                                            $cart_total += $total;
                                            echo '<tr>';
                                            echo '<td>' . $item_id . '</td>';
                                            echo '<td>' . $item_name . '</td>';
                                            echo '<td>' . number_format($item_price,2) . '</td>';
                                            echo '<td>' . $quantity . '</td>';
                                            echo '<td> ' . number_format($total,2) . '</td>';
                                            //kitchen query
                                            $kitchen_query = "SELECT remarks FROM Kitchen WHERE bill_id = '$bill_id' AND time_ended IS NULL";
                                            $kitchen_result = mysqli_query($link, $kitchen_query);

                                            // Check if there are any remarks
                                            if ($kitchen_result && mysqli_num_rows($kitchen_result) > 0) {
                                                $remarkData = mysqli_fetch_assoc($kitchen_result)['remarks'];
                                                // Check if the remarks column is not null or empty
                                                if (!empty($remarkData)) {
                                                    // Remarks exist, display them
                                                    echo '<td>' . $remarkData . '</td>';
                                                } else {
                                                    // Remarks column is null or empty, show textarea for input
                                                    echo '<td> - </td>';
                                                }
                                            }else{
                                                echo '<td> - </td>';
                                            }
                                            
                                            // Check if the bill has been paid
                                            $payment_time_query = "SELECT payment_time FROM Bills WHERE bill_id = '$bill_id'";
                                            $payment_time_result = mysqli_query($link, $payment_time_query);
                                            $has_payment_time = false;

                                            if ($payment_time_result && mysqli_num_rows($payment_time_result) > 0) {
                                                $payment_time_row = mysqli_fetch_assoc($payment_time_result);
                                                if (!empty($payment_time_row['payment_time'])) {
                                                    $has_payment_time = true;
                                                }
                                            }

                                            // Display the "Delete" button if the bill hasn't been paid
                                            if (!$order_confirmed) {
                                                echo '<td><a class="btn btn-dark" href="deleteItem.php?bill_id=' . $bill_id . '&table_id=' . $table_id . '&bill_item_id=' . $bill_item_id . '&item_id=' . $item_id .'">Delete</a></td>';
                                            } else {
                                                echo '<td>End</td>';
                                            }
                                            echo '</tr>';
                                        }
                                    } else {
                                        echo '<tr><td colspan="6">No Items in Cart.</td></tr>';
                                    }
                                    ?>
                                    </tbody>
                                </div>
                            </table>
                            <hr>
                            <div class="table-responsive">
        <table class="table table-bordered ">
            <tbody>
                <tr>
                    <td><strong>Cart Total</strong></td>
                    <td>RM <?php echo number_format($cart_total, 2); ?></td>
                    
                </tr>
                <tr>
                    <td><strong>Cart Taxed</strong></td>
                    <td>RM <?php echo number_format($cart_total * $tax, 2); ?></td>
                </tr>
                <tr>
                    <td><strong>Grand Total</strong></td>
                    <td>RM <?php echo number_format(($tax * $cart_total) + $cart_total, 2); ?></td>
                </tr>
            </tbody>
        </table>
    </div>
    <?php
    $memberId = isset($_POST['memberId']) ? $_POST['memberId'] : '';
    ?>
    <form action="#" method="post">
        <div class="form-group">
            <label for="memberId">Member ID:</label>
            <div class="row">
                <div class="col-md-8">
                    <?php
                    // Check if the user is logged in
                    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
                        $_SESSION['memberId'] = $_SESSION['logged_customer_id'];
                        // If the user is logged in, display their member ID
                        echo '<input type="text" id="memberId" name="memberId" style="width:100%" class="form-control" value="' . htmlspecialchars($_SESSION['logged_customer_id']) . '" readonly>';
                    } else {
                        // If the user is not logged in, display an empty input field
                        echo '<input type="text" id="memberId" name="memberId" style="width:100%" class="form-control" value="" placeholder="Please register to get your points">';
                    }
                    ?>
                </div>
            </div>
            <?php
            // Check if the $checkValid flag is set to 1
            if ($checkValid == 1) {
                // If $checkValid is 1, display an error message
                echo '<div class="alert alert-danger mt-3" role="alert">Your record was not found.</div>';
            }
            ?>
        </div>
    </form> <br><br>

                            <?php 
                            
                            //echo "Cart Total: RM " . $cart_total;
                            //echo "<br>Cart Taxed: RM " . $cart_total * $tax;
                            //echo "<br>Grand Total: RM " . $tax * $cart_total + $cart_total;
                        
                            // Check if the payment time record exists for the bill
                            $payment_time_query = "SELECT payment_time FROM Bills WHERE bill_id = '$bill_id'";
                            $payment_time_result = mysqli_query($link, $payment_time_query);
                            $has_payment_time = false;

                            if ($payment_time_result && mysqli_num_rows($payment_time_result) > 0) {
                                $payment_time_row = mysqli_fetch_assoc($payment_time_result);
                                if (!empty($payment_time_row['payment_time'])) {
                                    $has_payment_time = true;
                                }
                            }

                            // If payment time record exists, show the "Print Receipt" button
                            if ($has_payment_time) {
                                echo '<div>';
                                echo '<div class="alert alert-success" role="alert">
                                        Bill has already been paid. Please call staff for assitant if you wanna order again
                                    </div>';
                                
                                
                            } elseif(($tax * $cart_total + $cart_total) > 0) {

                                if (!$order_confirmed){
                                    //if order not yet confirm
                                echo '<form id="confirm-order-form" method="get" action="addItem.php">';
                                echo' <input type="hidden" name="confirmOrder" value="1">';
                                echo '<input type="hidden" name="bill_id" value="' . $bill_id . '">';
                                echo '<input type="hidden" name="table_id" value="' . $table_id . '">';
                                echo '<input type="hidden" name= "add_order" value=true>';
                                echo '<input type="hidden" name="remark" id="hiddenRemark">';
                                echo '<input type="hidden" name="memberId" value="<?php echo htmlspecialchars($memberId); ?>">';
                                echo '<button type="submit" name="confirmOrder" class="btn btn-primary mb-3">Confirm Order</button>';
                                echo '</form>';

                                echo'<br><br> <p style="outline-style: solid;outline-color:red;">&nbspNote: If wanna change table please delete all the Item Cart and Click Change Table </p>';
                                }else{ 
                            // if order confirm, display button
                            echo '<div id="payment-buttons">';
                            echo '<br><a href="posCashPayment.php?bill_id=' . $bill_id . '&table_id=' . $table_id . ' &member_id=' . $memberId . '" class="btn btn-success">Online Transfer/ TNG</a>';
                            echo '&nbsp; <a href="posCardPayment.php?bill_id=' . $bill_id . '&table_id=' . $table_id . ' &member_id=' . $memberId . '" class="btn btn-success">Credit Card Payment</a>';
                            echo '<br>Note: If wanna pay by cash, Please go to counter';
                            echo '</div>';
                            echo '<script>localStorage.removeItem("remark");</script>';
                                }
                        }else{
                            echo '<br><h3>Start Order Your Cusine!</h3>';
                            echo'<a href="unset.php" class="btn btn-outline-primary">Change Table</a>';
                        }
                            ?>
                        </div>

                        
                        <?php 
                        if($has_payment_time){
                       echo '<form class="mt-3" action="newCustomerOrder.php" method="get">'; // Add this form element
                        echo '<input type="hidden" name="table_id" value="' . $table_id . '">';
                        echo '<button type="submit" name="new_customer" value="true" class="btn btn-warning">New Order</button>';
                        echo '</form>';
                        }
                    ?>
                    </div>

                </div>
            </div>
        </div>
        
    <?php include '../inc/dashFooter.php'; ?>

    <script>
    function updateHiddenInput(cartItemId) {
        // Construct the localStorage key for the remark using the cart item ID
        var remarkKey = 'remark-' + cartItemId;
        // Get the textarea value
        var textareaValue = document.getElementById("remark-" + cartItemId).value;
        // Store the textarea value in localStorage with the unique key
        localStorage.setItem(remarkKey, textareaValue);
    }

    // Load remarks for all items when the page loads
    window.onload = function() {
        <?php
        // Loop through each cart item and load its remark from localStorage
        $cart_result = mysqli_query($link, $cart_query);
        if ($cart_result && mysqli_num_rows($cart_result) > 0) {
            while ($cart_row = mysqli_fetch_assoc($cart_result)) {
                $bill_item_id = $cart_row['bill_item_id'];
                echo 'var savedRemark' . $bill_item_id . ' = localStorage.getItem("remark-' . $bill_item_id . '");';
                echo 'if (savedRemark' . $bill_item_id . ') {';
                echo 'document.getElementById("remark-' . $bill_item_id . '").value = savedRemark' . $bill_item_id . ';';
                echo '}';
            }
        }
        ?>
    }
    </script>


