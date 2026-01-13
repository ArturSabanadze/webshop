<?php

trait T_Product
{
    public function listAll(array $product_list): string
    {
        if (empty($product_list)) {
            return '<p>No products found.</p>';
        }
        ob_start();
        ?>
        <section>
            <table border="1" cellpadding="6">
                <thead>
                    <tr>
                        <?php foreach (array_keys($product_list[0]) as $column): ?>
                            <th><?= htmlspecialchars($column) ?></th>
                        <?php endforeach; ?>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($product_list as $row): ?>
                        <tr>
                            <?php foreach ($row as $value): ?>
                                <td><?= htmlspecialchars((string) $value) ?></td>
                            <?php endforeach; ?>

                            <td>
                                <a href="?page=products&type=<?= $_GET['type'] ?>&action=edit&id=<?= $row['product_id'] ?>">
                                    Edit
                                </a>

                                &nbsp;|&nbsp;

                                <a href="?page=products&type=<?= $_GET['type'] ?>&action=delete&id=<?= $row['product_id'] ?>"
                                    onclick="return confirm('Delete this product?')">
                                    Delete
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
        <?php
        return ob_get_clean();
    }
}
