<?php
// Initialize the row counter to track which row is being processed
$row = 1;

// Attempt to open the CSV file in read mode ('r') from a parent directory's folder
if (($handle = fopen("../transaction_files/sample_1.csv", "r")) !== FALSE) {

    // Loop through the CSV file, reading one line at a time
    // fgetcsv() reads the CSV file line by line and returns an array for each row
    // Parameters:
    // - $handle: file resource
    // - 1000: max length of a line to be read (optional)
    // - "," : the delimiter (in this case, a comma)
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

        // Get the number of fields in the current row
        $num = count($data);

        // Output the number of fields and the row number
        echo "<p>$num fields in line $row: <br /></p>\n";

        // Increment the row counter for the next iteration
        $row++;

        // Loop through each field (column) in the current row
        for ($c = 0; $c < $num; $c++) {
            // Output the value of each field, followed by a line break
            echo $data[$c] . "<br />\n";
        }
    }

    // Close the file when done processing to free up system resources
    fclose($handle);
}
?>
