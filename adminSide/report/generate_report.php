<?php
session_start();
require('../posBackend/fpdf186/fpdf.php'); // Include the FPDF library
// Include your database configuration
require_once '../config.php';
function executeQuery($link, $sql) {
    $result = $link->query($sql);
    if ($result === false) {
        echo "Error: " . $link->error;
        return null;
    }
    return $result;
}

// Function to retrieve revenue breakdown by item category
// Function to retrieve revenue breakdown by item category
function getCategoryRevenue($link, $sql) {
    return executeQuery($link, $sql);
}
class PDF extends FPDF
{
    function Sector($xc, $yc, $r, $a, $b, $style='FD', $cw=true, $o=90)
    {
        $d0 = $a - $b;
        if($cw){
            $d = $b;
            $b = $o - $a;
            $a = $o - $d;
        }else{
            $b += $o;
            $a += $o;
        }
        while($a<0)
            $a += 360;
        while($a>360)
            $a -= 360;
        while($b<0)
            $b += 360;
        while($b>360)
            $b -= 360;
        if ($a > $b)
            $b += 360;
        $b = $b/360*2*M_PI;
        $a = $a/360*2*M_PI;
        $d = $b - $a;
        if ($d == 0 && $d0 != 0)
            $d = 2*M_PI;
        $k = $this->k;
        $hp = $this->h;
        if (sin($d/2))
            $MyArc = 4/3*(1-cos($d/2))/sin($d/2)*$r;
        else
            $MyArc = 0;
        //first put the center
        $this->_out(sprintf('%.2F %.2F m',($xc)*$k,($hp-$yc)*$k));
        //put the first point
        $this->_out(sprintf('%.2F %.2F l',($xc+$r*cos($a))*$k,(($hp-($yc-$r*sin($a)))*$k)));
        //draw the arc
        if ($d < M_PI/2){
            $this->_Arc($xc+$r*cos($a)+$MyArc*cos(M_PI/2+$a),
                        $yc-$r*sin($a)-$MyArc*sin(M_PI/2+$a),
                        $xc+$r*cos($b)+$MyArc*cos($b-M_PI/2),
                        $yc-$r*sin($b)-$MyArc*sin($b-M_PI/2),
                        $xc+$r*cos($b),
                        $yc-$r*sin($b)
                        );
        }else{
            $b = $a + $d/4;
            $MyArc = 4/3*(1-cos($d/8))/sin($d/8)*$r;
            $this->_Arc($xc+$r*cos($a)+$MyArc*cos(M_PI/2+$a),
                        $yc-$r*sin($a)-$MyArc*sin(M_PI/2+$a),
                        $xc+$r*cos($b)+$MyArc*cos($b-M_PI/2),
                        $yc-$r*sin($b)-$MyArc*sin($b-M_PI/2),
                        $xc+$r*cos($b),
                        $yc-$r*sin($b)
                        );
            $a = $b;
            $b = $a + $d/4;
            $this->_Arc($xc+$r*cos($a)+$MyArc*cos(M_PI/2+$a),
                        $yc-$r*sin($a)-$MyArc*sin(M_PI/2+$a),
                        $xc+$r*cos($b)+$MyArc*cos($b-M_PI/2),
                        $yc-$r*sin($b)-$MyArc*sin($b-M_PI/2),
                        $xc+$r*cos($b),
                        $yc-$r*sin($b)
                        );
            $a = $b;
            $b = $a + $d/4;
            $this->_Arc($xc+$r*cos($a)+$MyArc*cos(M_PI/2+$a),
                        $yc-$r*sin($a)-$MyArc*sin(M_PI/2+$a),
                        $xc+$r*cos($b)+$MyArc*cos($b-M_PI/2),
                        $yc-$r*sin($b)-$MyArc*sin($b-M_PI/2),
                        $xc+$r*cos($b),
                        $yc-$r*sin($b)
                        );
            $a = $b;
            $b = $a + $d/4;
            $this->_Arc($xc+$r*cos($a)+$MyArc*cos(M_PI/2+$a),
                        $yc-$r*sin($a)-$MyArc*sin(M_PI/2+$a),
                        $xc+$r*cos($b)+$MyArc*cos($b-M_PI/2),
                        $yc-$r*sin($b)-$MyArc*sin($b-M_PI/2),
                        $xc+$r*cos($b),
                        $yc-$r*sin($b)
                        );
        }
        //terminate drawing
        if($style=='F')
            $op='f';
        elseif($style=='FD' || $style=='DF')
            $op='b';
        else
            $op='s';
        $this->_out($op);
    }
    function _Arc($x1, $y1, $x2, $y2, $x3, $y3 )
    {
        $h = $this->h;
        $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c',
            $x1*$this->k,
            ($h-$y1)*$this->k,
            $x2*$this->k,
            ($h-$y2)*$this->k,
            $x3*$this->k,
            ($h-$y3)*$this->k));
    }
    function Header()
    {
        $this->SetFont('Arial', 'B', 20);
        $this->Cell(0, 10, "My Bubble Time Cafe Report", 0, 1, 'C');
        $this->Ln(6); // Decreased spacing here
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }

    function ChapterTitle($title)
    {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, $title, 0, 1, 'L');
        $this->Ln(2); // Decreased spacing here
    }

    function ChapterBody($body)
    {
        $this->SetFont('Arial', '', 12);
        $this->MultiCell(0, 6, $body); // Decreased line height here
        $this->Ln(2); // Decreased spacing here
    }

    function CustomTable($header, $data)
    {
        // Column widths
        $w = array(90, 90);
        
        // Header
        $this->SetFillColor(200, 200, 200);
        $this->SetFont('Arial', 'B');
        for ($i = 0; $i < count($header); $i++) {
            $this->Cell($w[$i], 10, $header[$i], 1, 0, 'C', true);
        }
        $this->Ln();
        
        // Data
        $this->SetFont('Arial', '');
        foreach ($data as $row) {
            for ($i = 0; $i < count($row); $i++) {
                $this->Cell($w[$i], 10, $row[$i], 1);
            }
            $this->Ln();
        }
    }
    
    function CustomTableThreeColumn($header, $data)
    {
        $this->SetFont('Arial', 'B', 12);
        foreach ($header as $col) {
            $this->Cell(50, 10, $col, 1);
        }
        $this->Ln();

        $this->SetFont('Arial', '', 12);
        foreach ($data as $row) {
            foreach ($row as $col) {
                $this->Cell(50, 10, $col, 1);
            }
            $this->Ln();
        }
    }
    
    function CustomTableFourColumn($header, $data)
{
    $columnWidths = array(30, 40, 50, 70); // Adjust the column widths as needed

    $this->SetFont('Arial', 'B', 12);
    for ($i = 0; $i < count($header); $i++) {
        $this->Cell($columnWidths[$i], 10, $header[$i], 1);
    }
    $this->Ln();

    $this->SetFont('Arial', '', 12);
    foreach ($data as $row) {
        for ($i = 0; $i < count($row); $i++) {
            $this->Cell($columnWidths[$i], 10, $row[$i], 1);
        }
        $this->Ln();
    }
}

}

