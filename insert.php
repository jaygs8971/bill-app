<?php
include('conn.php');
if (isset($_POST["submit"])) {

    global $conn;
    $order_id = 2021001;
    $cName = $_POST["clientName"];
    $pname = $_POST["productName"];
    $pqty = $_POST["productQuantity"];
    $pprice = $_POST["productPrice"];

    $_SESSION["cname"] = $cName;

    $myqry1 = mysqli_query($conn, "SELECT o_id FROM orders_table ORDER BY o_id DESC limit 1");

    if (mysqli_num_rows($myqry1) == 0) {
        $order_id = 2021001;
    } else {
        $myqry2 = mysqli_fetch_assoc($myqry1);
        $order_id = $myqry2['o_id'] + 1;
    }

    $date = date('Y-m-d H:i:s');

    //FETCH CLIENT NAME
    $q = mysqli_query($conn, "SELECT (c_id) FROM client WHERE name = '$cName' ");
    $q1 = mysqli_fetch_assoc($q);
    $w1 = mysqli_query($conn, "INSERT INTO orders_table (c_id, o_date) VALUES ('$q1[c_id]', '$date' )");

    $w2 = mysqli_query($conn,"SELECT o_id FROM orders_table ORDER BY o_id DESC LIMIT 1");
    $w3 = mysqli_fetch_assoc($w2);

    $subtotal = 0;

    if (!empty($pname)) {
        for ($i = 0; $i < count($pname); $i++) {
            if (!empty($pname[$i])) {
                $name = $pname[$i];
                $quantity = $pqty[$i];
                $price = $pprice[$i];
                $linetotal = (int)$quantity * (int)$price;

                $subtotal = ((int)$quantity * (int)$price) + $subtotal;
                $tax = (0.18 * $subtotal);
                $total = $subtotal + $tax;

                $sql2 = mysqli_query($conn, "SELECT * FROM products WHERE pname = '$name'  ");

                while ($q3 = mysqli_fetch_assoc($sql2)) {
                    $sql3 = mysqli_query($conn,"INSERT INTO order_details (o_id, p_id, qty, price ,total) VALUES  ('$w3[o_id]', '$q3[p_id]', '$quantity','$price','$linetotal' )");
                }
            }
        }
    }

    $sql4 = mysqli_query($conn,"SELECT * FROM order_details order by o_id desc limit 1");
    $sql5= mysqli_fetch_assoc($sql4);

    $sql4 = mysqli_query($conn, "UPDATE orders_table SET subtotal = '$subtotal' , tax = '$tax' ,total = '$total' WHERE o_id = '$sql5[o_id]' ");

    header("location:bill.php");
}


