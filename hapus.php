<?php
// Nama : Ibnu Hanafi Assalam
// NIM  : A12.2023.06994

// hapus.php
include 'config.php';

function sendResponse($status, $message)
{
    if (
        isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
        strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
    ) {
        header('Content-Type: application/json');
        echo json_encode([
            'status' => $status,
            'message' => $message
        ]);
        exit;
    } else {
        header("Location: galeri.php?msg=" . urlencode($message));
        exit();
    }
}

function logActivity($action, $details)
{
    $logFile = "logs/activity_log.txt";
    $logDir = dirname($logFile);
    if (!file_exists($logDir)) {
        mkdir($logDir, 0777, true);
    }
    $timestamp = date('Y-m-d H:i:s');
    $ip = $_SERVER['REMOTE_ADDR'];
    $logMessage = "[$timestamp] IP: $ip - $action - $details\n";
    file_put_contents($logFile, $logMessage, FILE_APPEND);
}

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    sendResponse('error', "Metode akses tidak valid.");
}

if (!isset($_POST['id']) || empty($_POST['id'])) {
    sendResponse('error', "ID gambar tidak valid.");
}

try {
    $id = $_POST['id'];
    $filepath = isset($_POST['filepath']) ? $_POST['filepath'] : '';
    $thumbpath = isset($_POST['thumbpath']) ? $_POST['thumbpath'] : '';

    // Jika path tidak tersedia, ambil dari database
    if (empty($filepath) || empty($thumbpath)) {
        $stmt = $conn->prepare("SELECT filepath, thumbpath FROM gambar WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $filepath = $filepath ?: $row['filepath'];
            $thumbpath = $thumbpath ?: $row['thumbpath'];
        } else {
            throw new Exception("Gambar tidak ditemukan dalam database.");
        }
        $stmt->close();
    }

    // Hapus file dari server
    if (file_exists($filepath)) {
        if (!unlink($filepath)) {
            throw new Exception("Gagal menghapus file gambar asli.");
        }
    }
    if (file_exists($thumbpath)) {
        if (!unlink($thumbpath)) {
            throw new Exception("Gagal menghapus file thumbnail.");
        }
    }

    // Hapus data dari database
    $stmt = $conn->prepare("DELETE FROM gambar WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $details = "Gambar ID: $id, File: " . basename($filepath);
        logActivity("DELETE_IMAGE", $details);
        sendResponse('success', "Gambar berhasil dihapus.");
    } else {
        throw new Exception("Gagal menghapus data gambar dari database.");
    }
} catch (Exception $e) {
    sendResponse('error', "Error: " . $e->getMessage());
} finally {
    if (isset($stmt)) {
        $stmt->close();
    }
    $conn->close();
}
