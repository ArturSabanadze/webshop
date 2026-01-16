<?php

trait T_Product
{
    public function listAll(array $product_list): string
    {

        $type = $_GET['type'] ?? '';
        if (empty($product_list)) {
            return '<p>No products found.</p>';
        }

        $editingId = $_GET['id'] ?? null;
        $action = $_GET['action'] ?? null;

        $html = '<section>';
        $html .= '<table border="1" cellpadding="6"><thead><tr>';

        foreach (array_keys($product_list[0]) as $column) {
            $html .= '<th>' . htmlspecialchars($column) . '</th>';
        }
        $html .= '<th>Actions</th></tr></thead><tbody>';

        foreach ($product_list as $row) {
            $isEditing = ($action === 'edit' && $editingId == $row['product_id']);
            $html .= '<form method="post" enctype="multipart/form-data"><tr>';
            $html .= '<input type="hidden" name="action" value="update-product">';
            $html .= '<input type="hidden" name="product_id" value="' . $row['product_id'] . '">';
            $html .= '<input type="hidden" name="product_type" value="' . htmlspecialchars($type) . '">';
            $html .= '<input type="hidden" name="id" value="' . $row['id'] . '">';

            foreach ($row as $key => $value) {
                $html .= '<td>';
                if ($isEditing && $key === 'image_url') {
                    $html .= '<input type="hidden" name="existing_image" value="' . htmlspecialchars($value) . '">';
                    $html .= '<input type="file" name="product_image" accept="image/*">';
                    if ($value) {
                        $html .= '<small>Current: ' . htmlspecialchars(basename($value)) . '</small>';
                    }
                } elseif ($isEditing && $key !== 'product_id' && $key !== 'id') {
                    $html .= '<input type="text" name="' . htmlspecialchars($key) . '" value="' . htmlspecialchars($value) . '" style="width:100%">';
                } else {
                    $html .= htmlspecialchars((string) $value);
                }
                $html .= '</td>';
            }

            $html .= '<td>';
            if ($isEditing) {
                $html .= '<button type="submit" onclick="return confirm(\'Save changes?\')">Save</button> | ';
                $html .= '<a href="?page=products&type=' . $type . '">Cancel</a>';
            } else {
                $html .= '<a href="?page=products&type=' . $type . '&action=edit&id=' . $row['product_id'] . '">Edit</a> | ';
                $html .= '<a href="?page=products&type=' . $type . '&action=delete&id=' . $row['product_id'] . '" onclick="return confirm(\'Delete this product?\')">Delete</a>';
            }
            $html .= '</td>';

            $html .= '</tr></form>';
        }

        $html .= '</tbody></table></section>';

        return $html;
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
                    <button type="submit" class="btn-primary">Create</button>
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
                    <button type="submit" class="btn-primary">Create</button>
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
                    <button type="submit" class="btn-primary">Create</button>
                </div>
            </form>
        </section>
        <?php
        return ob_get_clean();
    }

    public function new_product_form_handler($product_type): string
    {
        if ($product_type instanceof Product_P) {
            return $this->new_physical_product_form();
        } elseif ($product_type instanceof Product_D) {
            return $this->new_digital_product_form();
        } elseif ($product_type instanceof Product_L) {
            return $this->new_live_product_form();
        } else {
            return '<p>Invalid product type.</p>';
        }
    }
}
