<?php
session_start();
$title = 'Products';
include 'functions/products.php';

if (!isset($_GET['pcode'])) {
    header("Location: products.php");
    exit;
}

$pcode = $_GET['pcode'];

// Get product data from database
$conn = Connect();
$query = "SELECT * FROM product WHERE p_code = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $pcode);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();
$stmt->close();
$conn->close();

if (!$product) {
    $_SESSION['action'] = 'error';
    $_SESSION['msg'] = 'Product not found!';
    header("Location: products.php");
    exit;
}

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
            <?php include 'components/side-bar.php'; ?>
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Update Product</h1>
                </div>

                <div class="col-md-6">
                    <form method="post" id="productForm">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="pcode">Product Code</label>
                                <input type="text" class="form-control" id="pcode" name="pcode"
                                    value="<?= htmlspecialchars($product['p_code']) ?>" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="desc">Description</label>
                            <input type="text" class="form-control" id="desc" name="desc"
                                value="<?= htmlspecialchars($product['p_descript']) ?>" required>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="price">Price</label>
                                <input type="text" class="form-control" id="price" name="price"
                                    value="<?= htmlspecialchars($product['p_price']) ?>" required>
                            </div>

                            <div class="form-group col-md-2">
                                <label for="stocks">Stocks</label>
                                <input type="text" class="form-control" id="stocks" name="stocks"
                                    value="<?= htmlspecialchars($product['p_qoh']) ?>" required>
                            </div>
                        </div>

                        <button type="button" class="btn btn-secondary" id="resetBtn">Reset</button>
                        <button type="submit" class="btn btn-primary" name="update">Update</button>
                    </form>
                </div>
            </main>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const resetBtn = document.getElementById('resetBtn');
        const desc = document.getElementById('desc');
        const price = document.getElementById('price');
        const stocks = document.getElementById('stocks');
        const pcode = document.getElementById('pcode').value;

        resetBtn.addEventListener('click', function() {
            if (!confirm('Are you sure you want to reset? Unsaved changes will be lost.')) return;

            // Fetch latest values from get_product.php
            fetch('./get_product.php?pcode=' + encodeURIComponent(pcode))
                .then(response => {
                    if (!response.ok) throw new Error('Network response not OK: ' + response
                        .status);
                    return response.json();
                })
                .then(data => {
                    if (data.error) {
                        alert('Error: ' + data.error);
                    } else {
                        desc.value = data.desc;
                        price.value = data.price;
                        stocks.value = data.stocks;
                    }
                })
                .catch(err => {
                    console.error('Fetch error:', err);
                    alert('Failed to fetch latest product data. Check get_product.php path.');
                });
        });
    });
    </script>

</body>

</html>

<!-- Feather Icons -->
<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
<script>
feather.replace(); // <---- THIS IS KEY to make icons appear
</script>