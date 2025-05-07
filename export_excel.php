<?php
require_once 'models/Inventory.php';
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=laporan_inventory.xls");

$data = Inventory::all();

echo "Produk\tJumlah\tJenis\tWaktu\n";
foreach ($data as $row) {
    echo "{$row->product_name}\t{$row->quantity}\t{$row->type}\t{$row->created_at}\n";
}
?>
