<?php
require_once 'models/Product.php';
require_once 'models/Inventory.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['product_id'];
    $quantity = (int) $_POST['quantity'];
    $type = $_POST['type'];

    if (!$productId || !$quantity || !$type) {
        header('Location: views/add_transaction.php?error=Isi semua field');
        exit;
    }

    $product = Product::find($productId);
    if (!$product) {
        header('Location: views/add_transaction.php?error=Produk tidak ditemukan');
        exit;
    }

    if ($type === 'out') {
        if ($quantity > $product->stock) {
            header('Location: views/add_transaction.php?error=Stok tidak mencukupi!');
            exit;
        }

        // Simulasi FIFO: Kurangi stok duluan dari yang lebih lama masuk (jika pakai sistem batch real)
        // Tapi di versi sederhana ini kita hanya update stok langsung

        $invMasuk = Inventory::getInventoryIn($productId);
        $sisaKeluar = $quantity;

        foreach ($invMasuk as $batch) {
            if ($batch->sisa >= $sisaKeluar) {
                Inventory::updateSisa($batch->id, $batch->sisa - $sisaKeluar);
                break;
            } else {
                $sisaKeluar -= $batch->sisa;
                Inventory::updateSisa($batch->id, 0);
            }
        }
        $product->stock -= $quantity;
        $sisa = 0;
    } else {
        $product->stock += $quantity;
        $sisa = $quantity;

        // Validasi jika melebihi max_stock
        if ($product->stock > $product->max_stock) {
            // hanya warning, tetap disimpan
            $warning = "Stok melebihi maksimum yang disarankan!";
        }
    }

    // Simpan perubahan stok produk
    Product::updateStock($productId, $product->stock);

    // Catat transaksi
    Inventory::create([
        'product_id' => $productId,
        'quantity' => $quantity,
        'type' => $type,
        'sisa' => $sisa,
        'created_at' => date('Y-m-d H:i:s')
    ]);

    $msg = $type === 'in' ? 'Stok berhasil ditambahkan' : 'Stok berhasil dikurangi';
    header("Location: views/dashboard.php?success=$msg");
    exit;
}
