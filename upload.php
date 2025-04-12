<?php
// Nama : Ibnu Hanafi Assalam
// NIM  : A12.2023.06994
include 'config.php';

ini_set('upload_max_filesize', '1M');
ini_set('post_max_size', '2M');
ini_set('memory_limit', '32M');

function sendResponse($status, $message, $data = null)
{
    if (
        isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
        strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
    ) {
        header('Content-Type: application/json');
        echo json_encode([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ]);
        exit;
    } else {
        $redirect = ($status == 'success') ? 'galeri.php' : 'index1.php';
        header("Location: $redirect?msg=" . urlencode($message));
        exit;
    }
}

$uploadDir = "uploads/";
$thumbDir  = "thumbnails/";

if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}
if (!file_exists($thumbDir)) {
    mkdir($thumbDir, 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_FILES['gambar']) || $_FILES['gambar']['error'] != 0) {
        sendResponse('error', "Error: Tidak ada file yang diupload atau terjadi kesalahan.");
    }

    $gambar = $_FILES['gambar'];
    $imageFileType = strtolower(pathinfo($gambar['name'], PATHINFO_EXTENSION));

    // Validasi apakah file adalah gambar
    $check = getimagesize($gambar['tmp_name']);
    if ($check === false) {
        sendResponse('error', "Error: File yang diupload bukan gambar.");
    }

    // Batasi jenis file (hanya JPG, JPEG, PNG)
    $allowed = array('jpg', 'jpeg', 'png');
    if (!in_array($imageFileType, $allowed)) {
        sendResponse('error', "Error: Hanya file JPG, JPEG, dan PNG yang diperbolehkan.");
    }

    // Batasi ukuran file maksimum 1MB
    if ($gambar['size'] > 1 * 1024 * 1024) { // 1MB
        sendResponse('error', "Error: Ukuran file terlalu besar, maksimal 1 MB.");
    }

    // Tentukan nama file baru dengan timestamp dan string acak untuk keunikan
    $randomString = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz0123456789"), 0, 6);
    $newFilename = time() . "_" . $randomString . "." . $imageFileType;
    $targetFile = $uploadDir . $newFilename;

    list($width, $height) = $check;
    $maxDimension = 1024; // Resize jika lebih dari 1024px

    if ($width > $maxDimension || $height > $maxDimension) {
        $scale = min($maxDimension / $width, $maxDimension / $height);
        $newWidth = (int)($width * $scale);
        $newHeight = (int)($height * $scale);
    } else {
        $newWidth = $width;
        $newHeight = $height;
    }

    // Buat objek gambar dari file upload berdasarkan tipe
    if ($imageFileType == 'jpg' || $imageFileType == 'jpeg') {
        $src = imagecreatefromjpeg($gambar['tmp_name']);
    } elseif ($imageFileType == 'png') {
        $src = imagecreatefrompng($gambar['tmp_name']);
    } else {
        sendResponse('error', "Error: Format gambar tidak didukung.");
    }

    // Lakukan resize gambar
    $resizedImage = imagecreatetruecolor($newWidth, $newHeight);
    if ($imageFileType == 'png') {
        // Pertahankan transparansi untuk PNG
        imagealphablending($resizedImage, false);
        imagesavealpha($resizedImage, true);
        $transparent = imagecolorallocatealpha($resizedImage, 255, 255, 255, 127);
        imagefilledrectangle($resizedImage, 0, 0, $newWidth, $newHeight, $transparent);
    }
    imagecopyresampled($resizedImage, $src, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

    if ($imageFileType == 'jpg' || $imageFileType == 'jpeg') {
        imagejpeg($resizedImage, $targetFile, 90);
    } elseif ($imageFileType == 'png') {
        imagepng($resizedImage, $targetFile, 9);
    }
    imagedestroy($resizedImage);
    imagedestroy($src);

    // Pembuatan thumbnail (lebar 250px secara proporsional)
    $thumbFilename = "thumb_" . $newFilename;
    $thumbFile = $thumbDir . $thumbFilename;
    $thumbWidth = 250;
    $thumbHeight = (int)($newHeight * ($thumbWidth / $newWidth));

    $thumbImage = imagecreatetruecolor($thumbWidth, $thumbHeight);
    if ($imageFileType == 'png') {
        imagealphablending($thumbImage, false);
        imagesavealpha($thumbImage, true);
        $transparent = imagecolorallocatealpha($thumbImage, 255, 255, 255, 127);
        imagefilledrectangle($thumbImage, 0, 0, $thumbWidth, $thumbHeight, $transparent);
    }
    if ($imageFileType == 'jpg' || $imageFileType == 'jpeg') {
        $sourceImage = imagecreatefromjpeg($targetFile);
    } elseif ($imageFileType == 'png') {
        $sourceImage = imagecreatefrompng($targetFile);
    }
    imagecopyresampled($thumbImage, $sourceImage, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $newWidth, $newHeight);
    if ($imageFileType == 'jpg' || $imageFileType == 'jpeg') {
        imagejpeg($thumbImage, $thumbFile, 90);
    } elseif ($imageFileType == 'png') {
        imagepng($thumbImage, $thumbFile, 9);
    }
    imagedestroy($thumbImage);
    imagedestroy($sourceImage);

    // Data untuk database
    $filename  = $newFilename;
    $filepath  = $targetFile;
    $thumbpath = $thumbFile;
    $filesize  = $gambar['size'];
    $filetype  = $gambar['type'];

    try {
        $sql = "INSERT INTO gambar (filename, filepath, thumbpath, width, height, filesize, filetype) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Prepare statement error: " . $conn->error);
        }
        $stmt->bind_param("sssiiss", $filename, $filepath, $thumbpath, $newWidth, $newHeight, $filesize, $filetype);
        if ($stmt->execute()) {
            $msg = "Gambar berhasil diupload dan disimpan!";
            sendResponse('success', $msg, [
                'filename' => $filename,
                'filepath' => $filepath,
                'thumbpath' => $thumbpath,
                'width' => $newWidth,
                'height' => $newHeight
            ]);
        } else {
            throw new Exception("Gagal menyimpan informasi ke database.");
        }
    } catch (Exception $e) {
        // Hapus file yang sudah diupload jika gagal simpan ke database
        if (file_exists($targetFile)) unlink($targetFile);
        if (file_exists($thumbFile)) unlink($thumbFile);
        sendResponse('error', "Error: " . $e->getMessage());
    }
    $stmt->close();
    $conn->close();
} else {
    sendResponse('error', "Akses tidak valid.");
}
