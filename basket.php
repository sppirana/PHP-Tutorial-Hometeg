<?php
session_start();
include("db.php");

$pagename = "Smart Basket";
echo "<link rel=stylesheet type=text/css href=mystylesheet.css>";
echo "<title>".$pagename."</title>";
echo "<body>";
include("headfile.html");
echo "<h4>".$pagename."</h4>";

// Check if a product is being removed from the basket
if (isset($_POST['del_prodid'])) {
    $delprodid = $_POST['del_prodid'];
    unset($_SESSION['basket'][$delprodid]);
    echo "<p>1 item removed";
}

// Check if a new product is being added to the basket
if (isset($_POST['h_prodid'])) {
    $newprodid = $_POST['h_prodid'];
    $reququantity = $_POST['p_quantity'];
    $_SESSION['basket'][$newprodid] = $reququantity;
    echo "<p>1 item added";
} else {
    echo "<p>Basket unchanged";
}

// Display basket contents
$total = 0;
echo "<p><table id='baskettable'>";
echo "<tr>";
echo "<th>Product Name</th><th>Price</th><th>Quantity</th><th>Subtotal</th><th>Remove Product</th>";
echo "</tr>";

if (isset($_SESSION['basket']) && !empty($_SESSION['basket'])) {
    foreach($_SESSION['basket'] as $index => $value) {
        // Secure the SQL query by ensuring $index is numeric
        if(is_numeric($index)) {
            $SQL = "SELECT prodName, prodPrice FROM Product WHERE prodId=".$index;
            $exeSQL = mysqli_query($conn, $SQL) or die(mysqli_error($conn));
            
            if(mysqli_num_rows($exeSQL) > 0) {
                $arrayp = mysqli_fetch_array($exeSQL);
                
                echo "<tr>";
                echo "<td>".$arrayp['prodName']."</td>";
                echo "<td>&pound".number_format($arrayp['prodPrice'], 2)."</td>";
                echo "<td style='text-align:center;'>".$value."</td>";
                
                $subtotal = $arrayp['prodPrice'] * $value;
                echo "<td>&pound".number_format($subtotal, 2)."</td>";
                
                // Add remove button for each product
                echo "<td>";
                echo "<form action='basket.php' method='post'>";
                echo "<input type='submit' value='Remove' id='submitbtn'>";
                echo "<input type='hidden' name='del_prodid' value=".$index.">";
                echo "</form>";
                echo "</td>";
                
                echo "</tr>";
                $total = $total + $subtotal;
            }
        }
    }
} else {
    echo "<tr><td colspan=5>Empty basket</td></tr>";
}

// Display total
echo "<tr>";
echo "<td colspan=3>TOTAL</td>";
echo "<td>&pound".number_format($total, 2)."</td>";
echo "<td></td>";
echo "</tr>";
echo "</table>";

// Add links for clearing basket, signup and login
echo "<br><p><a href='clearbasket.php'>CLEAR BASKET</a></p>";
echo "<p>New homteq customers: <a href='signup.php'>Sign up</a></p>";
echo "<p>Returning homteq customers: <a href='login.php'>Log in</a></p>";

include("footfile.html");
echo "</body>";
?>