$pdf = new PDF();


$pdf->AddPage();

// Get monthly revenue breakdown 
$kitchenQuery = "SELECT 
    CONCAT(YEAR(time_ended), '-', LPAD(MONTH(time_ended), 2, '0')) AS year_and_month,
    COUNT(*) AS total_items_cooked,
    SUM(quantity) AS total_quantity,
    AVG(TIMESTAMPDIFF(MINUTE, time_submitted, time_ended)) AS average_cook_time
    
FROM 
    Kitchen
WHERE 
    YEAR(time_ended) = YEAR(NOW()) AND MONTH(time_ended) BETWEEN 1 AND 12
GROUP BY 
    YEAR(time_ended), MONTH(time_ended);
";

$kitchenResult = getCategoryRevenue($link, $kitchenQuery);
// Display the revenue breakdown by item category in a tabular format
$pdf->ChapterTitle('Kitchen Data Monthly');
$header = array('Month','Items Cooked' , 'Total Quantity');
$data = array();
while ($row = mysqli_fetch_assoc($kitchenResult)) {
    $data[] = array($row['year_and_month'],$row['total_items_cooked'] , $row['total_quantity']);
}
$pdf->CustomTableFourColumn($header, $data);


$pdf->Ln();





$pdf->Ln();

// Set the current date
$currentDate = $_SESSION['selected_date'];

// Calculate total revenue for today
$totalRevenueTodayQuery = "SELECT SUM(item_price * quantity) AS total_revenue FROM Bill_Items
                        INNER JOIN Menu ON Bill_Items.item_id = Menu.item_id
                        INNER JOIN Bills ON Bill_Items.bill_id = Bills.bill_id
                        WHERE DATE(Bills.bill_time) = '$currentDate'";
$totalRevenueTodayResult = mysqli_query($link, $totalRevenueTodayQuery);

if (!$totalRevenueTodayResult) {
    die("Query failed: " . mysqli_error($link));
}

$totalRevenueTodayRow = mysqli_fetch_assoc($totalRevenueTodayResult);
$totalRevenueToday = $totalRevenueTodayRow['total_revenue'];

// Comment out or remove the debugging echo statement
// echo "Total Revenue Today: " . $totalRevenueToday;

// Daily Report
$pdf->ChapterTitle('Daily Report');
$pdf->ChapterBody("Date: " . $currentDate . "\n");
$pdf->ChapterBody("Total Revenue Today: RM " . number_format($totalRevenueToday, 2));
$pdf->Ln();




// Calculate total revenue for this month
$currentMonthStart = date('Y-m-01');
$totalRevenueThisMonthQuery = "SELECT SUM(item_price * quantity) AS total_revenue FROM Bill_Items
                              INNER JOIN Menu ON Bill_Items.item_id = Menu.item_id
                              INNER JOIN Bills ON Bill_Items.bill_id = Bills.bill_id
                              WHERE DATE(Bills.bill_time) >= '$currentMonthStart'";
$totalRevenueThisMonthResult = mysqli_query($link, $totalRevenueThisMonthQuery);

if (!$totalRevenueThisMonthResult) {
    die("Query failed: " . mysqli_error($link));
}

$totalRevenueThisMonthRow = mysqli_fetch_assoc($totalRevenueThisMonthResult);
$totalRevenueThisMonth = $totalRevenueThisMonthRow['total_revenue'];

// Monthly Report
$pdf->ChapterTitle('Monthly Report');
$pdf->ChapterBody("Date Range: " . $currentMonthStart . " to " . date('Y-m-t'));
$pdf->ChapterBody("Total Revenue This Month: RM " . number_format($totalRevenueThisMonth, 2));
$pdf->Ln();

// Calculate total revenue for this year
$currentYear = date('Y');
$totalRevenueThisYearQuery = "SELECT SUM(item_price * quantity) AS total_revenue FROM Bill_Items
                             INNER JOIN Menu ON Bill_Items.item_id = Menu.item_id
                             INNER JOIN Bills ON Bill_Items.bill_id = Bills.bill_id
                             WHERE YEAR(Bills.bill_time) = '$currentYear'";
$totalRevenueThisYearResult = mysqli_query($link, $totalRevenueThisYearQuery);

if (!$totalRevenueThisYearResult) {
    die("Query failed: " . mysqli_error($link));
}

$totalRevenueThisYearRow = mysqli_fetch_assoc($totalRevenueThisYearResult);
$totalRevenueThisYear = $totalRevenueThisYearRow['total_revenue'];

// Yearly Report
$pdf->ChapterTitle('Yearly Report');
$pdf->ChapterBody("Date Range: " . $currentYear . "-01-01 to " . $currentYear . "-12-31");
$pdf->ChapterBody("Total Revenue This Year: RM " . number_format($totalRevenueThisYear, 2));
$pdf->Ln();


