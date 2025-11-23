<?php
session_start();
$title = 'Add Order';


require_once 'functions/orders.php';

// Fetch customers for dropdown
$customers = [];
$cusResult = $mysqli->query("SELECT cus_code, cus_fname, cus_lname FROM customer ORDER BY cus_fname");
if ($cusResult) {
    while ($row = $cusResult->fetch_assoc()) {
        $customers[] = $row;
    }
}

// Insert order
if (isset($_POST['insert'])) {
    $cus_code = $_POST['cus_code'];
    $inv_subtotal = $_POST['inv_subtotal'];
    $inv_tax = $_POST['inv_tax'];
    $inv_total = $_POST['inv_total'];

    if (addOrder($cus_code, $inv_subtotal, $inv_tax, $inv_total)) {
        $_SESSION['action'] = 'AddOrder';
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
                            <label>Customer</label>
                            <select name="cus_code" class="form-control" required>
                                <option value="">-- Select Customer --</option>
                                <?php foreach($customers as $c): ?>
                                <option value="<?= htmlspecialchars($c['cus_code']) ?>">
                                    <?= htmlspecialchars($c['cus_fname'] . ' ' . $c['cus_lname']) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Subtotal</label>
                            <input type="number" step="0.01" class="form-control" name="inv_subtotal" id="inv_subtotal"
                                required>
                        </div>

                        <div class="form-group">
                            <label>Tax</label>
                            <input type="number" step="0.01" class="form-control" name="inv_tax" id="inv_tax" required>
                        </div>

                        <div class="form-group">
                            <label>Total</label>
                            <input type="number" step="0.01" class="form-control" name="inv_total" id="inv_total"
                                required readonly>
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

    <!-- Auto-calculate Total -->
    <script>
    const subtotalInput = document.getElementById('inv_subtotal');
    const taxInput = document.getElementById('inv_tax');
    const totalInput = document.getElementById('inv_total');

    function calculateTotal() {
        const subtotal = parseFloat(subtotalInput.value) || 0;
        const tax = parseFloat(taxInput.value) || 0;
        totalInput.value = (subtotal + tax).toFixed(2);
    }

    subtotalInput.addEventListener('input', calculateTotal);
    taxInput.addEventListener('input', calculateTotal);
    </script>

</body>

</html>