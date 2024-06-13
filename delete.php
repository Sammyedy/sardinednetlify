<?php
    $filepath = "./user/log.txt";  // Assuming log.txt is in the same directory as the PHP file

    if (file_exists($filepath)) {
        unlink($filepath);  // Delete the file
        echo "<!DOCTYPE html>
        <html>
        <head>
            <style>
                body {
                    background-color: #FFE6E6;
                }
                h1 {
                    background-color: #E1AFD1;
                    color: #201658;
                    font-size: 50px;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height:100vh;
                    margin:0px;
                    padding:0px;
                    border-radius:75%;
                }
            </style>
        </head>
        <body>
            <h1>Dashboard cleared successfully!!!</h1>
        </body>
        </html>";
    } else {
        echo "<!DOCTYPE html>
        <html>
        <head>
            <style>
                body {
                    background-color: #FFE6E6;
                }
                h1 {
                    background-color: #E1AFD1;
                    color: #201658;
                    font-size: 50px;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height:100vh;
                    margin:0px;
                    padding:0px;
                    border-radius:75%;
                }
            </style>
        </head>
        <body>
            <h1>Dashboard is clear!!!</h1>
        </body>
        </html>
        ";
    }
?>
