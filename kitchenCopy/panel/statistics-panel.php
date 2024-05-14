<?php
session_start(); // Ensure session is started
?>
<?php include '../inc/dashHeader.php'; 
require_once '../config.php';

// Get current date
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the selected date from the form
    $currentDate = $_POST['selected_date'];
    
    // Store the selected date in the session
    $_SESSION['selected_date'] = $currentDate;
} else {
    // If the form has not been submitted, use the default current date
    $currentDate = isset($_SESSION['selected_date']) ? $_SESSION['selected_date'] : date('d-m-Y');
    
}

// Calculate total revenue for today
$totalRevenueTodayQuery = "SELECT SUM(item_price * quantity) AS total_revenue FROM Bill_Items
                           INNER JOIN Menu ON Bill_Items.item_id = Menu.item_id
                           INNER JOIN Bills ON Bill_Items.bill_id = Bills.bill_id
                           WHERE DATE(Bills.bill_time) = '$currentDate'";
$totalRevenueTodayResult = mysqli_query($link, $totalRevenueTodayQuery);
$totalRevenueTodayRow = mysqli_fetch_assoc($totalRevenueTodayResult);
$totalRevenueToday = $totalRevenueTodayRow['total_revenue'];

// Calculate total revenue for this month
$totalRevenueThisMonthQuery = "SELECT SUM(item_price * quantity) AS total_revenue FROM Bill_Items
                              INNER JOIN Menu ON Bill_Items.item_id = Menu.item_id
                              INNER JOIN Bills ON Bill_Items.bill_id = Bills.bill_id
                              WHERE MONTH(Bills.bill_time) = MONTH('$currentDate')";
$totalRevenueThisMonthResult = mysqli_query($link, $totalRevenueThisMonthQuery);
$totalRevenueThisMonthRow = mysqli_fetch_assoc($totalRevenueThisMonthResult);
$totalRevenueThisMonth = $totalRevenueThisMonthRow['total_revenue'];

// Calculate total revenue for this Year
$totalRevenueThisYearQuery = "SELECT SUM(item_price * quantity) AS total_revenue FROM Bill_Items
                              INNER JOIN Menu ON Bill_Items.item_id = Menu.item_id
                              INNER JOIN Bills ON Bill_Items.bill_id = Bills.bill_id
                              WHERE YEAR(Bills.bill_time) = YEAR('$currentDate')";
$totalRevenueThisYearResult = mysqli_query($link, $totalRevenueThisYearQuery);
$totalRevenueThisYearRow = mysqli_fetch_assoc($totalRevenueThisYearResult);
$totalRevenueThisYear = $totalRevenueThisYearRow['total_revenue'];
?>



<div class="container-fluid">
    <div class="row">
        <div class="col-md-10 order-md-1 col" style="margin-top: 3rem; margin-left: 13rem;">
            <div class="container pt-5 pl-600 row">
                

                <?php
                require_once '../config.php';

                // Calculate total revenue
                $totalRevenueQuery = "SELECT SUM(item_price * quantity) AS total_revenue FROM Bill_Items
                                     INNER JOIN Menu ON Bill_Items.item_id = Menu.item_id";
                $totalRevenueResult = mysqli_query($link, $totalRevenueQuery);
                $totalRevenueRow = mysqli_fetch_assoc($totalRevenueResult);
                $totalRevenue = $totalRevenueRow['total_revenue'];
                ?>
                
                <div style="text-align: center;">
                    <h2>Revenue</h2>
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <label for="datepicker">Select Date:</label>
                        <input type="date" id="datepicker" name="selected_date" value="<?php echo isset($_SESSION['selected_date']) ? $_SESSION['selected_date'] : date('d-m-Y'); ?>">
                        <input type="submit" value="Submit">
                    </form>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Components</th>
                            <th scope="col">Amount (RM)</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <tr>
                            <th scope="row">Total Revenue in (<?php echo $currentDate?>) </th>
                            <td><?php echo number_format($totalRevenueToday, 2); ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Total Revenue (Month)</th>
                            <td><?php echo number_format($totalRevenueThisMonth, 2); ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Total Revenue (Year)</th>
                            <td><?php echo number_format($totalRevenueThisYear, 2); ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Total Revenue</th>
                            <td><?php echo number_format($totalRevenue, 2); ?></td>
                        </tr>
                    </tbody>
                </table>
                <a href="../report/generate_report.php" style="width: 10em;" class="btn btn-dark">Print Report</a>
                <div class="container pt-5 pl-600 row">
                    <div class="container pt-5 pl-600 ">
                        <!-- Bar Chart Payment Method -->
                        <div id="paymentMethodChart" style="width: 100%; max-width: 1200px; height: 500px;"></div>
                    </div>
                    <div class="container pt-5 pl-600 ">
                        <!-- Donut Chart Payment Method -->
                        <div id="paymentMethodDonutChart" style="width: 100%; max-width: 1200px; height: 500px;"></div>
                    </div>
                </div>         
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
// ...

