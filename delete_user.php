<?php
// header("Content-Type: application/json");

// include 'db_config.php'; // Pastikan file ini berisi informasi koneksi database Anda

// // Memeriksa apakah metode yang digunakan adalah HTTP DELETE
// if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
//     // Mendapatkan data dari URL atau body permintaan
//     parse_str(file_get_contents("php://input"), $_DELETE);

//     // Validasi data
//     if (!isset($_DELETE['id'])) {
//         echo json_encode(["error" => "Invalid input: ID is required"]);
//         exit;
//     }

//     $userId = $_DELETE['id'];

//     // Menyiapkan query DELETE menggunakan prepared statements
//     $stmt = $koneksi->prepare("DELETE FROM users WHERE id = $userId");
//     $stmt->bind_param("i", $userId); // 'i' menunjukkan bahwa parameter adalah integer

//     if ($stmt->execute()) {
//         echo json_encode(["success" => true, "message" => "User deleted successfully"]);
//     } else {
//         echo json_encode(["error" => $stmt->error]);
//     }

//     $stmt->close();
//     $koneksi->close();
// } else {
//     // Menyiapkan respons jika metode yang digunakan bukan DELETE
//     echo json_encode(["error" => "Invalid request method"]);
// }
// Ambil ID pengguna dari URL

$url = $_SERVER['REQUEST_URI'];
$parts = explode('/', $url);
$userId = end($parts); // ID pengguna adalah elemen terakhir dalam array

// Lakukan validasi ID pengguna (misalnya, pastikan itu adalah angka positif)

// Hapus pengguna dari basis data
// Contoh: menghubungkan ke basis data dan menjalankan query DELETE
$server = "localhost";
$username = "root";
$password = "";
$dbname = "db_akademik";

$conn = mysqli_connect($server, $username, $password, $dbname);
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$sql = "DELETE FROM users WHERE id = '$userId'"; // Ganti 'users' dengan nama tabel Anda
if (mysqli_query($conn, $sql)) {
    echo "Pengguna dengan ID $userId telah dihapus.";
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
