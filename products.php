<?php
session_start();
$title = 'Products';
include 'functions/products.php';

// Only show product-related messages
if (isset($_SESSION['action']) && $_SESSION['action'] !== 'Add' && $_SESSION['action'] !== 'update' && $_SESSION['action'] !== 'delete') {
    unset($_SESSION['msg'], $_SESSION['action']);
}

// DELETE Product
if (isset($_POST['delete'])) {
    $pcode = $_POST['pcode'];
    if (deleteProduct($pcode)) {
        $_SESSION['action'] = 'delete';
        $_SESSION['msg'] = 'Product deleted successfully!';
        header('location:products.php');
        exit;
    }
}

// SEARCH
if (isset($_POST['search'])) {
    $search = $_POST['txtsearch'];
    $products = findProducts($search);
} else {
    $products = getAllProducts();
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
                <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Manage Products</h1>
                </div>

                <!-- Bootstrap Icons -->
                <link rel="stylesheet"
                    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

                <!-- Search Form -->
                <form method="post">
                    <div class="row g-3 align-items-end">

                        <div class="col-md-6">
                            <label for="txtsearch" class="form-label">Search</label>
                            <input type="text" id="txtsearch" name="txtsearch" class="form-control"
                                placeholder="Enter search term">
                        </div>

                        <div class="col-md-3">
                            <button type="submit" name="search"
                                class="btn btn-primary w-50 d-flex align-items-center justify-content-center gap-2">
                                <i class="bi bi-search"></i>
                                Search
                            </button>
                        </div>

                    </div>
                </form>

                <a href="product-form.php" class="btn btn-success text-white mb-3 float-right">
                    <i class="fas fa-plus-square"></i> New Product
                </a>

                <!-- Display success message -->
                <?php if (!empty($_SESSION['msg'])): ?>
                <div class="alert alert-success mt-3 col-6">
                    <?= htmlspecialchars($_SESSION['msg']); ?>
                </div>
                <?php unset($_SESSION['msg']); // remove message after displaying ?>
                <?php endif; ?>

                <!-- Product Table -->
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Stocks</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $i = 0;
                            foreach ($products as $product) {
                                $i++;
                            ?>
                            <tr>
                                <td><?= $i ?></td>
                                <td><?= $product['p_code'] ?></td>
                                <td><?= $product['p_descript'] ?></td>
                                <td><?= $product['p_price'] ?></td>
                                <td><?= $product['p_qoh'] ?></td>

                                <td>
                                    <div class="btn-group">

                                        <!-- UPDATE Button -->
                                        <a href="update-form.php?pcode=<?= $product['p_code'] ?>"
                                            class="btn btn-primary btn-sm">
                                            <i class="fas fa-pen"></i>
                                        </a>

                                        <!-- DELETE Button -->
                                        <form method="post" onsubmit="return confirm('Delete this product?')">
                                            <input type="hidden" name="pcode" value="<?= $product['p_code'] ?>">
                                            <button class="btn btn-danger btn-sm" name="delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>

                            </tr>
                            <?php } ?>
                        </tbody>

                    </table>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>

<!-- Feather Icons -->
<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
<script>
feather.replace(); // <---- THIS IS KEY to make icons appear
</script>