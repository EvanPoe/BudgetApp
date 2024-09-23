<?php
// Initialize the row counter and total income/expense variables
$row = 1;
$netIncome = 0;
$netExpenses = 0;

// Attempt to open the CSV file in read mode ('r')
if (($handle = fopen("../transaction_files/sample_1.csv", "r")) !== FALSE) {

    // Start the table
    echo "<table border='1'>\n";

    // Loop through the CSV file, reading one line at a time
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
                // Check if the value starts with "$" or "-$" for income/expense styling
                $trimmedCell = trim($cell);

                if (str_starts_with($trimmedCell, "-$")) {
                    // If the value starts with "-$", it's an expense (negative)
                    echo "<td style='color: red;'>" . htmlspecialchars($cell) . "</td>";

                    // Convert to float, strip the dollar sign, and add to expenses
                    $netExpenses += (float) str_replace(['$', ','], '', $trimmedCell);
                } elseif (strpos($trimmedCell, "$") === 0) {
                    // If the value starts with "$", it's an income (positive)
                    echo "<td style='color: green;'>" . htmlspecialchars($cell) . "</td>";

                    // Convert to float, strip the dollar sign, and add to income
                    $netIncome += (float) str_replace(['$', ','], '', $trimmedCell);
                } else {
                    // For all other fields, just output normally
                    echo "<td>" . htmlspecialchars($cell) . "</td>";
                }
            }

            echo "</tr>\n";
        }

        // Increment the row counter for the next iteration
        $row++;
    }

    // Calculate the net total
    $netTotal = $netIncome + $netExpenses; // Expenses are negative, so we add

    // Display the totals in the last row of the table
    echo "<tfoot>
            <tr>
                <td colspan='100%' style='font-weight: bold; text-align: right;'>Net Income: <span style='color: green;'>$" . number_format($netIncome, 2) . "</span></td>
            </tr>
            <tr>
                <td colspan='100%' style='font-weight: bold; text-align: right;'>Net Expenses: <span style='color: red;'>$" . number_format($netExpenses, 2) . "</span></td>
            </tr>
            <tr>
                <td colspan='100%' style='font-weight: bold; text-align: right;'>Net Total: <span>" . number_format($netTotal, 2) . "</span></td>
            </tr>
          </tfoot>\n";

    // Close the table
    echo "</table>\n";

    // Close the file after processing
    fclose($handle);
}
?>
