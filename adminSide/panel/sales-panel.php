<?php
session_start(); // Ensure session is started
?>
<?php 
include '../inc/dashHeader.php'; 
require_once '../config.php';

// Get current date
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the selected date from the form
    $currentDate = $_POST['selected_date'];
    
    // Store the selected date in the session
    $_SESSION['stat_selected_date'] = $currentDate;
} else {
    // If the form has not been submitted, use the default current date
    $currentDate = isset($_SESSION['stat_selected_date']) ? $_SESSION['stat_selected_date'] : date('d-m-Y');
    
}

$currentMonthStart = date('Y-m-01');
$currentMonthEnd = date('Y-m-t');

// Get the current month and year in the format 'YYYY-MM'
$currentMonth = date('Y-m', strtotime($currentDate));


?>

<div class="row">
        <div class="col-md-10 order-md-2" style="margin-top: 3rem; margin-left: 14rem;">
            <div class="container-fluid pt-5  row">
            <h3>Most Purchased Items</h3>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <label for="datepicker">Select Date:</label>
                        <input type="date" id="datepicker" name="selected_date" value="<?php echo isset($_SESSION['stat_selected_date']) ? $_SESSION['stat_selected_date'] : date('d-m-Y'); ?>">
                        <input type="submit" value="Submit">
                    </form>

            <!-- Sorting form and button -->
             <div class="col d-flex justify-content-end">
                 
                 <!-- 
                <a href="?sortOrder=desc" class=" btn btn-primary">Most</a>

                <a href="?sortOrder=asc" class=" btn btn-primary">Least</a>
                Ascending sort button -->
            </div>
            <div>
                <?php
                // Get the sorting order from the form or use default (ascending)
                $sortOrder = isset($_GET['sortOrder']) ? $_GET['sortOrder'] : 'desc';

                // Get the first and last day of the current month
                

                // Modify the SQL query for menu item sales to consider the current month
                $menuItemSalesQuery = "SELECT Menu.item_name, SUM(Bill_Items.quantity) AS total_quantity
                                       FROM Bill_Items
                                       INNER JOIN Menu ON Bill_Items.item_id = Menu.item_id
                                       INNER JOIN Bills ON Bill_Items.bill_id = Bills.bill_id
                                       WHERE DATE(Bills.bill_time) = '$currentDate'
                                       GROUP BY Menu.item_name
                                       ORDER BY total_quantity $sortOrder";

                $menuItemSalesResult = mysqli_query($link, $menuItemSalesQuery);

                if (mysqli_num_rows($menuItemSalesResult) > 0) {
                echo '<table class="table" >';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Item Name</th>';
                echo '<th>Units</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';

                while ($row = mysqli_fetch_assoc($menuItemSalesResult)) {
                    echo '<tr>';
                    echo '<td>' . $row['item_name'] . '</td>';
                    echo '<td>' . $row['total_quantity'] . '</td>';
                    echo '</tr>';
                }

                echo '</tbody>';
                echo '</table>';
            } else {
                // Display "No data" message if no data is available
                echo '<div style="text-align: center;margin-top:100px">No data</div>';
            }
                ?>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-10 order-md-1 col" style="margin-top: 3rem; margin-left: 5rem;">
            <div class="container pt-3 row">
                <!-- Add a div for Google Charts -->
                <div id="mostPurchased" style="width: 113%; max-width: 1000px; height: 500px;"></div>
            </div>
            <div class="container pt-3 row">
                <!-- Add a div for Google Charts -->
                <div id="mostPurchasedMain" style="width: 113%; max-width: 1000px; height: 500px;"></div>
            </div>
            <div class="container pt-3 row">
                <!-- Add a div for Google Charts -->
                <div id="mostPurchasedDrinks" style="width: 113%; max-width: 1000px; height: 500px;"></div>
            </div>
            <div class="container pt-3 row">
                <!-- Add a div for Google Charts -->
                <div id="mostPurchasedSide" style="width: 113%; max-width: 1000px; height: 500px;"></div>
            </div>
            <div class="container pt-3 row">
                <!-- Add a div for Google Charts -->
                <div id="mostPurchasedYear" style="width: 113%; max-width: 1000px; height: 500px;"></div>
            </div>
        </div>
    </div>
