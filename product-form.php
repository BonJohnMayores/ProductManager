<?php
session_start();
$title ='Products';
include 'functions/products.php';

// Initial default values for new product
$initialPcode = '';
$initialDesc  = '';
$initialPrice = '';
$initialStocks = '';

if(isset($_POST['insert'])){
    $pcode = $_POST['pcode'];
    $desc = $_POST['desc'];
    $stocks = $_POST['stocks'];
    $price = $_POST['price'];

    if(addProduct($pcode, $desc, $stocks, $price)){
        $_SESSION['action']='Add';
        $_SESSION['msg']='Product added successfully!';
        header('location: products.php');
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
                    <h1 class="h2">New Product</h1>
                </div>

                <div class="col-md-6">
                    <form method="post" id="productForm">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="pcode">Product Code</label>
                                <input type="text" class="form-control" id="pcode" name="pcode"
                                    value="<?= htmlspecialchars($initialPcode) ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="desc">Description</label>
                            <input type="text" class="form-control" id="desc" name="desc"
                                value="<?= htmlspecialchars($initialDesc) ?>">
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="price">Price</label>
                                <input type="text" class="form-control" id="price" name="price"
                                    value="<?= htmlspecialchars($initialPrice) ?>">
                            </div>

                            <div class="form-group col-md-2">
                                <label for="stocks">Stocks</label>
                                <input type="text" class="form-control" id="stocks" name="stocks"
                                    value="<?= htmlspecialchars($initialStocks) ?>">
                            </div>
                        </div>

                        <button type="button" class="btn btn-secondary" id="resetBtn">Reset</button>
                        <button type="submit" class="btn btn-primary" name="insert">Save</button>
                    </form>
                </div>
            </main>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const resetBtn = document.getElementById('resetBtn');
        const pcode = document.getElementById('pcode');
        const desc = document.getElementById('desc');
        const price = document.getElementById('price');
        const stocks = document.getElementById('stocks');

        // Save initial values
        const initialValues = {
            pcode: pcode.value,
            desc: desc.value,
            price: price.value,
            stocks: stocks.value
        };

        resetBtn.addEventListener('click', function() {
            if (confirm('Are you sure you want to reset the form? Unsaved changes will be lost.')) {
                pcode.value = initialValues.pcode;
                desc.value = initialValues.desc;
                price.value = initialValues.price;
                stocks.value = initialValues.stocks;
            }
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