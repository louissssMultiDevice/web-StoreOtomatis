<?php
// Ambil data pembayaran dari sistem pembayaran
$paymentStatus = $_POST['payment_status'];
$paymentAmount = $_POST['payment_amount'];
$userEmail = $_POST['user_email'];

// Jika pembayaran berhasil
if ($paymentStatus == 'completed') {
    // Kirim permintaan ke API Virtusim untuk mendapatkan nomor kosong
    $apiKey = 'HgJh1K2LT6WBaeSrFObu8spIdjAYDP';
    $url = "https://api.virtusim.com/v1/nomor/get?api_key=$apiKey";

    // Inisialisasi cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    curl_close($ch);

    // Decode response dari API
    $responseData = json_decode($response, true);
    
    if ($responseData['status'] == 'success') {
        $nomor = $responseData['data']['nomor'];

        // Kirim email atau WhatsApp notifikasi ke pengguna
        mail($userEmail, "Nomor Virtual Anda Siap", "Nomor Virtual Anda: $nomor");

        // Update status di database untuk memberitahu pengguna bahwa nomor telah dikirim
        echo "Nomor virtual berhasil dikirim: $nomor";
    } else {
        echo "Gagal mendapatkan nomor, coba lagi.";
    }
} else {
    echo "Pembayaran gagal.";
}
?>