$pdf->AddPage();
// Get daily revenue breakdown 
$dailySQL = "SELECT DATE(Bills.bill_time) AS date,DAY(Bills.bill_time) AS day, SUM(Bill_Items.quantity * Menu.item_price) AS daily_category_revenue
             FROM Bills
             JOIN Bill_Items ON Bills.bill_id = Bill_Items.bill_id
             JOIN Menu ON Bill_Items.item_id = Menu.item_id
             GROUP BY DATE(Bills.bill_time),DAY(Bills.bill_time)    
             ORDER BY date DESC
             LIMIT 30";
$dailyCategoryRevenue = getCategoryRevenue($link, $dailySQL);
// Display the revenue breakdown by item category in a tabular format
$pdf->ChapterTitle('Daily Revenue Breakdown');
$header = array('Date', 'Revenue (RM)');
$data = array();
while ($row = mysqli_fetch_assoc($dailyCategoryRevenue)) {
    $data[] = array($row['date'], $row['daily_category_revenue']);
}
$pdf->CustomTableThreeColumn($header, $data);

$pdf->AddPage();

// Get monthly revenue breakdown 
$monthlySQL = "SELECT CONCAT(YEAR(Bills.bill_time), '-', MONTH(Bills.bill_time)) AS year, MONTH(Bills.bill_time) AS month, SUM(Bill_Items.quantity * Menu.item_price) AS monthly_category_revenue
               FROM Bills
               JOIN Bill_Items ON Bills.bill_id = Bill_Items.bill_id
               JOIN Menu ON Bill_Items.item_id = Menu.item_id
               GROUP BY YEAR(Bills.bill_time), MONTH(Bills.bill_time)
               ORDER BY year DESC
                LIMIT 15";
$monthlySQLChart = "SELECT CONCAT(YEAR(Bills.bill_time), '-', MONTH(Bills.bill_time)) AS year, MONTH(Bills.bill_time) AS month, SUM(Bill_Items.quantity * Menu.item_price) AS monthly_category_revenue
                FROM Bills
                JOIN Bill_Items ON Bills.bill_id = Bill_Items.bill_id
                JOIN Menu ON Bill_Items.item_id = Menu.item_id
                GROUP BY YEAR(Bills.bill_time), MONTH(Bills.bill_time)
                ORDER BY monthly_category_revenue DESC
                 LIMIT 4";
$monthlyCategoryRevenue = getCategoryRevenue($link, $monthlySQL);
$monthlyCategoryRevenueChart = getCategoryRevenue($link, $monthlySQLChart);
// Display the revenue breakdown by item category in a tabular format
$pdf->ChapterTitle('Monthly Revenue Breakdown');
$header = array('Month', 'Revenue (RM)');
$data = array();
while ($row = mysqli_fetch_assoc($monthlyCategoryRevenue)) {
    $data[] = array($row['year'], $row['monthly_category_revenue']);
}
$pdf->CustomTableThreeColumn($header, $data);

$pdf->AddPage();


$pdf->ChapterTitle('Top 4Monthly Revenue Breakdown in Bar Chart');

//position
$chartX=25;
$chartY=50;

//dimension
$chartWidth=160;
$chartHeight=100;

//padding
$chartTopPadding=10;
$chartLeftPadding=20;
$chartBottomPadding=20;
$chartRightPadding=5;

//chart box
$chartBoxX=$chartX+$chartLeftPadding;
$chartBoxY=$chartY+$chartTopPadding;
$chartBoxWidth=$chartWidth-$chartLeftPadding-$chartRightPadding;
$chartBoxHeight=$chartHeight-$chartBottomPadding-$chartTopPadding;

//bar width
$barWidth=20;

//$dataMax
$dataMax=0;

foreach($monthlyCategoryRevenueChart as $item){
	if($item['monthly_category_revenue']>$dataMax)$dataMax=$item['monthly_category_revenue'];
   
}

//data step
$dataStep=500;

//set font, line width and color
$pdf->SetFont('Arial','',9);
$pdf->SetLineWidth(0.2);
$pdf->SetDrawColor(0);


//vertical axis line
$pdf->Line(
	$chartBoxX ,
	$chartBoxY , 
	$chartBoxX , 
	($chartBoxY+$chartBoxHeight)
	);
//horizontal axis line
$pdf->Line(
	$chartBoxX-2 , 
	($chartBoxY+$chartBoxHeight) , 
	$chartBoxX+($chartBoxWidth) , 
	($chartBoxY+$chartBoxHeight)
	);

///vertical axis
//calculate chart's y axis scale unit
$yAxisUnits=$chartBoxHeight/$dataMax;

//draw the vertical (y) axis labels
for($i=0 ; $i<=$dataMax ; $i+=$dataStep){
	//y position
	$yAxisPos=$chartBoxY+($yAxisUnits*$i);
	//draw y axis line
	$pdf->Line(
		$chartBoxX-2 ,
		$yAxisPos ,
		$chartBoxX ,
		$yAxisPos
	);
	//set cell position for y axis labels
	$pdf->SetXY($chartBoxX-$chartLeftPadding , $yAxisPos-2);
	//$pdf->Cell($chartLeftPadding-4 , 5 , $dataMax-$i , 1);---------------
	$pdf->Cell($chartLeftPadding-4 , 5 , $dataMax-$i, 0 , 0 , 'R');
}

///horizontal axis
//set cells position
$pdf->SetXY($chartBoxX , $chartBoxY+$chartBoxHeight);

//cell's width
$xLabelWidth=$chartBoxWidth / 4;

