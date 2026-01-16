<?php
require_once __DIR__ . '/../Classes/UserOrders.php';
require_once '../../Backend/db_connection.php';

if (!isset($_SESSION['user_id'])) {
    die('Not authenticated');
}

$userOrders = new UserOrders((int) $_SESSION['user_id']);

// Fetch order IDs
$userOrdersIDs = $userOrders->getUserOrderIds($pdo);

// Fetch all items (with seminar data)
$items = $userOrders->getOrderItemsWithSeminars($pdo);

?>

<section>
    <h2>Your Orders</h2>

    <?php if (empty($userOrdersIDs)): ?>
        <p>You have no orders.</p>
    <?php else: ?>
        <?php foreach ($userOrdersIDs as $orderId): ?>
            <h3 style="color: aliceblue;">Order #<?= htmlspecialchars($orderId) ?></h3>

            <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                <thead>
                    <tr style="background-color: #333; color: aliceblue;">
                        <th>ID</th>
                        <th>Product</th>
                        <th style="text-align:right;">Qty</th>
                        <th style="text-align:right;">Start</th>
                        <th style="text-align:right;">End</th>
                        <th style="text-align:right;">Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                        <?php if ((int) $item['order_id'] === (int) $orderId): ?>
                            <tr style="border-bottom: 1px solid #555; color: aliceblue;">
                                <td><?= htmlspecialchars($item['product_id']) ?></td>
                                <td><?= htmlspecialchars($item['product_title']) ?></td>
                                <td style="text-align:right;"><?= htmlspecialchars($item['quantity']) ?></td>
                                <td style="text-align:right;">
                                    <?= htmlspecialchars($item['start_date'] ?? 'N/A') ?>
                                </td>
                                <td style="text-align:right;">
                                    <?= htmlspecialchars($item['end_date'] ?? 'N/A') ?>
                                </td>
                                <td style="text-align:right;">
                                    $<?= number_format((float) $item['unit_price'], 2) ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endforeach; ?>
    <?php endif; ?>
</section>