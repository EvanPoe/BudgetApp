<?php
// Initialize the row counter to track which row is being processed
$row = 1;

// Attempt to open the CSV file in read mode ('r') from a parent directory's folder
if (($handle = fopen("../transaction_files/sample_1.csv", "r")) !== FALSE) {

    // Start the table
    echo "<table border='1'>\n";

    // Loop through the CSV file, reading one line at a time
    // fgetcsv() reads the CSV file line by line and returns an array for each row
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

        // Check if we're on the first row (to create table headers)
        if ($row == 1) {
            // Create the table header row
            echo "<thead><tr>";

            // Loop through each field in the first row to make headers
            foreach ($data as $header) {
                echo "<th>" . htmlspecialchars($header) . "</th>";
            }

            echo "</tr></thead>\n";
        } else {
            // For subsequent rows, create the table body
            echo "<tr>";

            // Loop through each field in the row to create table cells
            foreach ($data as $cell) {
                echo "<td>" . htmlspecialchars($cell) . "</td>";
            }
            echo "</tr>\n";
        }

        // Increment the row counter for the next iteration
        $row++;
    }

    // Close the table
    echo "</table>\n";

    // Close the file when done processing to free up system resources
    fclose($handle);
}
?>