//$pdf->Cell($xLabelWidth , 5 , $itemName , 1 , 0 , 'C');-------------
// Define an array of colors
$colors = array(
    array(255, 0, 0),   // Red
    array(0, 255, 0),   // Lime
    array(0, 0, 255),   // Blue
    array(128,128,0),   // Olive
    array(0,128,0),   // Green
    array(128,0,0),   // Maroon
    array(255,0,255),   // Magenta
    array(255,255,0),   // Yellow
    array(0,255,255),   // Cyan
    array(128,128,128),   // Grey
    array(128,0,128),   // Purple
    array(0,0,128),   //Naby Blue
);
//loop horizontal axis and draw the bar
$barXPos=0;
$colorIndex = 0;
foreach($monthlyCategoryRevenueChart as $item) {
    // Determine the label
    $xLabel =  $item['year'];
    // Print the label
    $pdf->Cell($xLabelWidth, 5, $xLabel, 0, 0, 'C');
	
    // Drawing the bar
    // Calculate bar height
    $barHeight = $yAxisUnits * $item['monthly_category_revenue'];
    // Calculate bar x position
    $barX = ($xLabelWidth / 2) + ($xLabelWidth * $barXPos);
    $barX = $barX - ($barWidth / 2);
    $barX = $barX + $chartBoxX;
    // Calculate bar y position
    $barY = $chartBoxHeight - $barHeight;
    $barY = $barY + $chartBoxY;
    // Set fill color for the bar using color from the array
    $pdf->SetFillColor($colors[$colorIndex][0], $colors[$colorIndex][1], $colors[$colorIndex][2]);
    // Draw the bar with fill color
    $pdf->Rect($barX, $barY, $barWidth, $barHeight, 'DF');
    // Increase color index for the next bar
    $colorIndex = ($colorIndex + 1) % count($colors); // Loop back to the beginning if all colors are used
    // Increase x position for the next bar
    $barXPos++;
}

//axis labels
$pdf->SetFont('Arial','B',12);
$pdf->SetXY($chartX,$chartY);
$pdf->Cell(100,10,"Revenue(RM)",0);
$pdf->SetXY(($chartWidth/2)-50+$chartX,$chartY+$chartHeight-($chartBottomPadding/2));
$pdf->Cell(100,5,"Month",0,0,'C');

$pdf->AddPage();

// Get yearly revenue breakdown 
$yearlySQL = "SELECT YEAR(Bills.bill_time) AS year, SUM(Bill_Items.quantity * Menu.item_price) AS yearly_category_revenue
              FROM Bills
              JOIN Bill_Items ON Bills.bill_id = Bill_Items.bill_id
              JOIN Menu ON Bill_Items.item_id = Menu.item_id
              GROUP BY YEAR(Bills.bill_time)
              ORDER BY year DESC";
$yearlySQLChart = "SELECT YEAR(Bills.bill_time) AS year, SUM(Bill_Items.quantity * Menu.item_price) AS yearly_category_revenue
                FROM Bills
                JOIN Bill_Items ON Bills.bill_id = Bill_Items.bill_id
                JOIN Menu ON Bill_Items.item_id = Menu.item_id
                GROUP BY YEAR(Bills.bill_time)
              ORDER BY yearly_category_revenue DESC
              LIMIT 4";

$yearlyCategoryRevenue = getCategoryRevenue($link, $yearlySQL);
$yearlyCategoryRevenueChart = getCategoryRevenue($link, $yearlySQLChart);

// Display the revenue breakdown by year in a tabular format
$pdf->ChapterTitle('Yearly Revenue Breakdown');
$header = array('Year', 'Revenue (RM)');
$data = array();
foreach($yearlyCategoryRevenue as $item) {
    $data[] = array($item['year'], $item['yearly_category_revenue']);
}
$pdf->CustomTableThreeColumn($header, $data);

$pdf->AddPage();

$pdf->ChapterTitle('Top 4 Yearly Revenue Breakdown in Bar Chart');

//position
$chartX=25;
$chartY=50;

//dimension
$chartWidth=160;
$chartHeight=100;

//padding
$chartTopPadding=10;
$chartLeftPadding=20;
$chartBottomPadding=20;
$chartRightPadding=5;

//chart box
$chartBoxX=$chartX+$chartLeftPadding;
$chartBoxY=$chartY+$chartTopPadding;
$chartBoxWidth=$chartWidth-$chartLeftPadding-$chartRightPadding;
$chartBoxHeight=$chartHeight-$chartBottomPadding-$chartTopPadding;

//bar width
$barWidth=20;

//$dataMax
$dataMax=0;

foreach($yearlyCategoryRevenueChart as $item){
	if($item['yearly_category_revenue']>$dataMax)$dataMax=$item['yearly_category_revenue'];
   
}

//data step
$dataStep=500;

//set font, line width and color
$pdf->SetFont('Arial','',9);
$pdf->SetLineWidth(0.2);
$pdf->SetDrawColor(0);


//vertical axis line
$pdf->Line(
	$chartBoxX ,
	$chartBoxY , 
	$chartBoxX , 
	($chartBoxY+$chartBoxHeight)
	);
//horizontal axis line
$pdf->Line(
	$chartBoxX-2 , 
	($chartBoxY+$chartBoxHeight) , 
	$chartBoxX+($chartBoxWidth) , 
	($chartBoxY+$chartBoxHeight)
	);

///vertical axis
//calculate chart's y axis scale unit
$yAxisUnits=$chartBoxHeight/$dataMax;

//draw the vertical (y) axis labels
for($i=0 ; $i<=$dataMax ; $i+=$dataStep){
	//y position
	$yAxisPos=$chartBoxY+($yAxisUnits*$i);
	//draw y axis line
	$pdf->Line(
		$chartBoxX-2 ,
		$yAxisPos ,
		$chartBoxX ,
		$yAxisPos
	);
	//set cell position for y axis labels
	$pdf->SetXY($chartBoxX-$chartLeftPadding , $yAxisPos-2);
	//$pdf->Cell($chartLeftPadding-4 , 5 , $dataMax-$i , 1);---------------
	$pdf->Cell($chartLeftPadding-4 , 5 , $dataMax-$i, 0 , 0 , 'R');
}

