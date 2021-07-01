<?php
include('conn.php');
global $conn;
?>
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
    <script>
        $(document).ready(function () {
            //group add limit
            var maxGroup = 10;

            //add more fields group
            $(".addMore").click(function () {
                if ($('body').find('.fieldGroup').length < maxGroup) {
                    var fieldHTML = '<div class="form-group fieldGroup">' + $(".fieldGroupCopy").html() + '</div>';
                    $('body').find('.fieldGroup:last').after(fieldHTML);
                } else {
                    alert('Maximum ' + maxGroup + ' groups are allowed.');
                }
            });

            //remove fields group
            $("body").on("click", ".remove", function () {
                $(this).parents(".fieldGroup").remove();
            });
        });
    </script>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><img src="images/php-logo.png" alt="logo" width="50px"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container box col-lg-6">
    <form method="post" action="store.php">
        <div class="card mt-5">
            <div class="card-header">
                Select the client
            </div>
            <div class="card-body">
                <div class="mb-3">

<!--                    <label for="clientName" class="form-label">Client Name</label>-->
<!--                    <input type="text" class="form-control" id="clientName" name="clientName">-->

                    <label for="clientName"></label>
                    <select class="form-control" id="clientName" name="clientName" required>
                        <option value="-1">-- Select --</option>
                        <?php
                        $l1 = mysqli_query($conn, "SELECT name FROM client");
                        while ($l2 = mysqli_fetch_array($l1)) {
                            echo "<option value='" . $l2['name'] . "'>" . $l2['name'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <!--                <div class="mb-3">-->
                <!--                    <label for="clientAddress" class="form-label">Address</label>-->
                <!--                    <input type="text" class="form-control" id="clientAddress">-->
                <!--                </div>-->
            </div>
            <div class="card-header">
                Fill in product details
            </div>
            <div class="card-body">
                <div class="form-group fieldGroup">
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="productName" class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="productName" name="productName[]" required>
                        </div>

                        <div class="mb-3 col-lg-3">
                            <label for="productQuantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="productQuantity" name="productQuantity[]" required >
                        </div>
                        <div class="mb-3 col-lg-3">
                            <label for="productPrice" class="form-label">Price</label>
                            <input type="number" class="form-control" id="productPrice" name="productPrice[]"  required>
                        </div>
                    </div>

                    <!-- copy of input fields group -->
                    <div class="form-group fieldGroupCopy" style="display: none;">
                        <div>
                            <div class="row mt-3">
                                <div class="col-lg-6 field_wrapper">
                                    <label for="productName" class="form-label">Product Name </label>
                                    <input type="text" class="form-control" id="productName" name="productName[]" >
                                </div>

                                <div class="mb-3 col-lg-3">
                                    <label for="productQuantity" class="form-label">Quantity</label>
                                    <input type="number" class="form-control" id="productQuantity"
                                           name="productQuantity[]" >
                                </div>
                                <div class="mb-3 col-lg-3">
                                    <label for="productPrice" class="form-label">Price</label>
                                    <input type="number" class="form-control" id="productPrice"
                                           name="productPrice[]" >
                                </div>

                                <div class="input-group-addon">
                                    <a href="javascript:void(0)" class="btn btn-outline-danger remove"><span
                                                class="glyphicon glyphicon glyphicon-remove"
                                                aria-hidden="true"></span>
                                        Remove</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <input type="submit" class="mt-3 btn btn-primary" name="submit" value="Submit"/>
                <a href="javascript:void(0)" class="mt-3 btn btn-outline-secondary addMore"><span
                            class="glyphicon glyphicon glyphicon-plus" aria-hidden="true"></span>
                    Add another product</a>

    </form>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>
</html>