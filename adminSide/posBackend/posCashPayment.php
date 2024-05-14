
<?php
session_start(); // Ensure session is started
?>
<?php
require_once '../config.php';
include '../inc/dashHeader.php'; 
$bill_id = $_GET['bill_id'];
$table_id = $_GET['table_id'];
if(!empty($_SESSION['memberId'])){
    $member_id = $_SESSION['memberId'];
    }else{
        $member_id = null;
    }

$member_discount_query = "SELECT points FROM memberships WHERE member_id = '$member_id'";
$member_discount_result = mysqli_query($link, $member_discount_query);

// Fetch membership points value
if ($member_discount_result && mysqli_num_rows($member_discount_result) > 0) {
    $member_discount_row = mysqli_fetch_assoc($member_discount_result);
    $member_point = $member_discount_row['points']; // Fetch the actual points value
} else {
    $member_point = 0; // Set default value if member ID not found or points not available
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-4">
                <div class="card-header">
                    <h3 class="card-title">Bill</h3>
                </div>
                <div class="card-body">
                    <h5>Bill ID: <?php echo $bill_id; ?></h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Item ID</th>
                                    <th>Item Name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
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
                    $bill_item_id = $cart_row['bill_item_id'];
                    $cart_total += $total;
                    $discount = 10;
                    echo '<tr>';
                    echo '<td>' . $item_id . '</td>';
                    echo '<td>' . $item_name . '</td>';
                    echo '<td>RM ' . $item_price . '</td>';
                    echo '<td>' . $quantity . '</td>';
                    echo '<td>RM ' . number_format($total,2) . '</td>';
                    echo '<td>' . $discount . '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="6">No Items in Cart.</td></tr>';
            }
            ?>
        </tbody>
                        </table>
                    </div>
                    <hr>
                    <div class="text-right">
                        <?php 
                        echo "<strong>Total:</strong> RM " . number_format($cart_total, 2) . "<br>";
                        echo "<strong>Tax (10%):</strong> RM " . number_format($cart_total * $tax, 2) . "<br>";
                        if($member_point >= 1000){
                            $GRANDTOTAL = $tax * $cart_total + $cart_total - $discount;
                            $GRANDTOTAL1 = $tax * $cart_total + $cart_total;
                            echo "<strong>Grand Total:</strong> RM " . number_format($GRANDTOTAL1, 2). "<br>";
                            echo "<strong>Discount:</strong> RM " . number_format($discount, 2). "<br>";
                            echo "<strong>After Discount Grand Total:</strong> RM " . number_format($GRANDTOTAL, 2). "<br>";
                            $update_member_point = "UPDATE memberships SET points = points - 1000 WHERE member_id = '$member_id'"; 
                                if (!mysqli_query($link, $update_member_point)) {
                                    echo "Error: " . mysqli_error($link);
                                }
                        }else{
                            $GRANDTOTAL = $tax * $cart_total + $cart_total;
                            echo "<strong>Grand Total:</strong> RM " . number_format($GRANDTOTAL, 2);
                        }
                        ?>
                    </div>

                </div>
            </div>
            
            

