<?php
/**
 * Process Form Submissions
 * Mega Kayan Ganesha
 */

require_once __DIR__ . '/config/database.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$action = $_POST['action'] ?? '';

try {
    $db = getDB();
    
    switch ($action) {
        case 'pelamar':
            // Handle job application
            $nama = htmlspecialchars(trim($_POST['nama']));
            $email = htmlspecialchars(trim($_POST['email']));
            $telepon = htmlspecialchars(trim($_POST['telepon']));
            $alamat = htmlspecialchars(trim($_POST['alamat']));
            $pendidikan = htmlspecialchars(trim($_POST['pendidikan']));
            $pengalaman = htmlspecialchars(trim($_POST['pengalaman']));
            $posisi = htmlspecialchars(trim($_POST['posisi']));
            $motivasi = htmlspecialchars(trim($_POST['motivasi']));
            
            // Handle file uploads
            $cv_file = null;
            $foto_file = null;
            
            if (isset($_FILES['cv_file']) && $_FILES['cv_file']['error'] == UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/uploads/pelamar/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                $cv_file = uniqid() . '_' . time() . '_' . basename($_FILES['cv_file']['name']);
                move_uploaded_file($_FILES['cv_file']['tmp_name'], $uploadDir . $cv_file);
            }
            
            if (isset($_FILES['foto_file']) && $_FILES['foto_file']['error'] == UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/uploads/pelamar/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                $foto_file = uniqid() . '_' . time() . '_' . basename($_FILES['foto_file']['name']);
                move_uploaded_file($_FILES['foto_file']['tmp_name'], $uploadDir . $foto_file);
            }
            
            $stmt = $db->prepare("INSERT INTO pelamar (nama, email, telepon, alamat, pendidikan, pengalaman, posisi, motivasi, cv_file, foto_file) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$nama, $email, $telepon, $alamat, $pendidikan, $pengalaman, $posisi, $motivasi, $cv_file, $foto_file]);
            
            echo json_encode(['success' => true, 'message' => 'Lamaran Anda berhasil dikirim!']);
            break;
            
        case 'pengajuan_gadai':
            // Handle gadai application
            $nama = htmlspecialchars(trim($_POST['nama']));
            $telepon = htmlspecialchars(trim($_POST['telepon']));
            $email = htmlspecialchars(trim($_POST['email']));
            $jenis_barang = htmlspecialchars(trim($_POST['jenis_barang']));
            $deskripsi = htmlspecialchars(trim($_POST['deskripsi']));
            
            $foto_barang = null;
            if (isset($_FILES['foto_barang']) && $_FILES['foto_barang']['error'] == UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/uploads/pengajuan/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                $foto_barang = uniqid() . '_' . time() . '_' . basename($_FILES['foto_barang']['name']);
                move_uploaded_file($_FILES['foto_barang']['tmp_name'], $uploadDir . $foto_barang);
            }
            
            $stmt = $db->prepare("INSERT INTO pengajuan_gadai (nama, telepon, email, jenis_barang, deskripsi, foto_barang) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$nama, $telepon, $email, $jenis_barang, $deskripsi, $foto_barang]);
            
            echo json_encode(['success' => true, 'message' => 'Pengajuan gadai Anda berhasil dikirim!']);
            break;
            
        case 'pemesanan_cocoa':
            // Handle cocoa order
            $nama = htmlspecialchars(trim($_POST['nama']));
            $telepon = htmlspecialchars(trim($_POST['telepon']));
            $email = htmlspecialchars(trim($_POST['email']));
            $produk = htmlspecialchars(trim($_POST['produk']));
            $jumlah = floatval($_POST['jumlah']);
            $alamat = htmlspecialchars(trim($_POST['alamat']));
            
            $stmt = $db->prepare("INSERT INTO pemesanan_cocoa (nama, telepon, email, produk, jumlah, alamat) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$nama, $telepon, $email, $produk, $jumlah, $alamat]);
            
            echo json_encode(['success' => true, 'message' => 'Pemesanan Anda berhasil dikirim!']);
            break;
            
        case 'pemesanan_farm':
            // Handle farm order/cooperation
            $nama = htmlspecialchars(trim($_POST['nama']));
            $telepon = htmlspecialchars(trim($_POST['telepon']));
            $email = htmlspecialchars(trim($_POST['email']));
            $tipe = htmlspecialchars(trim($_POST['tipe']));
            $pesan = htmlspecialchars(trim($_POST['pesan']));
            
            $stmt = $db->prepare("INSERT INTO pemesanan_farm (nama, telepon, email, tipe, pesan) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$nama, $telepon, $email, $tipe, $pesan]);
            
            echo json_encode(['success' => true, 'message' => 'Pesan Anda berhasil dikirim!']);
            break;
            
        case 'kontak':
            // Handle contact form
            $nama = htmlspecialchars(trim($_POST['nama']));
            $email = htmlspecialchars(trim($_POST['email']));
            $telepon = htmlspecialchars(trim($_POST['telepon'] ?? ''));
            $subjek = htmlspecialchars(trim($_POST['subjek']));
            $pesan = htmlspecialchars(trim($_POST['pesan']));
            
            $stmt = $db->prepare("INSERT INTO kontak (nama, email, telepon, subjek, pesan) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$nama, $email, $telepon, $subjek, $pesan]);
            
            echo json_encode(['success' => true, 'message' => 'Pesan Anda berhasil dikirim!']);
            break;
            
        case 'testimoni':
            // Handle testimonial submission
            $nama = htmlspecialchars(trim($_POST['nama']));
            $jabatan = htmlspecialchars(trim($_POST['jabatan'] ?? ''));
            $perusahaan = htmlspecialchars(trim($_POST['perusahaan'] ?? ''));
            $testimoni = htmlspecialchars(trim($_POST['testimoni']));
            $rating = intval($_POST['rating']);
            $kategori = htmlspecialchars(trim($_POST['kategori'] ?? 'umum'));
            
            $foto = null;
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/uploads/testimoni/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                $foto = uniqid() . '_' . time() . '_' . basename($_FILES['foto']['name']);
                move_uploaded_file($_FILES['foto']['tmp_name'], $uploadDir . $foto);
            }
            
            $stmt = $db->prepare("INSERT INTO testimoni (nama, jabatan, perusahaan, testimoni, rating, foto, kategori, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'pending')");
            $stmt->execute([$nama, $jabatan, $perusahaan, $testimoni, $rating, $foto, $kategori]);
            
            echo json_encode(['success' => true, 'message' => 'Testimoni Anda berhasil dikirim! Menunggu persetujuan admin.']);
            break;
            
        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
}

