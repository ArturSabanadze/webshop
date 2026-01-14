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

    public function new_physical_product_form(): string
    {
        $new_product = [
            'title' => '',
            'description' => '',
            'image_url' => '',
            'price' => '',
            'status' => '',
            'start_selling_date' => '',
            'product_id' => '',
            'stock' => '',
            'weight' => '',
            'pack_size_height' => '',
            'pack_size_width' => '',
            'pack_size_depth' => '',
            'shipping_required' => ''
        ];
        ob_start();
        ?>
        <section>
            <form method="post" enctype="multipart/form-data" class="product-form">
                <input type="hidden" name="action" value="create-product">
                <input type="hidden" name="product_type" value="physical">
                <div>
                    <!-- Title -->
                    <label>
                        <strong>Title:</strong><br>
                        <input type="text" name="title" value="<?= htmlspecialchars($new_product['title']) ?>" required>
                    </label>
                    <!-- Description -->
                    <label>
                        <strong>Description:</strong><br>
                        <textarea name="description" required><?= htmlspecialchars($new_product['description']) ?></textarea>
                    </label>
                    <!-- Image URL -->
                    <label>
                        <strong>Image URL:</strong><br>
                        <input type="file" name="product_image" accept="image/*">
                    </label>
                    <!-- Price -->
                    <label>
                        <strong>Price:</strong><br>
                        <input type="number" step="0.01" name="price" value="<?= htmlspecialchars($new_product['price']) ?>"
                            required>
                    </label>
                    <!-- Status -->
                    <label>
                        <strong>Status:</strong><br>
                        <select name="status" required>
                            <option value="active" <?= $new_product['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                            <option value="inactive" <?= $new_product['status'] === 'inactive' ? 'selected' : '' ?>>Inactive
                            </option>
                        </select>
                    </label>
                    <!-- Start Selling Date -->
                    <label>
                        <strong>Start Selling Date:</strong><br>
                        <input type="datetime-local" name="start_selling_date"
                            value="<?= htmlspecialchars($new_product['start_selling_date']) ?>" required>
                    </label>
                    <!-- Stock -->
                    <label>
                        <strong>Stock:</strong><br>
                        <input type="number" name="stock" value="<?= htmlspecialchars($new_product['stock']) ?>" required>
                    </label>
                    <!-- Weight -->
                    <label>
                        <strong>Weight (kg):</strong><br>
                        <input type="number" step="0.01" name="weight" value="<?= htmlspecialchars($new_product['weight']) ?>"
                            required>
                    </label>
                    <!-- Pack Size Height -->
                    <label>
                        <strong>Pack Size Height (cm):</strong><br>
                        <input type="number" step="0.01" name="pack_size_height"
                            value="<?= htmlspecialchars($new_product['pack_size_height']) ?>" required>
                    </label>
                    <!-- Pack Size Width -->
                    <label>
                        <strong>Pack Size Width (cm):</strong><br>
                        <input type="number" step="0.01" name="pack_size_width"
                            value="<?= htmlspecialchars($new_product['pack_size_width']) ?>" required>
                    </label>
                    <!-- Pack Size Depth -->
                    <label>
                        <strong>Pack Size Depth (cm):</strong><br>
                        <input type="number" step="0.01" name="pack_size_depth"
                            value="<?= htmlspecialchars($new_product['pack_size_depth']) ?>" required>
                    </label>
                    <!-- Shipping Required -->
                    <label>
                        <strong>Shipping Required:</strong><br>
                        <select name="shipping_required" required>
                            <option value="1" <?= $new_product['shipping_required'] == '1' ? 'selected' : '' ?>>Yes</option>
                            <option value="0" <?= $new_product['shipping_required'] == '0' ? 'selected' : '' ?>>No</option>
                        </select>
                    </label>
                </div>
                <div>
                    <button type="submit" class="btn-primary">Save Changes</button>
                </div>
            </form>
        </section>
        <?php
        return ob_get_clean();
    }

    public function new_digital_product_form(): string
    {
        $new_product = [
            'title' => '',
            'description' => '',
            'image_url' => '',
            'price' => '',
            'status' => '',
            'start_selling_date' => '',

            'file_url' => '',
            'license_type' => '',

        ];
        ob_start();
        ?>
        <section>
            <form method="post" enctype="multipart/form-data" class="product-form">
                <input type="hidden" name="action" value="create-product">
                <input type="hidden" name="product_type" value="digital">
                <div>
                    <!-- Title -->
                    <label>
                        <strong>Title:</strong><br>
                        <input type="text" name="title" value="<?= htmlspecialchars($new_product['title']) ?>" required>
                    </label>
                    <!-- Description -->
                    <label>
                        <strong>Description:</strong><br>
                        <textarea name="description" required><?= htmlspecialchars($new_product['description']) ?></textarea>
                    </label>
                    <!-- Image URL -->
                    <label>
                        <strong>Image URL:</strong><br>
                        <input type="file" name="product_image" accept="image/*">
                    </label>
                    <!-- Price -->
                    <label>
                        <strong>Price:</strong><br>
                        <input type="number" step="0.01" name="price" value="<?= htmlspecialchars($new_product['price']) ?>"
                            required>
                    </label>
                    <!-- Status -->
                    <label>
                        <strong>Status:</strong><br>
                        <select name="status" required>
                            <option value="active" <?= $new_product['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                            <option value="inactive" <?= $new_product['status'] === 'inactive' ? 'selected' : '' ?>>Inactive
                            </option>
                        </select>
                    </label>
                    <!-- Start Selling Date -->
                    <label>
                        <strong>Start Selling Date:</strong><br>
                        <input type="datetime-local" name="start_selling_date"
                            value="<?= htmlspecialchars($new_product['start_selling_date']) ?>" required>
                    </label>
                    <!-- File URL -->
                    <label>
                        <strong>Image URL:</strong><br>
                        <input type="text" name="file_url" value="<?= htmlspecialchars($new_product['file_url']) ?>" required>
                    </label>
                    <!-- License Type -->
                    <label>
                        <strong>License Type:</strong><br>
                        <input type="text" name="license_type" value="<?= htmlspecialchars($new_product['license_type']) ?>"
                            required>
                    </label>
                </div>
                <div>
                    <button type="submit" class="btn-primary">Save Changes</button>
                </div>
            </form>
        </section>
        <?php
        return ob_get_clean();
    }

    public function new_live_product_form(): string
    {
        $new_product = [
            'title' => '',
            'description' => '',
            'image_url' => '',
            'price' => '',
            'status' => '',
            'start_selling_date' => '',

            'product_id' => '',
            'start_date' => '',
            'end_date' => '',
            'location_id' => '',
            'min_participants' => '',
            'max_participants' => ''

        ];
        ob_start();
        ?>
        <section>
            <form method="post" enctype="multipart/form-data" class="product-form">
                <input type="hidden" name="action" value="create-product">
                <input type="hidden" name="product_type" value="live">
                <div>
                    <!-- Title -->
                    <label>
                        <strong>Title:</strong><br>
                        <input type="text" name="title" value="<?= htmlspecialchars($new_product['title']) ?>" required>
                    </label>
                    <!-- Description -->
                    <label>
                        <strong>Description:</strong><br>
                        <textarea name="description" required><?= htmlspecialchars($new_product['description']) ?></textarea>
                    </label>
                    <!-- Image URL -->
                    <label>
                        <strong>Image URL:</strong><br>
                        <input type="file" name="product_image" accept="image/*">
                    </label>
                    <!-- Price -->
                    <label>
                        <strong>Price:</strong><br>
                        <input type="number" step="0.01" name="price" value="<?= htmlspecialchars($new_product['price']) ?>"
                            required>
                    </label>
                    <!-- Status -->
                    <label>
                        <strong>Status:</strong><br>
                        <select name="status" required>
                            <option value="active" <?= $new_product['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                            <option value="inactive" <?= $new_product['status'] === 'inactive' ? 'selected' : '' ?>>Inactive
                            </option>
                        </select>
                    </label>
                    <!-- Start Selling Date -->
                    <label>
                        <strong>Start Selling Date:</strong><br>
                        <input type="datetime-local" name="start_selling_date"
                            value="<?= htmlspecialchars($new_product['start_selling_date']) ?>" required>
                    </label>
                    <!-- Start Date -->
                    <label>
                        <strong>Start Date:</strong><br>
                        <input type="datetime-local" name="start_date"
                            value="<?= htmlspecialchars($new_product['start_date']) ?>" required>
                    </label>
                    <!-- End Date -->
                    <label>
                        <strong>End Date:</strong><br>
                        <input type="datetime-local" name="end_date" value="<?= htmlspecialchars($new_product['end_date']) ?>"
                            required>
                    </label>
                    <!-- Location ID -->
                    <label>
                        <strong>Location ID:</strong><br>
                        <input type="text" name="location_id" value="<?= htmlspecialchars($new_product['location_id']) ?>"
                            required>
                    </label>
                    <!-- Min Participants -->
                    <label>
                        <strong>Min Participants:</strong><br>
                        <input type="number" name="min_participants"
                            value="<?= htmlspecialchars($new_product['min_participants']) ?>" required>
                    </label>
                    <!-- Max Participants -->
                    <label>
                        <strong>Max Participants:</strong><br>
                        <input type="number" name="max_participants"
                            value="<?= htmlspecialchars($new_product['max_participants']) ?>" required>
                    </label>
                </div>
                <div>
                    <button type="submit" class="btn-primary">Save Changes</button>
                </div>
            </form>
        </section>
        <?php
        return ob_get_clean();
    }

}
