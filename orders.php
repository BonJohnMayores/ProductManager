<?php
session_start(); // <--- Add this to access $_SESSION

$title = 'Orders';

require_once __DIR__ . '/functions/connectdb.php';

include __DIR__ . '/components/head.php';
include __DIR__ . '/components/nav-bar.php';
include __DIR__ . '/components/side-bar.php';

// Only show product-related messages
if (isset($_SESSION['action']) && $_SESSION['action'] !== 'AddOrder') {
    unset($_SESSION['msg'], $_SESSION['action']);
}


function formatInvoiceDate($datetimeString) {
    if (!$datetimeString) return '';
    $ts = strtotime($datetimeString);
    if ($ts === false) return $datetimeString;
    return date('d M Y', $ts);
}
?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap 
        align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Orders</h1>

        <a href="addOrder-form.php" class="btn btn-primary btn-sm d-flex align-items-center">
            <span data-feather="plus" class="me-1"></span> Add Order
        </a>
    </div>

    <!-- Display success message -->
    <?php if (!empty($_SESSION['msg'])): ?>
    <div class="alert alert-success">
        <?= htmlspecialchars($_SESSION['msg']); ?>
    </div>
    <?php unset($_SESSION['msg']); // remove message after displaying ?>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="thead-light">
                <tr>
                    <th>Invoice #</th>
                    <th>Customer Name</th>
                    <th>Date</th>
                    <th class="text-right">Sub Total</th>
                    <th class="text-right">Tax</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!isset($mysqli) || !($mysqli instanceof mysqli)) {
                    echo '<tr><td colspan="6" class="text-danger">Database connection error.</td></tr>';
                } else {
                    $sql = "
                        SELECT 
                            i.inv_number,
                            i.cus_code,
                            c.cus_fname,
                            c.cus_lname,
                            i.inv_date,
                            i.inv_subtotal,
                            i.inv_tax,
                            i.inv_total
                        FROM invoice i
                        LEFT JOIN customer c ON i.cus_code = c.cus_code
                        ORDER BY i.inv_date DESC, i.inv_number DESC
                    ";

                    $result = $mysqli->query($sql);

                    if ($result) {
                        if ($result->num_rows == 0) {
                            echo '<tr><td colspan="6" class="text-center">No orders found.</td></tr>';
                        } else {
                            while ($row = $result->fetch_assoc()) {
                                $invNumber = htmlspecialchars($row['inv_number']);
                                $fullname = trim(($row['cus_fname'] ?? '') . ' ' . ($row['cus_lname'] ?? ''));
                                if ($fullname == '') $fullname = "Unknown Customer";

                                $date = formatInvoiceDate($row['inv_date']);
                                $subtotal = number_format($row['inv_subtotal'], 2);
                                $tax = number_format($row['inv_tax'], 2);
                                $total = number_format($row['inv_total'], 2);

                                echo "
                                <tr>
                                    <td>{$invNumber}</td>
                                    <td>{$fullname}</td>
                                    <td>{$date}</td>
                                    <td class='text-right'>{$subtotal}</td>
                                    <td class='text-right'>{$tax}</td>
                                    <td class='text-right'>{$total}</td>
                                </tr>";
                            }
                        }
                    } else {
                        echo '<tr><td colspan="6" class="text-danger">Query error: ' . $mysqli->error . '</td></tr>';
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
<script>
feather.replace();
</script>