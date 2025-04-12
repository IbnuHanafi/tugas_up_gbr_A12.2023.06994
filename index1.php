<!-- Nama : Ibnu Hanafi Assalam -->
<!-- NIM  : A12.2023.06994 -->
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Gambar - IbnuPicVaultProject</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --accent-color: #4cc9f0;
            --success-color: #4ade80;
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

        .navbar-brand i {
            margin-right: 8px;
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

        .upload-container {
            max-width: 800px;
            margin: 2rem auto;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            font-weight: 600;
            padding: 1.25rem 1.5rem;
            font-size: 1.25rem;
            border-bottom: none;
        }

        .card-header i {
            margin-right: 10px;
        }

        .card-body {
            padding: 2rem;
        }

        .drag-area {
            border: 2px dashed var(--primary-color);
            border-radius: 12px;
            padding: 3rem 2rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background-color: rgba(67, 97, 238, 0.05);
            margin-bottom: 1.5rem;
        }

        .drag-area:hover {
            background-color: rgba(67, 97, 238, 0.1);
        }

        .drag-area.hover {
            background-color: rgba(67, 97, 238, 0.15);
            border-color: var(--secondary-color);
        }

        .drag-area i {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .drag-area p {
            font-size: 1.1rem;
            font-weight: 500;
            color: #475569;
            margin-bottom: 0;
        }

        .drag-area small {
            display: block;
            margin-top: 0.5rem;
            color: #64748b;
        }

        .btn-upload {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: 8px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px -1px rgba(67, 97, 238, 0.3);
        }

        .btn-upload:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(67, 97, 238, 0.4);
        }

        /* Bagian preview */
        .upload-preview {
            text-align: center;
            margin-top: 1.5rem;
            padding: 1.5rem;
            border-radius: 12px;
            background-color: rgba(67, 97, 238, 0.05);
            display: none;
            /* disembunyikan awal, nanti dimunculkan via JS */
            position: relative;
        }

        .preview-image {
            max-height: 200px;
            border-radius: 8px;
            box-shadow: var(--card-shadow);
        }

        .preview-message {
            font-weight: 600;
            margin-top: 1rem;
        }

        /* Tombol batalkan */
        .btn-cancel-upload {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #ef4444;
            color: white;
            border: none;
            border-radius: 50%;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px -1px rgba(239, 68, 68, 0.3);
        }

        .btn-cancel-upload:hover {
            background-color: #dc2626;
            transform: scale(1.1);
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="fas fa-cloud-upload-alt"></i>IbnuPicVaultProject</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index1.php"><i class="fas fa-upload"></i> Upload</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="galeri.php"><i class="fas fa-images"></i> Galeri</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container upload-container">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-file-upload"></i> Upload Gambar Anda
            </div>
            <div class="card-body">
                <!-- Form Upload -->
                <form id="uploadForm" action="upload.php" method="post" enctype="multipart/form-data">
                    <div class="mb-4">
                        <!-- Area Drag & Drop -->
                        <div id="dropArea" class="drag-area">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <p>Tarik & Lepas Gambar Anda Di Sini</p>
                            <small>atau klik untuk memilih dari perangkat Anda</small>
                        </div>
                        <!-- Input file disembunyikan, di-trigger oleh dropArea -->
                        <input type="file" class="form-control d-none" id="gambar" name="gambar" accept="image/*" required>
                    </div>

                    <!-- Preview Pilihan File -->
                    <div id="uploadPreview" class="upload-preview">
                        <button type="button" id="cancelUpload" class="btn-cancel-upload">
                            <i class="fas fa-times"></i>
                        </button>
                        <img id="previewImage" class="preview-image" src="#" alt="Preview Gambar">
                        <p id="previewMessage" class="preview-message text-success"></p>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-upload">
                            <i class="fas fa-upload"></i> Upload Gambar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Informasi tipe file dan size -->
        <div class="text-center mt-4 text-muted">
            <p>Diperbolehkan: JPG, JPEG, PNG | Ukuran Max: 1MB</p>
        </div>
    </div>

    <!-- Footer di bawah tulisan info file -->
    <footer class="mt-5 py-4 text-center text-muted">
        <div class="container">
            <p>IbnuPicVaultProject - A12.2023.06994 &copy; <?= date('Y') ?> | Tempat terbaik untuk menyimpan kenangan visual Anda</p>
        </div>
    </footer>

    <!-- Script -->
    <script>
        const dropArea = document.getElementById('dropArea');
        const fileInput = document.getElementById('gambar');
        const uploadPreview = document.getElementById('uploadPreview');
        const previewImage = document.getElementById('previewImage');
        const previewMessage = document.getElementById('previewMessage');
        const cancelUploadBtn = document.getElementById('cancelUpload');

        // Klik area drop => klik fileInput
        dropArea.addEventListener('click', () => fileInput.click());

        // Drag over => style area
        dropArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropArea.classList.add('hover');
        });

        // Drag leave => reset style
        dropArea.addEventListener('dragleave', () => {
            dropArea.classList.remove('hover');
        });

        // Drop file => masukkan file ke input
        dropArea.addEventListener('drop', (e) => {
            e.preventDefault();
            dropArea.classList.remove('hover');
            if (e.dataTransfer.files.length > 0) {
                fileInput.files = e.dataTransfer.files;
                previewSelectedFile(e.dataTransfer.files[0]);
            }
        });

        // Saat file dipilih (manual)
        fileInput.addEventListener('change', () => {
            if (fileInput.files && fileInput.files.length > 0) {
                previewSelectedFile(fileInput.files[0]);
            }
        });

        // Tombol batalkan upload
        cancelUploadBtn.addEventListener('click', () => {
            // Hapus file dari input
            fileInput.value = '';
            // Sembunyikan preview
            uploadPreview.style.display = 'none';
            // Reset pesan
            previewMessage.textContent = '';
            // Reset gambar preview
            previewImage.src = '#';
        });

        // Fungsi untuk menampilkan preview
        function previewSelectedFile(file) {
            // Validasi tipe gambar
            if (!file.type.match('image.*')) {
                alert('Hanya file gambar yang diperbolehkan!');
                return;
            }

            // Validasi ukuran file (max 1MB)
            if (file.size > 1 * 1024 * 1024) {
                alert('Ukuran file terlalu besar. Maksimal 1MB.');
                return;
            }

            // FileReader untuk membaca data
            const reader = new FileReader();
            reader.onload = (e) => {
                previewImage.src = e.target.result;
                uploadPreview.style.display = 'block';
                previewMessage.textContent = 'File sukses dipilih, upload sekarang!';
            };
            reader.readAsDataURL(file);
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>