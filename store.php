<?php
include('conn.php');
if (isset($_POST["submit"])) {

    global $conn;
    $order_id = 2021001;
    $cName = $_POST["clientName"];
    $pname = $_POST["productName"];
    $pqty = $_POST["productQuantity"];
    $pprice = $_POST["productPrice"];

    if ($cName == "-1") #check if name is selected
    {
        echo "<script type='text/javascript'>alert(\"Client is not selected!\");</script>";
        header("refresh:0;url=index.php");
        exit();
    }

    $_SESSION["cname"] = $cName;

//    echo '<script type="text/javascript">alert(" ' . $_SESSION['cname'] . ' ");</script>';

    $myqry1 = mysqli_query($conn, "SELECT o_id FROM orders ORDER BY id DESC limit 1");

    if (mysqli_num_rows($myqry1) == 0) {
        $order_id = 2021001;
    } else {

        $myqry2 = mysqli_fetch_assoc($myqry1);
        $order_id = $myqry2['o_id'] + 1;
    }

    global $order_id;

    if (!empty($pname)) {
        for ($i = 0; $i < count($pname); $i++) {
            if (!empty($pname[$i])) {
                $name = $pname[$i];
                $quantity = $pqty[$i];
                $price = $pprice[$i];

                $totalCost = $quantity * $price;

//                echo "\n " . $i . "\n" . $name . "\n" . $quantity . "\n" . $price;
                echo "asas";
                $q = mysqli_query($conn, "SELECT (c_id) FROM client WHERE name = '$cName' ");
                $q1 = mysqli_fetch_assoc($q);
                $sql = mysqli_query($conn, "INSERT INTO products (pname, pcost, c_id) VALUES ('$name', '$price', '$q1[c_id]')");

                $sql2 = mysqli_query($conn, "SELECT p_id FROM products WHERE c_id = '$q1[c_id]'  ");

                while ($q3 = mysqli_fetch_assoc($sql2)) {

                    $w1 = mysqli_query($conn, "SELECT * FROM orders WHERE p_id = '$q3[p_id]' ");

                    if (mysqli_num_rows($w1) > 0) {
                        continue;
                    } else {
                        $sql3 = mysqli_query($conn, "INSERT INTO orders (o_id,c_id,p_id,qty,pcost,total) VALUES ('$order_id','$q1[c_id]', '$q3[p_id]', '$quantity','$price', '$totalCost')");
                    }
                }
            }
        }
    }

    header("location:bill.php");
//    die();
}