///horizontal axis
//set cells position
$pdf->SetXY($chartBoxX , $chartBoxY+$chartBoxHeight);

//cell's width
$xLabelWidth=$chartBoxWidth / 4;

//$pdf->Cell($xLabelWidth , 5 , $itemName , 1 , 0 , 'C');-------------
// Define an array of colors
$colors = array(
    array(255, 0, 0),   // Red
    array(0, 255, 0),   // Lime
    array(0, 0, 255),   // Blue
    array(128,128,0),   // Olive
    array(0,128,0),   // Green
    array(128,0,0),   // Maroon
    array(255,0,255),   // Magenta
    array(255,255,0),   // Yellow
    array(0,255,255),   // Cyan
    array(128,128,128),   // Grey
    array(128,0,128),   // Purple
    array(0,0,128),   //Naby Blue
);
//loop horizontal axis and draw the bar
$barXPos=0;
$colorIndex = 0;
foreach($yearlyCategoryRevenueChart as $item) {
    // Determine the label
    $xLabel = $item['year'];
    // Print the label
    $pdf->Cell($xLabelWidth, 5, $xLabel, 0, 0, 'C');
	
    // Drawing the bar
    // Calculate bar height
    $barHeight = $yAxisUnits * $item['yearly_category_revenue'];
    // Calculate bar x position
    $barX = ($xLabelWidth / 2) + ($xLabelWidth * $barXPos);
    $barX = $barX - ($barWidth / 2);
    $barX = $barX + $chartBoxX;
    // Calculate bar y position
    $barY = $chartBoxHeight - $barHeight;
    $barY = $barY + $chartBoxY;
    // Set fill color for the bar using color from the array
    $pdf->SetFillColor($colors[$colorIndex][0], $colors[$colorIndex][1], $colors[$colorIndex][2]);
    // Draw the bar with fill color
    $pdf->Rect($barX, $barY, $barWidth, $barHeight, 'DF');
    // Increase color index for the next bar
    $colorIndex = ($colorIndex + 1) % count($colors); // Loop back to the beginning if all colors are used
    // Increase x position for the next bar
    $barXPos++;
}

//axis labels
$pdf->SetFont('Arial','B',12);
$pdf->SetXY($chartX,$chartY);
$pdf->Cell(100,10,"Revenue(RM)",0);
$pdf->SetXY(($chartWidth/2)-50+$chartX,$chartY+$chartHeight-($chartBottomPadding/2));
$pdf->Cell(100,5,"Years",0,0,'C');

// ------------------------------
$pdf->AddPage();

//CATEGORY


// Get daily revenue breakdown by item category
$dailySQL = "SELECT DATE(Bills.bill_time) AS date,DAY(Bills.bill_time) AS day ,Menu.item_category, SUM(Bill_Items.quantity * Menu.item_price) AS daily_category_revenue
             FROM Bills
             JOIN Bill_Items ON Bills.bill_id = Bill_Items.bill_id
             JOIN Menu ON Bill_Items.item_id = Menu.item_id
             GROUP BY DATE(Bills.bill_time),DAY(Bills.bill_time), Menu.item_category
             ORDER BY date DESC
             LIMIT 15";


// Get monthly revenue breakdown by item category
$monthlySQL = "SELECT CONCAT(YEAR(Bills.bill_time), '-', MONTH(Bills.bill_time)) AS year, MONTH(Bills.bill_time) AS month, Menu.item_category, SUM(Bill_Items.quantity * Menu.item_price) AS monthly_category_revenue
               FROM Bills
               JOIN Bill_Items ON Bills.bill_id = Bill_Items.bill_id
               JOIN Menu ON Bill_Items.item_id = Menu.item_id
               GROUP BY YEAR(Bills.bill_time), MONTH(Bills.bill_time), Menu.item_category
               ORDER BY year DESC
                LIMIT 15";

$monthlySQLChart = "SELECT CONCAT(YEAR(Bills.bill_time), '-', MONTH(Bills.bill_time)) AS year, MONTH(Bills.bill_time) AS month, Menu.item_category, SUM(Bill_Items.quantity * Menu.item_price) AS monthly_category_revenue
               FROM Bills
               JOIN Bill_Items ON Bills.bill_id = Bill_Items.bill_id
               JOIN Menu ON Bill_Items.item_id = Menu.item_id
               GROUP BY YEAR(Bills.bill_time), MONTH(Bills.bill_time), Menu.item_category
               ORDER BY monthly_category_revenue DESC
                LIMIT 4";

// Get yearly revenue breakdown by item category
$yearlySQL = "SELECT YEAR(Bills.bill_time) AS year, Menu.item_category, SUM(Bill_Items.quantity * Menu.item_price) AS yearly_category_revenue
              FROM Bills
              JOIN Bill_Items ON Bills.bill_id = Bill_Items.bill_id
              JOIN Menu ON Bill_Items.item_id = Menu.item_id
              GROUP BY YEAR(Bills.bill_time), Menu.item_category
               ORDER BY year DESC
                LIMIT 15";

$yearlySQLChart = "SELECT YEAR(Bills.bill_time) AS year, Menu.item_category, SUM(Bill_Items.quantity * Menu.item_price) AS yearly_category_revenue
                FROM Bills
                JOIN Bill_Items ON Bills.bill_id = Bill_Items.bill_id
                JOIN Menu ON Bill_Items.item_id = Menu.item_id
                GROUP BY YEAR(Bills.bill_time), Menu.item_category
                ORDER BY yearly_category_revenue DESC
                LIMIT 4";


$dailyCategoryRevenue = getCategoryRevenue($link, $dailySQL);