</div>



<!-- Load Google Charts library -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
    google.charts.load('current', {'packages': ['corechart']});
    google.charts.setOnLoadCallback(mostPurchasedChart);
    google.charts.setOnLoadCallback(mostPurchasedDrinksChart);
    google.charts.setOnLoadCallback(mostPurchasedMainChart);
    google.charts.setOnLoadCallback(mostPurchasedSideChart);
    google.charts.setOnLoadCallback(mostPurchasedYearChart);

    function mostPurchasedChart() {
        const data = google.visualization.arrayToDataTable([
            ['Item Name', 'Total Quantity'],
            <?php
            $topPurchasedItemsQuery = "SELECT Menu.item_name, SUM(Bill_Items.quantity) AS total_quantity
                                        FROM Bill_Items
                                        INNER JOIN Menu ON Bill_Items.item_id = Menu.item_id
                                        INNER JOIN Bills ON Bill_Items.bill_id = Bills.bill_id
                                        WHERE MONTH(Bills.bill_time) = MONTH('$currentDate')
                                        GROUP BY Menu.item_name
                                        ORDER BY total_quantity DESC
                                        LIMIT 10";
            $topPurchasedItemsResult = mysqli_query($link, $topPurchasedItemsQuery);

            while ($row = mysqli_fetch_assoc($topPurchasedItemsResult)) {
                echo "['{$row['item_name']}', {$row['total_quantity']}],";
            }
            ?>
        ]);

        const options = {
            titleTextStyle: {
                fontSize: 20, // 12, 18 whatever you want (don't specify px)
                bold: true    // true or false
            },
            title: 'Top 10 Most Purchased Items - <?php echo  $currentMonth; ?>',
            is3D: true
        };

        const chart = new google.visualization.PieChart(document.getElementById('mostPurchased'));
        chart.draw(data, options);
    }
    function mostPurchasedDrinksChart() {
        const dataDrinks = google.visualization.arrayToDataTable([
            ['Item Name', 'Total Quantity'],
            <?php
            $topPurchasedDrinksQuery = "SELECT Menu.item_name, SUM(Bill_Items.quantity) AS total_quantity
                                        FROM Bill_Items
                                        INNER JOIN Menu ON Bill_Items.item_id = Menu.item_id
                                        INNER JOIN Bills ON Bill_Items.bill_id = Bills.bill_id
                                        WHERE MONTH(Bills.bill_time) = MONTH('$currentDate')
                                        AND Menu.item_category = 'Drinks'
                                        GROUP BY Menu.item_name
                                        ORDER BY total_quantity DESC
                                        LIMIT 10";
            $topPurchasedItemsResult = mysqli_query($link, $topPurchasedDrinksQuery);

            while ($row = mysqli_fetch_assoc($topPurchasedItemsResult)) {
                echo "['{$row['item_name']}', {$row['total_quantity']}],";
            }
            ?>
        ]);

        const options = {
            titleTextStyle: {
                fontSize: 20, // 12, 18 whatever you want (don't specify px)
                bold: true    // true or false
            },
            title: 'Top 10 Most Purchased Drinks - <?php echo $currentMonth; ?>',
            is3D: true
        };

        const chart = new google.visualization.PieChart(document.getElementById('mostPurchasedDrinks'));
        chart.draw(dataDrinks, options);
    }
    function mostPurchasedMainChart() {
        const dataMainD = google.visualization.arrayToDataTable([
            ['Item Name', 'Total Quantity'],
            <?php
            $topPurchasedMainDishesQuery = "SELECT Menu.item_name, SUM(Bill_Items.quantity) AS total_quantity
                                            FROM Bill_Items
                                            INNER JOIN Menu ON Bill_Items.item_id = Menu.item_id
                                            INNER JOIN Bills ON Bill_Items.bill_id = Bills.bill_id
                                            WHERE MONTH(Bills.bill_time) = MONTH('$currentDate')
                                            AND Menu.item_category = 'Main Dishes'
                                            GROUP BY Menu.item_name
                                            ORDER BY total_quantity DESC
                                            LIMIT 10";
            $topPurchasedItemsResult = mysqli_query($link, $topPurchasedMainDishesQuery);

            while ($row = mysqli_fetch_assoc($topPurchasedItemsResult)) {
                echo "['{$row['item_name']}', {$row['total_quantity']}],";
            }
            ?>
        ]);

        const options = {
            titleTextStyle: {
                fontSize: 20, // 12, 18 whatever you want (don't specify px)
                bold: true    // true or false
            },
            title: 'Top 10 Most Purchased Main Dishes - <?php echo $currentMonth; ?>',
            is3D: true
        };

        const chart = new google.visualization.PieChart(document.getElementById('mostPurchasedMain'));
        chart.draw(dataMainD, options);
    }
    function mostPurchasedSideChart() {
        const dataSideD = google.visualization.arrayToDataTable([
            ['Item Name', 'Total Quantity'],
            <?php
            $topPurchasedSideSnacksQuery = "SELECT Menu.item_name, SUM(Bill_Items.quantity) AS total_quantity
                                            FROM Bill_Items
                                            INNER JOIN Menu ON Bill_Items.item_id = Menu.item_id
                                            INNER JOIN Bills ON Bill_Items.bill_id = Bills.bill_id
                                            WHERE MONTH(Bills.bill_time) = MONTH('$currentDate')
                                            AND Menu.item_category = 'Side Snacks'
                                            GROUP BY Menu.item_name
                                            ORDER BY total_quantity DESC
                                            LIMIT 10";
            $topPurchasedItemsResult = mysqli_query($link, $topPurchasedSideSnacksQuery);

            while ($row = mysqli_fetch_assoc($topPurchasedItemsResult)) {
                echo "['{$row['item_name']}', {$row['total_quantity']}],";
            }
            ?>
        ]);

        const options = {
            titleTextStyle: {
                fontSize: 20, // 12, 18 whatever you want (don't specify px)
                bold: true    // true or false
            },
            title: 'Top 10 Most Purchased Side Snacks - <?php echo $currentMonth; ?>',
            is3D: true
        };

        const chart = new google.visualization.PieChart(document.getElementById('mostPurchasedSide'));
        chart.draw(dataSideD, options);
    }

    function mostPurchasedYearChart() {
        const dataYear = google.visualization.arrayToDataTable([
            ['Item Name', 'Total Quantity'],
            <?php
            $topPurchasedMainDishesQuery = "SELECT Menu.item_name, SUM(Bill_Items.quantity) AS total_quantity
                                            FROM Bill_Items
                                            INNER JOIN Menu ON Bill_Items.item_id = Menu.item_id
                                            INNER JOIN Bills ON Bill_Items.bill_id = Bills.bill_id
                                            WHERE Year(Bills.bill_time) = Year('$currentDate')
                                            GROUP BY Menu.item_name
                                            ORDER BY total_quantity DESC
                                            LIMIT 10";
            $topPurchasedItemsResult = mysqli_query($link, $topPurchasedMainDishesQuery);

            while ($row = mysqli_fetch_assoc($topPurchasedItemsResult)) {
                echo "['{$row['item_name']}', {$row['total_quantity']}],";
            }
            ?>
        ]);

        const options = {
            titleTextStyle: {
                fontSize: 20, // 12, 18 whatever you want (don't specify px)
                bold: true    // true or false
            },
            title: 'Top 10 Most Purchased Item In  - <?php echo date('Y'); ?>',
            is3D: true
        };

        const chart = new google.visualization.PieChart(document.getElementById('mostPurchasedYear'));
        chart.draw(dataYear, options);
    }
</script>
