<?php
// notif.php
// Webhook dipanggil setelah pembelian sukses

$data = json_decode(file_get_contents('php://input'), true);

$nomor = $data['nomor'];
$layanan = $data['layanan'];
$harga = $data['harga'];
$id_pesanan = $data['id'];

$pesan = "ADA ORDER MASUK!\n\nLayanan: $layanan\nNomor: $nomor\nHarga: Rp$harga\nID: $id_pesanan";

$url = "http://localhost:5000/notif"; // Ganti kalau bot ada di VPS

$post = [
  'pesan' => $pesan,
];

// Kirim ke bot lokal
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$res = curl_exec($ch);
curl_close($ch);

echo "OK";
?>
