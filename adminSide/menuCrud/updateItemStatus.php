<?php
// Include config file
require_once "../config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if item_id is set and not empty
    if (isset($_POST["item_id"]) && !empty($_POST["item_id"])) {
        // Prepare an SQL statement to update the item_status
        $sql = "UPDATE Menu SET item_status = IF(item_status = 1, 0, 1) WHERE item_id = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind the item_id parameter as a string
            mysqli_stmt_bind_param($stmt, "s", $param_item_id);

            // Set parameters
            $param_item_id = $_POST["item_id"];

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Item status updated successfully
                header("location: ../panel/menu-panel.php");
                exit();
            } else {
                // Error while updating item status
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    } else {
        // item_id is not set or empty
        echo "Invalid request.";
    }
}

// Close connection
mysqli_close($link);
?>