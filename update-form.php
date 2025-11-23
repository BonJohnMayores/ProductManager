<?php
session_start();
$title = 'Products';
include 'functions/products.php';

if (!isset($_GET['pcode'])) {
    header("Location: products.php");
    exit;
}

$pcode = $_GET['pcode'];

// Get product data
$conn = Connect();
$query = "SELECT * FROM product WHERE p_code='$pcode'";
$result = $conn->query($query);
$product = $result->fetch_assoc();
$conn->close();

if (isset($_POST['update'])) {
    $desc = $_POST['desc'];
    $price = $_POST['price'];
    $stocks = $_POST['stocks'];

    if (updateProduct($pcode, $desc, $price, $stocks)) {
        $_SESSION['action'] = 'update';
        $_SESSION['msg'] = 'Product updated successfully!';
        header("Location: products.php");
        exit;
    }
}
?>
<!doctype html>
<html lang="en">

<?php include 'components/head.php'; ?>

<body>

    <?php include 'components/nav-bar.php'; ?>

    <div class="container-fluid">
        <div class="row">

            <!-- Sidebar -->
            <?php include 'components/side-bar.php'; ?>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">

                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Update Product</h1>
                </div>

                <div class="col-md-6">
                    <form method="post">

                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="code">Product Code</label>
                                <input type="text" class="form-control" name="pcode" value="<?= $product['p_code'] ?>"
                                    readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" class="form-control" name="desc" value="<?= $product['p_descript'] ?>"
                                required>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="price">Price</label>
                                <input type="text" class="form-control" name="price" value="<?= $product['p_price'] ?>"
                                    required>
                            </div>

                            <div class="form-group col-md-2">
                                <label for="stocks">Stocks</label>
                                <input type="text" class="form-control" name="stocks" value="<?= $product['p_qoh'] ?>"
                                    required>
                            </div>
                        </div>

                        <button type="reset" class="btn btn-secondary">Reset</button>
                        <button type="submit" class="btn btn-primary" name="update">Update</button>

                    </form>
                </div>

            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script>
    window.jQuery || document.write('<script src="../assets/js/vendor/jquery.slim.min.js"><\/script>')
    </script>
    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"></script>
    <script src="js/dashboard.js"></script>

</body>

</html>