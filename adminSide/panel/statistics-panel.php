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
                            <th scope="row">Total Revenue From Start to Present</th>
                            <td><?php echo number_format($totalRevenue, 2); ?></td>
                        </tr>
                    </tbody>
                </table>
                <a href="../report/generate_report.php" style="width: 10em;" class="btn btn-dark">Print Report</a>

                <div class="container pt-5 pl-600 row">
                    <!--<div class="container pt-5 pl-600 ">
                         Bar Chart Payment Method 
                        <div id="paymentMethodChart" style="width: 100%; max-width: 1200px; height: 500px;"></div>
                    </div> -->
                    <div class="container pt-5 pl-600 ">
                        <hr>
                        <h2>Payment Method Usage</h2>
                        <!-- Donut Chart Payment Method -->
                        <div id="paymentMethodDonutChart" style="width: 100%; max-width: 1200px; height: 500px;"></div>
                        <hr>
                    </div>
                    <div class="container pt-5 pl-600 ">
                        <!-- Line Chart Payment Method -->
                        <h2>Monthly</h2>
                        <div id="totalRevenueChart" style="width: 100%; max-width: 1200px; height: 500px;"></div>
                        <hr>
                    </div>
                    <div class="container pt-5 pl-600 ">
                        <!-- Donut Chart Payment Method -->
                        <h2>Yearly</h2>
                        <div id="revenueComparisonChart" style="width: 100%; max-width: 1200px; height: 500px;"></div>
                        <hr>
                    </div>
                    
                </div>         
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
// ...

<?php
// Define the number of years you want to display
$numYears = 5;
$revenueByYear = [];
$revenueByMonth = [];

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

for ($i = 0; $i < $numYears; $i++) {
    // Calculate the year to query data for
    $year = date('Y') - $i;

    // Modify the SQL query to calculate total revenue for the current year
    $yearQuery = "
        SELECT
            IFNULL(SUM(bi.quantity * m.item_price), 0) AS year_revenue
        FROM
            Bills b
        LEFT JOIN
            Bill_Items bi ON b.bill_id = bi.bill_id
        LEFT JOIN
            Menu m ON bi.item_id = m.item_id
        WHERE
            YEAR(b.bill_time) = $year;
    ";

    // Execute the query and fetch the result
    $yearResult = $link->query($yearQuery);

    // Fetch the revenue data for the current year
    $yearRow = $yearResult->fetch_assoc();
    $revenueByYear[$year] = $yearRow['year_revenue'];
}

for ($i = 1; $i <= 12; $i++) {
    // Modify the SQL query to calculate total revenue for the current month
    $monthQuery = "
        SELECT
            IFNULL(SUM(bi.quantity * m.item_price), 0) AS month_revenue
        FROM
            Bills b
        LEFT JOIN
            Bill_Items bi ON b.bill_id = bi.bill_id
        LEFT JOIN
            Menu m ON bi.item_id = m.item_id
        WHERE
            MONTH(b.bill_time) = $i
            AND YEAR(b.bill_time) = YEAR('$currentDate');
    ";

    $monthResult = $link->query($monthQuery);

    $monthRow = $monthResult->fetch_assoc();
    $revenueByMonth[$i] = $monthRow['month_revenue'];
}

$currentYear = date('Y');
$startYear = $currentYear - ($numYears - 1);

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
 // const barChartData = new google.visualization.DataTable();
 // barChartData.addColumn('string', 'Payment Method');
 // barChartData.addColumn('number', 'Revenue(RM)');
 // barChartData.addRows([
 //   ['Credit Card', <?php echo $cardRevenue; ?>],
 //   ['Cash/ Online Payment', <?php echo $cashRevenue; ?>]
 // ]);

  // Create the data table for donut chart
  const donutChartData = new google.visualization.DataTable();
  donutChartData.addColumn('string', 'Payment Method');
  donutChartData.addColumn('number', 'Revenue (RM)');
  donutChartData.addRows([
    ['Credit Card', <?php echo $cardRevenue; ?>],
    ['Cash/ Online Payment', <?php echo $cashRevenue; ?>]
  ]);

  // Create the data table for column chart
  const columnChartData = new google.visualization.DataTable();
  columnChartData.addColumn('string', 'Year');
  columnChartData.addColumn('number', 'Revenue (RM)');
  columnChartData.addRows([
        <?php
        // Loop through the revenue data for each year
        foreach ($revenueByYear as $year => $revenue) {
            // Output the revenue data for the current year
            echo "['$year', $revenue],";
        }
        ?>
    ]);

    // Create the data table for line chart
  const lineChartData = new google.visualization.DataTable();
  lineChartData.addColumn('string', 'Month');
  lineChartData.addColumn('number', 'Total Revenue (RM)');
  lineChartData.addRows([
  <?php
    $months = ['', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    // Loop through the revenue data for each month
    for ($i = 1; $i <= 12; $i++) {
        // Check if revenue data is available for the current month
        if (isset($revenueByMonth[$i])) {
            // Revenue data is available for this month
            echo "['" . $months[$i] . "', " . $revenueByMonth[$i] . "],";
        } else {
            // Revenue data is not available for this month
            // You might want to add a zero value or skip the month
            echo "['" . $months[$i] . "', 0],";
        }
    }
  ?>
]);
  // Set chart options for both charts
  //const barChartOptions = {
  //  title: 'Revenue Generated in (<?php echo $currentYearMonth; ?>)',
  // bars: 'vertical'
  //};

  const donutChartOptions = {
    title: 'Revenue Percentage in (<?php echo $currentYearMonth; ?>)',
    pieHole: 0.4
  };

  const columnChartOptions = {
  title: 'Revenue Comparison From Year: <?php echo $startYear; ?> to <?php echo $currentYear; ?>',
  bars: 'vertical'
  };

  const lineChartOptions = {
  title: 'Monthly Revenue in <?php echo $currentYear; ?>',
  width: 1200,
  height: 500
  };

  // Instantiate and draw the charts
 // const barChart = new google.visualization.BarChart(document.getElementById('paymentMethodChart'));
 // barChart.draw(barChartData, barChartOptions);

  const donutChart = new google.visualization.PieChart(document.getElementById('paymentMethodDonutChart'));
  if (<?php echo $cardRevenue; ?> > 0 || <?php echo $cashRevenue; ?> > 0) {
            donutChart.draw(donutChartData, donutChartOptions);
        } else {
            document.getElementById('paymentMethodDonutChart').innerHTML = 'No data';
        }

  // Instantiate and draw the column chart
  const columnChart = new google.visualization.ColumnChart(document.getElementById('revenueComparisonChart'));
  if (<?php echo count($revenueByYear); ?> > 0) {
            columnChart.draw(columnChartData, columnChartOptions);
        } else {
            document.getElementById('revenueComparisonChart').innerHTML = 'No data';
        }

  // Instantiate and draw the line chart
  const lineChart = new google.visualization.LineChart(document.getElementById('totalRevenueChart'));
  if (<?php echo count($revenueByYear); ?> > 0) {
            lineChart.draw(lineChartData, lineChartOptions);
        } else {
            document.getElementById('totalRevenueChart').innerHTML = 'No data';
        }
}

</script>