$monthlyCategoryRevenue = getCategoryRevenue($link, $monthlySQL);
$monthlyCategoryRevenueChart = getCategoryRevenue($link, $monthlySQLChart);
$yearlyCategoryRevenue = getCategoryRevenue($link, $yearlySQL);
$yearlyCategoryRevenueChart = getCategoryRevenue($link, $yearlySQLChart);



// Display the revenue breakdown by item category in a tabular format
$pdf->ChapterTitle('Daily Revenue Breakdown by Item Category');
$header = array('Month', 'Item Category', 'Revenue (RM)');
$data = array();
while ($row = mysqli_fetch_assoc($dailyCategoryRevenue)) {
    $data[] = array($row['date'], $row['item_category'], $row['daily_category_revenue']);
}
$pdf->CustomTableFourColumn($header, $data);



$pdf->AddPage();
$pdf->Ln();

// Display the revenue breakdown by item category in a tabular format
$pdf->ChapterTitle('Monthly Revenue Breakdown by Item Category');
$header = array('Month', 'Item Category', 'Revenue (RM)');
$data = array();
while ($row = mysqli_fetch_assoc($monthlyCategoryRevenue)) {
    $data[] = array($row['year'], $row['item_category'], $row['monthly_category_revenue']);
}
$pdf->CustomTableFourColumn($header, $data);


while ($row = mysqli_fetch_assoc($monthlyCategoryRevenueChart)) {
    $data[] = array($row['year'], $row['item_category'], $row['monthly_category_revenue']);
}
$pdf->AddPage();

$pdf->ChapterTitle('Top 4 Monthly Revenue Breakdown by Item Category in Bar Chart');

//position
$chartX=25;
$chartY=50;

//dimension
$chartWidth=160;
$chartHeight=100;

//padding
$chartTopPadding=10;
$chartLeftPadding=20;
$chartBottomPadding=20;
$chartRightPadding=5;

//chart box
$chartBoxX=$chartX+$chartLeftPadding;
$chartBoxY=$chartY+$chartTopPadding;
$chartBoxWidth=$chartWidth-$chartLeftPadding-$chartRightPadding;
$chartBoxHeight=$chartHeight-$chartBottomPadding-$chartTopPadding;

//bar width
$barWidth=20;

//$dataMax
$dataMax=0;

foreach($monthlyCategoryRevenueChart as $item){
	if($item['monthly_category_revenue']>$dataMax)$dataMax=$item['monthly_category_revenue'];
   
}

//data step
$dataStep=500;

//set font, line width and color
$pdf->SetFont('Arial','',9);
$pdf->SetLineWidth(0.2);
$pdf->SetDrawColor(0);


//vertical axis line
$pdf->Line(
	$chartBoxX ,
	$chartBoxY , 
	$chartBoxX , 
	($chartBoxY+$chartBoxHeight)
	);
//horizontal axis line
$pdf->Line(
	$chartBoxX-2 , 
	($chartBoxY+$chartBoxHeight) , 
	$chartBoxX+($chartBoxWidth) , 
	($chartBoxY+$chartBoxHeight)
	);

///vertical axis
//calculate chart's y axis scale unit
$yAxisUnits=$chartBoxHeight/$dataMax;

//draw the vertical (y) axis labels
for($i=0 ; $i<=$dataMax ; $i+=$dataStep){
	//y position
	$yAxisPos=$chartBoxY+($yAxisUnits*$i);
	//draw y axis line
	$pdf->Line(
		$chartBoxX-2 ,
		$yAxisPos ,
		$chartBoxX ,
		$yAxisPos
	);
	//set cell position for y axis labels
	$pdf->SetXY($chartBoxX-$chartLeftPadding , $yAxisPos-2);
	//$pdf->Cell($chartLeftPadding-4 , 5 , $dataMax-$i , 1);---------------
	$pdf->Cell($chartLeftPadding-4 , 5 , $dataMax-$i, 0 , 0 , 'R');
}

///horizontal axis
//set cells position
$pdf->SetXY($chartBoxX , $chartBoxY+$chartBoxHeight);

//cell's width
$xLabelWidth=$chartBoxWidth / 4;

//$pdf->Cell($xLabelWidth , 5 , $itemName , 1 , 0 , 'C');-------------
// Define an array of colors
$colors = array(
    array(255, 0, 0),   // Red
    array(0, 255, 0),   // Lime
    array(0, 0, 255),   // Blue
    array(128,128,0),   // Olive
    array(0,128,0),   // Green
    array(128,0,0),   // Maroon
    array(255,0,255),   // Magenta
    array(255,255,0),   // Yellow
    array(0,255,255),   // Cyan
    array(128,128,128),   // Grey
    array(128,0,128),   // Purple
    array(0,0,128),   //Naby Blue
);
//loop horizontal axis and draw the bar
$barXPos=0;
$colorIndex = 0;
foreach($monthlyCategoryRevenueChart as $item) {
    // Determine the label
    $xLabel = $item['item_category'] . ' (' . $item['year'] . ')';
    // Print the label
    $pdf->Cell($xLabelWidth, 5, $xLabel, 0, 0, 'C');
	
    // Drawing the bar
    // Calculate bar height
    $barHeight = $yAxisUnits * $item['monthly_category_revenue'];
    // Calculate bar x position
    $barX = ($xLabelWidth / 2) + ($xLabelWidth * $barXPos);
    $barX = $barX - ($barWidth / 2);
    $barX = $barX + $chartBoxX;
    // Calculate bar y position
    $barY = $chartBoxHeight - $barHeight;
    $barY = $barY + $chartBoxY;
    // Set fill color for the bar using color from the array
    $pdf->SetFillColor($colors[$colorIndex][0], $colors[$colorIndex][1], $colors[$colorIndex][2]);
    // Draw the bar with fill color
    $pdf->Rect($barX, $barY, $barWidth, $barHeight, 'DF');
    // Increase color index for the next bar
    $colorIndex = ($colorIndex + 1) % count($colors); // Loop back to the beginning if all colors are used
    // Increase x position for the next bar
    $barXPos++;
}

