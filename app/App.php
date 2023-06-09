<?php

declare(strict_types = 1);

// Your Code
$data = [];
$filename = "../transaction_files/sample_1.csv";

// Open the csv file
$f = fopen($filename, "r");

// Handling errors
if ($f === false) {
  die ("Cannot open " . $filename);
}

// Reading the csv file
while (($row = fgetcsv($f)) !== false) {
  $data[] = $row;
}

// Closing the CSV file
fclose($f);

// Removing the titles form the array
array_shift($data);
// formatting the date
$length = count($data);
for ($i = 0; $i < $length; $i++) {
  $data[$i][0] = date("M j, Y", strtotime($data[$i][0]));
}

// Calculating Net, Income and expenses
$net = 0;
$expense = 0;
$income = 0;
foreach ($data as $num) {
  $sum = str_replace(['$', ','], ['', ''], $num[3]);
  $net += (float)$sum;
  if (str_contains($sum, "-") === true) {
    $expense += (float)$sum;
  } else {
    $income += (float)$sum;
  }
}

// Formatting the total and casting it to string _f => final
$net_f = substr_replace((string) number_format($net, 2),"$", 0, 0);
$income_f = substr_replace((string) number_format($income, 2), "$", 0, 0);
$expense_f = substr_replace((string) number_format($expense, 2), "-$", 0, 1);


// echo $net_f . "<br>";
// echo $income_f . "<br>";
// echo $expense_f . "<br>";

// echo "<pre>";
// print_r ($data);
// echo "</pre>";

// Creating a function to use in html 
// Using loop to create html elements with its styles
function printing ($arr) {
  foreach ($arr as $subarr) {
    echo "<tr>";
    foreach ($subarr as $row) {
      if (str_contains($row, "-$") === true) {
        $el = "<td style = 'color: red';>$row</td>";
      } elseif (str_contains($row, "$") === true) {
        $el = "<td style = 'color: green';>$row</td>";
      } else {
        $el = "<td>$row</td>";
      }
      echo $el;
    }
    echo "</tr>";
  }
}

// $d = date_create();
// echo date_format($d, "M j, Y");

?>
