<?php
session_start();
$title = 'Add Order';

include 'functions/products.php';


if (isset($_POST['insert'])) {
    $cus_code = $_POST['cus_code'];
    $inv_subtotal = $_POST['inv_subtotal'];
    $inv_tax = $_POST['inv_tax'];
    $inv_total = $_POST['inv_total'];

    if (addOrder($cus_code, $inv_subtotal, $inv_tax, $inv_total)) {
        $_SESSION['action'] = 'Add';
        $_SESSION['msg'] = 'Order added successfully!';
        header("Location: orders.php");
        exit();
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

            <?php include 'components/side-bar.php'; ?>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap 
                align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">New Order</h1>
                </div>

                <div class="col-md-6">
                    <form method="post">

                        <div class="form-group">
                            <label>Customer Code</label>
                            <input type="text" class="form-control" name="cus_code" required>
                        </div>

                        <div class="form-group">
                            <label>Subtotal</label>
                            <input type="number" step="0.01" class="form-control" name="inv_subtotal" required>
                        </div>

                        <div class="form-group">
                            <label>Tax</label>
                            <input type="number" step="0.01" class="form-control" name="inv_tax" required>
                        </div>

                        <div class="form-group">
                            <label>Total</label>
                            <input type="number" step="0.01" class="form-control" name="inv_total" required>
                        </div>

                        <button type="reset" class="btn btn-secondary">Reset</button>
                        <button type="submit" name="insert" class="btn btn-primary">Save</button>

                    </form>
                </div>
            </main>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script>
    feather.replace();
    </script>

</body>

</html>