//axis labels
$pdf->SetFont('Arial','B',12);
$pdf->SetXY($chartX,$chartY);
$pdf->Cell(100,10,"Revenue(RM)",0);
$pdf->SetXY(($chartWidth/2)-50+$chartX,$chartY+$chartHeight-($chartBottomPadding/2));
$pdf->Cell(100,5,"Month",0,0,'C');

$pdf->AddPage();
// Display the revenue breakdown by item category in a tabular format
$pdf->ChapterTitle('Yearly Revenue Breakdown by Item Category');
$header = array('Year', 'Item Category', 'Revenue (RM)');
$data = array();
while ($row = mysqli_fetch_assoc($yearlyCategoryRevenue)) {
    $data[] = array($row['year'], $row['item_category'], $row['yearly_category_revenue']);
}
$pdf->CustomTableThreeColumn($header, $data);

$pdf->AddPage();


$pdf->ChapterTitle('Top 4 Yearly Revenue Breakdown by Item Category in Bar Chart');

//position
$chartX=25;
$chartY=50;

//dimension
$chartWidth=160;
$chartHeight=100;

//padding
$chartTopPadding=10;
$chartLeftPadding=20;
$chartBottomPadding=20;
$chartRightPadding=5;

//chart box
$chartBoxX=$chartX+$chartLeftPadding;
$chartBoxY=$chartY+$chartTopPadding;
$chartBoxWidth=$chartWidth-$chartLeftPadding-$chartRightPadding;
$chartBoxHeight=$chartHeight-$chartBottomPadding-$chartTopPadding;

//bar width
$barWidth=20;

//$dataMax
$dataMax=0;

foreach($yearlyCategoryRevenueChart as $item){
	if($item['yearly_category_revenue']>$dataMax)$dataMax=$item['yearly_category_revenue'];
   
}

//data step
$dataStep=500;

//set font, line width and color
$pdf->SetFont('Arial','',9);
$pdf->SetLineWidth(0.2);
$pdf->SetDrawColor(0);


//vertical axis line
$pdf->Line(
	$chartBoxX ,
	$chartBoxY , 
	$chartBoxX , 
	($chartBoxY+$chartBoxHeight)
	);
//horizontal axis line
$pdf->Line(
	$chartBoxX-2 , 
	($chartBoxY+$chartBoxHeight) , 
	$chartBoxX+($chartBoxWidth) , 
	($chartBoxY+$chartBoxHeight)
	);

///vertical axis
//calculate chart's y axis scale unit
$yAxisUnits=$chartBoxHeight/$dataMax;

//draw the vertical (y) axis labels
for($i=0 ; $i<=$dataMax ; $i+=$dataStep){
	//y position
	$yAxisPos=$chartBoxY+($yAxisUnits*$i);
	//draw y axis line
	$pdf->Line(
		$chartBoxX-2 ,
		$yAxisPos ,
		$chartBoxX ,
		$yAxisPos
	);
	//set cell position for y axis labels
	$pdf->SetXY($chartBoxX-$chartLeftPadding , $yAxisPos-2);
	//$pdf->Cell($chartLeftPadding-4 , 5 , $dataMax-$i , 1);---------------
	$pdf->Cell($chartLeftPadding-4 , 5 , $dataMax-$i, 0 , 0 , 'R');
}

///horizontal axis
//set cells position
$pdf->SetXY($chartBoxX , $chartBoxY+$chartBoxHeight);

//cell's width
$xLabelWidth=$chartBoxWidth / 4;

//$pdf->Cell($xLabelWidth , 5 , $itemName , 1 , 0 , 'C');-------------
// Define an array of colors
$colors = array(
    array(255, 0, 0),   // Red
    array(0, 255, 0),   // Lime
    array(0, 0, 255),   // Blue
    array(128,128,0),   // Olive
    array(0,128,0),   // Green
    array(128,0,0),   // Maroon
    array(255,0,255),   // Magenta
    array(255,255,0),   // Yellow
    array(0,255,255),   // Cyan
    array(128,128,128),   // Grey
    array(128,0,128),   // Purple
    array(0,0,128),   //Naby Blue
);
//loop horizontal axis and draw the bar
$barXPos=0;
$colorIndex = 0;
foreach($yearlyCategoryRevenueChart as $item) {
    // Determine the label
    $xLabel = $item['item_category'] . ' (' . $item['year'] . ')';
    // Print the label
    $pdf->Cell($xLabelWidth, 5, $xLabel, 0, 0, 'C');
	
    // Drawing the bar
    // Calculate bar height
    $barHeight = $yAxisUnits * $item['yearly_category_revenue'];
    // Calculate bar x position
    $barX = ($xLabelWidth / 2) + ($xLabelWidth * $barXPos);
    $barX = $barX - ($barWidth / 2);
    $barX = $barX + $chartBoxX;
    // Calculate bar y position
    $barY = $chartBoxHeight - $barHeight;
    $barY = $barY + $chartBoxY;
    // Set fill color for the bar using color from the array
    $pdf->SetFillColor($colors[$colorIndex][0], $colors[$colorIndex][1], $colors[$colorIndex][2]);
    // Draw the bar with fill color
    $pdf->Rect($barX, $barY, $barWidth, $barHeight, 'DF');
    // Increase color index for the next bar
    $colorIndex = ($colorIndex + 1) % count($colors); // Loop back to the beginning if all colors are used
    // Increase x position for the next bar
    $barXPos++;
}

//axis labels
$pdf->SetFont('Arial','B',12);
$pdf->SetXY($chartX,$chartY);
$pdf->Cell(100,10,"Revenue(RM)",0);
$pdf->SetXY(($chartWidth/2)-50+$chartX,$chartY+$chartHeight-($chartBottomPadding/2));
$pdf->Cell(100,5,"Years",0,0,'C');











