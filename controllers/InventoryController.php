<?php
require_once 'models/Inventory.php';

class InventoryController {
    public static function stockIn($product_id, $quantity) {
        Inventory::fifoIn($product_id, $quantity);
        header("Location: dashboard.php?success=Stok masuk berhasil");
        exit;
    }

    public static function stockOut($product_id, $quantity) {
        $product = Product::find($product_id);
        if ($product->stock < $quantity) {
            header("Location: views/add_transaction.php?error=Stok tidak mencukupi");
            exit;
        }

        if (($product->stock - $quantity) < $product->min_stock) {
            header("Location: views/add_transaction.php?error=Transaksi akan menurunkan stok di bawah batas minimum!");
            exit;
        }

        Inventory::fifoOut($product_id, $quantity);
        header("Location: dashboard.php?success=Stok keluar berhasil");
        exit;
    }
}