<?php

$currentYearMonth = date('Y-m', strtotime($currentDate));

// Get the current month and year in the format 'YYYY-MM'

// Modify the SQL query to calculate card revenue for the current month
$cardQuery = "
    SELECT
        IFNULL(SUM(bi.quantity * m.item_price), 0) AS card_revenue
    FROM
        Bills b
    LEFT JOIN
        Bill_Items bi ON b.bill_id = bi.bill_id
    LEFT JOIN
        Menu m ON bi.item_id = m.item_id
    WHERE
        b.payment_method LIKE 'Card'
        AND MONTH(b.bill_time) = MONTH('$currentDate');
";

// Modify the SQL query to calculate cash revenue for the current month
$cashQuery = "
    SELECT
        IFNULL(SUM(bi.quantity * m.item_price), 0) AS cash_revenue
    FROM
        Bills b
    LEFT JOIN
        Bill_Items bi ON b.bill_id = bi.bill_id
    LEFT JOIN
        Menu m ON bi.item_id = m.item_id
    WHERE
        b.payment_method LIKE 'Cash'
        AND MONTH(b.bill_time) = MONTH('$currentDate');
";

$cardResult = $link->query($cardQuery);
$cashResult = $link->query($cashQuery);

if ($cardResult->num_rows > 0) {
    $cardRow = $cardResult->fetch_assoc();
    $cardRevenue = $cardRow['card_revenue'];
} else {
    $cardRevenue = 0;
}

if ($cashResult->num_rows > 0) {
    $cashRow = $cashResult->fetch_assoc();
    $cashRevenue = $cashRow['cash_revenue'];
} else {
    $cashRevenue = 0;
}
?>

<script>
// Load the Google Charts library
google.charts.load('current', { packages: ['corechart'] });
google.charts.setOnLoadCallback(paymentMethodCharts);

function paymentMethodCharts() {
  // Create the data table for bar chart
  const barChartData = new google.visualization.DataTable();
  barChartData.addColumn('string', 'Payment Method');
  barChartData.addColumn('number', 'Revenue(RM)');
  barChartData.addRows([
    ['Credit Card', <?php echo $cardRevenue; ?>],
    ['Cash/ Online Payment', <?php echo $cashRevenue; ?>]
  ]);

  // Create the data table for donut chart
  const donutChartData = new google.visualization.DataTable();
  donutChartData.addColumn('string', 'Payment Method');
  donutChartData.addColumn('number', 'Revenue (RM)');
  donutChartData.addRows([
    ['Credit Card', <?php echo $cardRevenue; ?>],
    ['Cash/ Online Payment', <?php echo $cashRevenue; ?>]
  ]);

  // Set chart options for both charts
  const barChartOptions = {
    title: 'Revenue Generated in (<?php echo $currentYearMonth; ?>)',
    bars: 'vertical'
  };

  const donutChartOptions = {
    title: 'Revenue Percentage in (<?php echo $currentYearMonth; ?>)',
    pieHole: 0.4
  };

  // Instantiate and draw the charts
  const barChart = new google.visualization.BarChart(document.getElementById('paymentMethodChart'));
  barChart.draw(barChartData, barChartOptions);

  const donutChart = new google.visualization.PieChart(document.getElementById('paymentMethodDonutChart'));
  donutChart.draw(donutChartData, donutChartOptions);
}

</script>


