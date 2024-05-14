

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Seating</title>
    <!-- Add Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Yellowtail' rel='stylesheet'>
</head>
<body>

<div class="container mt-5 text-center">
    <?php
    require_once '../config.php';

    if (isset($_GET['new_customer']) && $_GET['new_customer'] === 'true') {
        $table_id = $_GET['table_id'];
        $bill_time = date('Y-m-d H:i:s');
        $insertQuery = "INSERT INTO Bills (table_id, bill_time) VALUES ('$table_id', '$bill_time')";

        if ($link->query($insertQuery) === TRUE) {
            $bill_id = $link->insert_id;
            echo "<h2 style=\"font-family: 'Yellowtail'; font-size: 60px;\">My Bubble Time Cafe Restaurant</h2>";
            echo "<img src='thankyou.png' alt='Thank You'width='500px' height='500px'>";
            echo "<br>";
            echo '<a href="orderItem.php?bill_id=' . $bill_id . '&table_id=' . $table_id . '&add_order=false" class="btn btn-primary me-3">Order Again</a>';
            echo '<a href="../customerSide/home/home.php" class="btn btn-success me-3">Home</a>';
        } else {
            echo "<div class='alert alert-danger'>Error inserting data into Bills table: " . $link->error . "</div>";
        }
    }
    ?>

</div>

<!-- Add Bootstrap JS and jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
