<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    $conn = mysqli_connect("localhost", "root", "", "placeholder");
} catch (mysqli_sql_exception $e) {
    die("ERROR: Could not connect. " . $e->getMessage());
}
?>