$pdf->AddPage();
$pdf->Ln();
$currentMonthEnd = date('Y-m-t');  // Last day of the current month
$sortOrder = 'DESC';  // Default sort order

// Modify the SQL query for menu item sales to consider the current month
$menuItemSalesQuery = "SELECT Menu.item_name AS item_name, SUM(Bill_Items.quantity) AS total_quantity
                       FROM Bill_Items
                       INNER JOIN Menu ON Bill_Items.item_id = Menu.item_id
                       INNER JOIN Bills ON Bill_Items.bill_id = Bills.bill_id
                       WHERE Bills.bill_time BETWEEN '$currentMonthStart 00:00:00' AND '$currentMonthEnd 23:59:59'
                       GROUP BY item_name
                       ORDER BY total_quantity $sortOrder
                       LIMIT 10";


$menuItemSalesResult = mysqli_query($link, $menuItemSalesQuery);

$menuItemSalesResultData = array();
while ($row = mysqli_fetch_assoc($menuItemSalesResult)) {
    $menuItemSalesResultData[] = array($row['item_name'], $row['total_quantity']);
}
$pdf->ChapterBody("10 Most Ordered Items this Month ( "  . $currentMonthStart . " - " . $currentMonthEnd . " ) :\n");
$pdf->CustomTable(array('Category', 'Quantity'), $menuItemSalesResultData);
$sortOrder = 'ASC';  // Default sort order
// Modify the SQL query for menu item sales to consider the current month
$menuItemSalesLeastQuery = "SELECT Menu.item_name AS item_name, SUM(Bill_Items.quantity) AS total_quantity
                       FROM Bill_Items
                       INNER JOIN Menu ON Bill_Items.item_id = Menu.item_id
                       INNER JOIN Bills ON Bill_Items.bill_id = Bills.bill_id
                       WHERE Bills.bill_time BETWEEN '$currentMonthStart 00:00:00' AND '$currentMonthEnd 23:59:59'
                       GROUP BY item_name
                       ORDER BY total_quantity $sortOrder
                       LIMIT 10";


$menuItemSalesLeastResult = mysqli_query($link, $menuItemSalesLeastQuery);
$pdf->AddPage();
$menuItemSalesLeastResultData = array();
while ($row = mysqli_fetch_assoc($menuItemSalesLeastResult)) {
    $menuItemSalesLeastResultData[] = array($row['item_name'], $row['total_quantity']);
}
$pdf->Ln();
$pdf->ChapterBody("10 Least Ordered Items this Month ( "  . $currentMonthStart . " - " . $currentMonthEnd . " ) :\n");
$pdf->CustomTable(array('Category', 'Quantity'), $menuItemSalesLeastResultData);
$pdf->AddPage();
//not ordered
$menuItemNoOrdersQuery = "SELECT
    Menu.item_name,
    0 AS total_quantity
FROM
    Menu
WHERE NOT EXISTS (
    SELECT 1
    FROM Bill_Items
    WHERE Menu.item_id = Bill_Items.item_id
);

";


$menuItemNoOrdersResult = mysqli_query($link, $menuItemNoOrdersQuery);

$menuItemNoOrdersResultData = array();
while ($row = mysqli_fetch_assoc($menuItemNoOrdersResult)) {
    $menuItemNoOrdersResultData[] = array($row['item_name'], $row['total_quantity']);
}
$pdf->Ln();
$pdf->ChapterBody("All Items with no Orders this Month ( "  . $currentMonthStart . " - " . $currentMonthEnd . " ) :\n");
$pdf->CustomTable(array('Category', 'Quantity'), $menuItemNoOrdersResultData);

$pdf->AddPage();
//not ordered
$menuItemNoOrdersQuery = "SELECT
    Menu.item_name,
    0 AS total_quantity
FROM
    Menu
WHERE NOT EXISTS (
    SELECT 1
    FROM Bill_Items
    JOIN Bills ON Bill_Items.bill_id = Bills.bill_id
    WHERE Menu.item_id = Bill_Items.item_id
    AND YEAR(Bills.bill_time) = YEAR($currentDate) -- Check for orders within the current year
);
";


$menuItemNoOrdersResult = mysqli_query($link, $menuItemNoOrdersQuery);

$menuItemNoOrdersResultData = array();
while ($row = mysqli_fetch_assoc($menuItemNoOrdersResult)) {
    $menuItemNoOrdersResultData[] = array($row['item_name'], $row['total_quantity']);
}
$pdf->Ln();
$pdf->ChapterBody("All Items with no Orders this Year ( "  . date('Y', strtotime($currentDate)) . " ) :\n");
$pdf->CustomTable(array('Category', 'Quantity'), $menuItemNoOrdersResultData);

$pdf->AddPage();
//not ordered
$menuItemNoOrdersQuery = "SELECT
    Menu.item_name,
    0 AS total_quantity
FROM
    Menu
WHERE NOT EXISTS (
    SELECT 1
    FROM Bill_Items
    JOIN Bills ON Bill_Items.bill_id = Bills.bill_id
    WHERE Menu.item_id = Bill_Items.item_id
    AND YEAR(Bills.bill_time) BETWEEN (
        SELECT MIN(YEAR(Bills.bill_time)) FROM Bills
    ) AND YEAR('{$currentDate}') -- Check for orders from the earliest year to present year
);
";


$menuItemNoOrdersResult = mysqli_query($link, $menuItemNoOrdersQuery);

$menuItemNoOrdersResultData = array();
while ($row = mysqli_fetch_assoc($menuItemNoOrdersResult)) {
    $menuItemNoOrdersResultData[] = array($row['item_name'], $row['total_quantity']);
}
$pdf->Ln();
$pdf->ChapterBody("All Items with no Orders Whole Year (from the first record until {$currentDate}) :\n");
$pdf->CustomTable(array('Category', 'Quantity'), $menuItemNoOrdersResultData);


$pdf->Output('RevenueReport.pdf', 'D');
?>
