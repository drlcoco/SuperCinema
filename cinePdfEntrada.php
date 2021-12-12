<?php
session_start();
$movie = $_GET['movie'];
$row = $_GET['row'];
$seat = $_GET['seat'];
$path = './images/images/logo.png';
$image = "<img src='./images/images/logo.png' alt=''>";
include('./TCPDF-main/config/tcpdf_config.php');
include('./TCPDF-main/tcpdf.php');
$documentPdf = new TCPDF();
$documentPdf->setPrintHeader(false);
$documentPdf->setPrintFooter(false);
$documentPdf->SetTitle($_GET["movie"]);
$documentPdf->Addpage();
$documentPdf->Image("./images/images/logo.png");
$documentPdf->SetFillColor(52, 21, 0, 76);
$documentPdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$documentPdf->writeHTML(
    "<!DOCTYPE html>
    <html>
    <head>
        <meta charset='UTF-8'>
        <title>Ticket</title>
        <style>
            html{
                background-color: #6297c9;
            }
            body{
                background-color: #6297c9;
                font-size: 30px;
            }
            table {
                background-color: #6297c9;
                border-collapse: collapse;
                margin-top: 100px;
            }
            th{
                vertical-align:middle;
            }
            table, th, td {
                border: 1px solid black;
            }
            table > tr > th {
                font-weight: bold; 
                text-align: center;
                vertical-align: middle;
                color: black;
                height: 100px;
            }
            table > tr > td {
                font-weight: bold; 
                text-align: center;
                color: black;
                
            }
        </style>
    </head>
    <body>
        ".$image."
        <table>
            <tr>
                <th>Movie</th>
                <td>" . $movie . "</td>
            </tr>
            <tr>
                <th>Row</th>
                <td>" . $row . "</td>
            </tr>
            <tr>
                <th>Seat</th>
                <td>" . $seat . "</td>
            </tr>
            <tr>
                <td colspan='2'>SHOW THIS TICKET TO ACCES.</td>
            </tr>
        </table>
    </body>
    </html>");
    $documentPdf->lastPage();
    ob_end_clean();
$documentPdf->Output("Ticket.pdf", "D");
?>