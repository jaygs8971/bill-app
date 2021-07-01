<?php
include('conn.php');
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <title>Invoice App</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
              crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
              integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
              crossorigin="anonymous" referrerpolicy="no-referrer"/>
    </head>
    <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light" id="nav">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><img src="images/php-logo.png" alt="logo" width="50px"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <?php
    global $conn;
    global $order_id;

    $s1 = mysqli_query($conn, "SELECT * FROM orders_table order by o_id DESC LIMIT 1");
    $s2 = mysqli_fetch_assoc($s1);
    ?>

    <div class="container col-lg-6 mt-5 border p-4 pb-5" id="printBill">
        <div class="col-md-6 mb-4">
            <img src="images/logo.png" width="100px" alt="logo">
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title" style="font-size: 12px;">Your Details:</h6><h5 class="card-title">
                            Redintegro</h5>
                        <p class="card-text">Rajajinagar,
                            Bangalore - 560086</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title" style="font-size: 12px;">Client Details:</h6>
                        <h5 class="card-title"><?php
                            $cName = $_SESSION["cname"];
                            $ch = mysqli_query($conn, "Select * from client where name = '$cName'");
                            $ch2 = mysqli_fetch_assoc($ch);
                            echo $cName; ?></h5>
                        <p class="card-text"> <?php echo $ch2['address'] ?> </p>

                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3 p-1">
            <div class="col-lg-6">
                <span>Invoice no:</span> <?php echo $s2['o_id'] ?>
            </div>
            <div class="col-lg-6">
                <span>Invoice Date:</span> <?php
                echo $s2['o_date']; ?>
            </div>
        </div>


        <table class="table table-responsive table-hover mt-4">
            <thead class="table-light">
            <tr>
                <th scope="col">Item</th>
                <th scope="col">Quantity</th>
                <th scope="col">Rate</th>
                <th scope="col">Subtotal</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $gt = 0;

            $s3 = mysqli_query($conn, "SELECT * FROM order_details WHERE o_id = '$s2[o_id]'");
            //            $s3 = mysqli_query($conn, "SELECT * FROM orders WHERE o_id = '$s2[o_id]'");
            while ($row = mysqli_fetch_assoc($s3)) {
                $s4 = mysqli_query($conn, "SELECT pname FROM products WHERE p_id = '$row[p_id]'");
                while ($s5 = mysqli_fetch_array($s4)) {

                    $field1name = $s5['pname'];
                    $field2name = $row["qty"];
                    $field3name = $row["price"];
                    $field4name = $row["total"];

                    $gt = $gt + $field4name;
                    global $gt;

                    echo '<tr> 
                  <td>' . $field1name . '</td> 
                  <td>' . $field2name . '</td> 
                  <td>' . "₹" . $field3name . '</td> 
                  <td>' . "₹" . $field4name . '</td> 
              </tr>';

                }
            }
            ?>

            </tbody>
        </table>

        <div class="row mt-5">
            <div class=" col-lg-6">
                <table class="table table-responsive table-hover">
                    <thead class="table-light">
                    <tr>
                        <th scope="col">Invoice Summary</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Subtotal</td>
                        <td> <?php

                            echo "₹" . $s2['subtotal']; ?> </td>
                    </tr>
                    <tr>
                        <td>Tax <b>(18%)</b></td>
                        <td> <?php echo $s2['tax']; ?> </td>

                    </tr>
                    <tr>
                        <td>Total</td>
                        <td> <?php echo "₹" . $s2['total']; ?> </td>

                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <input type="button" onclick="printDiv();" value="Print" id="printBtn"/>
    <script>
        function printDiv() {
            document.getElementById('nav').style.display = "none";
            document.getElementById('printBtn').style.display = "none";
            window.print();
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
            crossorigin="anonymous"></script>
    </body>
    </html>


<?php //} ?>