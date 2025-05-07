<?php
require_once 'vendor/autoload.php';
require_once 'models/Inventory.php';

use Dompdf\Dompdf;

$data = Inventory::all();

$html = '<h3>Laporan Transaksi</h3><table border="1" cellpadding="5"><tr><th>Produk</th><th>Jumlah</th><th>Jenis</th><th>Waktu</th></tr>';
foreach ($data as $row) {
    $html .= "<tr>
                <td>{$row->product_name}</td>
                <td>{$row->quantity}</td>
                <td>{$row->type}</td>
                <td>{$row->created_at}</td>
              </tr>";
}
$html .= '</table>';

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->render();
$dompdf->stream("laporan_inventory.pdf");