<div id="cash-payment" class="container-fluid mt-5 pt-5 pl-5 pr-5 mb-5">
    <div class="row">
        <div class="col-md-6">
            <h1>Total Payment</h1>
            <form action="" method="get">
                <div class="form-group">
                    <label for="payment_amount">Cash/ E-wallet/ Online Trasnfer are Accepted</label>
                    <input min="0" id="payment_amount" name="payment_amount" class="form-control" style="width: 150px;" placeholder="RM 12.34"required>
                </div>
                <?php $disabled = false;?>
                <!-- Add hidden input fields for bill_id, staff_id, member_id, and reservation_id -->
                <input type="hidden" name="bill_id" value="<?php echo $bill_id; ?>">

                <input type="hidden" name="table_id" value="<?php echo $table_id; ?>">
                
                <input type="hidden" name="GRANDTOTAL" value="<?php echo $tax * $cart_total + $cart_total; ?>">

                <button type="submit" id="cardSubmit" class="btn btn-dark mt-2" >Pay</button>
            </form>
        </div>
        <div class="col-md-6">
        <?php
        function calculateChange(float $paymentAmount, float $GrandTotal) {
            return $paymentAmount - $GrandTotal;
        }
        
        

        if (isset($_GET['payment_amount'])) {
            $payment_amount = isset($_GET['payment_amount']) ? floatval($_GET['payment_amount']) : 0.0;

            $billCheckQuery = "SELECT payment_time FROM Bills WHERE bill_id = $bill_id";
            $billCheckResult = $link->query($billCheckQuery);

            if ($billCheckResult) {
                if ($billCheckResult->num_rows > 0) {
                    $billRow = $billCheckResult->fetch_assoc();
                    if ($billRow['payment_time'] !== null) {
                        echo '<div class="alert alert-warning" role="alert">';
                        echo "Bill with ID $bill_id has already been paid.</div>";
                        echo '<br><a href="posTable.php" class="btn btn-dark">Back to Tables</a>';
                        echo '<br><a href="receipt.php?bill_id=' . $bill_id . '" class="btn btn-light">Print Receipt <span class="fa fa-receipt text-black"></span></a>';
                        exit; // Stop further execution
                    }
                }
            } else {
                echo "Error checking bill: " . $link->error;
                exit; // Stop further execution
            }

            if ($payment_amount >= $GRANDTOTAL) {
                echo '<div class="alert alert-dark" role="alert">';
                echo "Change is RM" . number_format(calculateChange($payment_amount, $GRANDTOTAL),2);
                echo '</div>';

                // Update the payment method, bill time, and other details in the Bills table
                $currentTime = date('Y-m-d H:i:s');
                if (!empty($member_id)) {
                    // If the customer is logged in, update member_id
                    $updateQuery = "UPDATE Bills SET payment_method = 'cash', payment_time = '$currentTime',
                                                staff_id = 0, member_id = $member_id, reservation_id = 0
                                                WHERE bill_id = $bill_id;";
                } else {
                    // If the customer is not logged in, set member_id to 0
                    $updateQuery = "UPDATE Bills SET payment_method = 'cash', payment_time = '$currentTime',
                                                staff_id = 0, member_id = 0, reservation_id = 0
                                                WHERE bill_id = $bill_id;";
                }
                
                // Update member points if member_id is not empty
                $points = intval($GRANDTOTAL);
                if ($link->query($updateQuery) === TRUE) {
                    if (!empty($member_id)) {
                    $update_points_sql = "UPDATE Memberships SET points = points + $points WHERE member_id = $member_id;";
                    unset($_SESSION['memberId']);
                    $link->query($update_points_sql);
                    echo '<div class="alert alert-success" role="alert">
                            Bill successfully Paid!
                            Your Point added Successfully.
                          </div>';
                          echo '<form class="mt-3" action="newCustomer.php" method="get">';
                          echo '<input type="hidden" name="table_id" value="' . $table_id . '">';
                          echo '<button type="submit" name="new_customer" value="true" class="btn btn-warning">Back To Table</button>';
                          echo '</form>';
                    echo '<a href="receipt.php?bill_id=' . $bill_id . '" class="btn btn-light">Print Receipt <span class="fa fa-receipt text-black"></span></a>';
                }else{
                    echo '<div class="alert alert-success" role="alert">
                            Bill successfully Paid!
                            You losing your points! Fast Register as member to get discount
                          </div>';
                          echo '<form class="mt-3" action="newCustomer.php" method="get">';
                          echo '<input type="hidden" name="table_id" value="' . $table_id . '">';
                          echo '<button type="submit" name="new_customer" value="true" class="btn btn-warning">Back To Table</button>';
                          echo '</form>';
                    echo '<a href="receipt.php?bill_id=' . $bill_id . '" class="btn btn-light">Print Receipt <span class="fa fa-receipt text-black"></span></a>';
                    unset($_SESSION['memberId']);
                }
            }else {
                    echo "Error updating bill: " . $link->error;
                }
                
            
            } else {
                echo '<div class="alert alert-warning" role="alert">
                        Payment amount is not sufficient
                      </div>';
                echo '<br><a href="posTable.php" class="btn btn-dark">Back to Tables</a>';
            }
        }
        
        ?>

    </div>
    </div>
    
</div>

<?php include '../inc/dashFooter.php'; ?>
