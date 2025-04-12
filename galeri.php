<?php
// Nama : Ibnu Hanafi Assalam
// NIM  : A12.2023.06994

// galeri.php
include 'config.php';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Upload Gambar - IbnuPicVaultProject</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --accent-color: #4cc9f0;
            --success-color: #4ade80;
            --danger-color: #ef4444;
            --light-bg: #f8fafc;
            --card-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        body {
            padding-top: 80px;
            background-color: var(--light-bg);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #334155;
        }

        .navbar {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            letter-spacing: 0.5px;
        }

        .nav-link {
            font-weight: 500;
            text-transform: uppercase;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
            padding: 0.5rem 1rem;
            margin: 0 0.25rem;
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.15);
        }

        .nav-link.active {
            background-color: rgba(255, 255, 255, 0.25);
        }

        .page-title {
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 2rem;
            position: relative;
            display: inline-block;
            padding-bottom: 0.5rem;
        }

        .page-title:after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 50px;
            height: 4px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 2px;
        }

        .alert {
            border-radius: 10px;
            border: none;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .alert-info {
            background-color: rgba(67, 97, 238, 0.15);
            color: var(--primary-color);
        }

        .gallery-card {
            border: none;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
            height: 100%;
            position: relative;
        }

        .gallery-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .gallery-card .card-img-top {
            height: 220px;
            object-fit: cover;
            transition: all 0.5s ease;
        }

        .gallery-card:hover .card-img-top {
            transform: scale(1.05);
        }

        .gallery-card .card-body {
            padding: 1.25rem;
            background-color: white;
        }

        .gallery-card .card-text {
            color: #64748b;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        .gallery-card .card-footer {
            background-color: white;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            padding: 1rem 1.25rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn-view {
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 6px;
            padding: 0.5rem 1rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-view:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
        }

        .btn-delete {
            background-color: #fee2e2;
            color: var(--danger-color);
            border: none;
            border-radius: 6px;
            padding: 0.5rem 1rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-delete:hover {
            background-color: var(--danger-color);
            color: white;
            transform: translateY(-2px);
        }

        .empty-gallery {
            padding: 5rem 2rem;
            text-align: center;
            background-color: white;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
        }

        .empty-gallery i {
            font-size: 4rem;
            color: #cbd5e1;
            margin-bottom: 1.5rem;
        }

        .empty-gallery p {
            font-size: 1.25rem;
            color: #64748b;
            margin-bottom: 1.5rem;
        }

        .empty-gallery .btn {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: 8px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px -1px rgba(67, 97, 238, 0.3);
            color: white;
        }

        .empty-gallery .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(67, 97, 238, 0.4);
        }

        /* Modal Styles */
        .modal-content {
            border: none;
            border-radius: 12px;
            overflow: hidden;
        }

        .modal-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-bottom: none;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-img {
            width: 100%;
            border-radius: 8px;
            box-shadow: var(--card-shadow);
        }

        .img-info {
            margin-top: 1.5rem;
            padding: 1rem;
            background-color: #f8fafc;
            border-radius: 8px;
        }

        .img-info p {
            margin-bottom: 0.5rem;
            color: #475569;
        }

        @media (max-width: 768px) {
            .gallery-card .card-img-top {
                height: 180px;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="fas fa-cloud-upload-alt"></i> IbnuPicVaultProject </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index1.php"><i class="fas fa-upload"></i> Upload</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="galeri.php"><i class="fas fa-images"></i> Galeri</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-4">
        <?php
        if (isset($_GET['msg'])) {
            echo '<div class="alert alert-info alert-dismissible fade show" role="alert">
                    <i class="fas fa-info-circle me-2"></i>' . htmlspecialchars($_GET['msg']) . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
        }
        ?>
        <div class="text-center mb-5">
            <h2 class="page-title">Galeri Gambar</h2>
        </div>
        <?php
        $sql = "SELECT * FROM gambar ORDER BY uploaded_at DESC";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            echo '<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">';
            while ($row = $result->fetch_assoc()) {
        ?>
                <div class="col">
                    <div class="gallery-card">
                        <div class="overflow-hidden">
                            <img src="<?= htmlspecialchars($row['thumbpath']) ?>" class="card-img-top" alt="Gambar">
                        </div>
                        <div class="card-body">
                            <p class="card-text">
                                <i class="fas fa-calendar-alt me-2"></i> <?= date('d M Y, H:i', strtotime($row['uploaded_at'])) ?>
                            </p>
                            <p class="card-text">
                                <i class="fas fa-expand-arrows-alt me-2"></i> <?= htmlspecialchars($row['width']) ?> x <?= htmlspecialchars($row['height']) ?> px
                            </p>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-view" data-bs-toggle="modal" data-bs-target="#imageModal<?= $row['id'] ?>">
                                <i class="fas fa-eye"></i> Lihat
                            </button>
                            <form action="hapus.php" method="post" class="d-inline" onsubmit="return confirm('Anda yakin ingin menghapus gambar ini?')">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($row['id']) ?>">
                                <input type="hidden" name="filepath" value="<?= htmlspecialchars($row['filepath']) ?>">
                                <input type="hidden" name="thumbpath" value="<?= htmlspecialchars($row['thumbpath']) ?>">
                                <button type="submit" class="btn btn-delete">
                                    <i class="fas fa-trash-alt"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Modal for image detail -->
                <div class="modal fade" id="imageModal<?= $row['id'] ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Detail Gambar</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <img src="<?= htmlspecialchars($row['filepath']) ?>" class="modal-img" alt="Gambar Full">
                                <div class="img-info mt-3">
                                    <p><i class="fas fa-file-image me-2"></i> Nama: <?= htmlspecialchars($row['filename']) ?></p>
                                    <p><i class="fas fa-expand-arrows-alt me-2"></i> Dimensi: <?= htmlspecialchars($row['width']) ?> x <?= htmlspecialchars($row['height']) ?> px</p>
                                    <p><i class="fas fa-calendar-alt me-2"></i> Diupload: <?= date('d M Y, H:i', strtotime($row['uploaded_at'])) ?></p>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <a href="<?= htmlspecialchars($row['filepath']) ?>" class="btn btn-view" download>
                                    <i class="fas fa-download"></i> Download
                                </a>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
            echo '</div>';
        } else {
            ?>
            <div class="empty-gallery text-center">
                <i class="fas fa-images"></i>
                <p>Belum ada gambar yang diupload.</p>
                <a href="index1.php" class="btn"><i class="fas fa-upload"></i> Upload Gambar Sekarang</a>
            </div>
        <?php
        }
        $conn->close();
        ?>
    </div>
    <footer class="mt-5 py-4 text-center text-muted">
        <div class="container">
            <p>IbnuPicVaultProject - A12.2023.06994 &copy; <?= date('Y') ?> | Tempat terbaik untuk menyimpan kenangan visual Anda</p>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-dismiss alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    const closeButton = alert.querySelector('.btn-close');
                    if (closeButton) {
                        closeButton.click();
                    }
                }, 5000);
            });
        });
    </script>
</body>

</html>