<!DOCTYPE html>
<html lang="en">
<head>
    <title>Invoice App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
          integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
</head>
<?php
include('conn.php');
{
global $conn;
$sql = mysqli_query($conn, "SELECT * FROM orders_table");

while ($sql2 = mysqli_fetch_assoc($sql)) {

$sql3 = mysqli_query($conn, "SELECT * FROM client WHERE c_id = '$sql2[c_id]'")
?>

<div class="container col-lg-6 border mt-4 pt-4 pb-4 mb-4">

    <!--                <div class="card">-->
    <!--                    <div class="card-body">-->
    <form method="post" action="bill.php">
        <div class="row  bo">
            <div class="col-sm-4">
                <h6 class="card-title" style="font-size: 14px;">
                    <?php $sql4 = mysqli_fetch_assoc($sql3);
                    echo $sql4['name']; ?>
                </h6>
            </div>
            <div class="col-sm-4">
                <h5 class="card-title" style="font-size: 14px">
                    <?php echo "Invoice No: " . $sql2['o_id'];
                    ?></h5>
            </div>
            <div class="col-sm-4">
                <h5 class="card-title" style="font-size: 14px">
                    <?php echo "Date: " . $sql2['o_date'] ?></h5>
            </div>
            <input type="text" hidden name="my_ord" value="<?php echo $sql2['o_id']; ?> ">
        </div>
        <input type="submit" value="Check" class="btn btn-success mt-3" name="check">
    </form>
</div>
</html>
<!--    </div>-->
<!--        </div>-->
<!--    </div>-->

<?php
}
}
