<?php
require_once 'vendor/autoload.php';

// Test data
$data = [
    '_token' => 'test-token', // Hardcoded untuk testing
    'nama_layanan' => 'Test Layanan ' . date('H:i:s'),
    'kategori' => 'kependudukan',
    'persyaratan' => [
        'Test Requirement 1',
        'Test Requirement 2'
    ]
];

// Send POST request
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://127.0.0.1:8000/admin/layanan');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Follow redirects

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Code: $httpCode\n";
echo "Response:\n";
echo $response . "\n";

if ($httpCode == 302 || $httpCode == 200) {
    echo "✅ SUCCESS: Form berhasil submit dan data tersimpan!\n";
} else {
    echo "❌ ERROR: Form gagal submit (HTTP $httpCode)\n";
}
?>
