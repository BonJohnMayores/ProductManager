<?php
$title = 'Orders';

require_once __DIR__ . '/functions/connectdb.php';

include __DIR__ . '/components/head.php';
include __DIR__ . '/components/nav-bar.php';
include __DIR__ . '/components/side-bar.php';

function formatInvoiceDate($datetimeString) {
    if (!$datetimeString) return '';
    $ts = strtotime($datetimeString);
    if ($ts === false) return $datetimeString;
    return date('d M Y', $ts);
}
?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Orders</h1>
        <!-- Example icon usage -->
        <button class="btn btn-sm btn-outline-secondary">
            <span data-feather="plus"></span> Add Order
        </button>
    </div>

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
                    echo '<tr><td colspan="6" class="text-danger">Database connection failed: $mysqli is not defined.</td></tr>';
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
                                $custFull  = trim(($row['cus_fname'] ?? '') . ' ' . ($row['cus_lname'] ?? ''));
                                if ($custFull === '') $custFull = "Unknown Customer";

                                $dateStr = formatInvoiceDate($row['inv_date']);

                                $subtotal = number_format($row['inv_subtotal'], 2);
                                $tax      = number_format($row['inv_tax'], 2);
                                $total    = number_format($row['inv_total'], 2);

                                echo "
                                <tr>
                                    <td>{$invNumber}</td>
                                    <td>{$custFull}</td>
                                    <td>{$dateStr}</td>
                                    <td class='text-right'>{$subtotal}</td>
                                    <td class='text-right'>{$tax}</td>
                                    <td class='text-right'>{$total}</td>
                                </tr>";
                            }
                        }
                        $result->free();
                    } else {
                        echo '<tr><td colspan="6" class="text-danger">Query error: ' . $mysqli->error . '</td></tr>';
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</main>



<!-- Feather Icons -->
<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
<script>
feather.replace(); // <---- THIS IS KEY to make icons appear
</script>