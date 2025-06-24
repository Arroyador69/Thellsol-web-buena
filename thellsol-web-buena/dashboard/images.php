<?php
require_once 'auth.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Imágenes - Dashboard ThellSol</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="icon" href="../logo-thellsol copia.png" type="image/png">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Cormorant Garamond', serif;
            background: #f5f7fa;
            color: #333;
        }
        
        .header {
            background: #181e29;
            color: #fff;
            padding: 20px 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }
        
        .logo {
            font-size: 24px;
            font-weight: 700;
        }
        
        .nav-links {
            display: flex;
            gap: 20px;
        }
        
        .nav-links a {
            color: #fff;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 6px;
            transition: background 0.3s;
        }
        
        .nav-links a:hover,
        .nav-links a.active {
            background: #232a3a;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .upload-section {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        
        .upload-area {
            border: 2px dashed #ddd;
            border-radius: 12px;
            padding: 40px;
            text-align: center;
            transition: border-color 0.3s;
            cursor: pointer;
        }
        
        .upload-area:hover {
            border-color: #181e29;
        }
        
        .upload-area.dragover {
            border-color: #181e29;
            background: #f8f9fa;
        }
        
        .upload-icon {
            font-size: 48px;
            color: #666;
            margin-bottom: 16px;
        }
        
        .upload-text {
            font-size: 18px;
            color: #666;
            margin-bottom: 8px;
        }
        
        .upload-hint {
            font-size: 14px;
            color: #999;
        }
        
        .file-input {
            display: none;
        }
        
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-primary {
            background: #181e29;
            color: #fff;
        }
        
        .btn-primary:hover {
            background: #232a3a;
        }
        
        .images-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }
        
        .image-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: transform 0.3s;
        }
        
        .image-card:hover {
            transform: translateY(-2px);
        }
        
        .image-preview {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        
        .image-info {
            padding: 16px;
        }
        
        .image-name {
            font-weight: 600;
            margin-bottom: 8px;
            word-break: break-all;
        }
        
        .image-size {
            font-size: 14px;
            color: #666;
            margin-bottom: 12px;
        }
        
        .image-actions {
            display: flex;
            gap: 8px;
        }
        
        .btn-small {
            padding: 6px 12px;
            font-size: 12px;
        }
        
        .btn-danger {
            background: #dc3545;
            color: #fff;
        }
        
        .btn-danger:hover {
            background: #c82333;
        }
        
        .progress-bar {
            width: 100%;
            height: 4px;
            background: #e1e5e9;
            border-radius: 2px;
            margin-top: 16px;
            overflow: hidden;
        }
        
        .progress-fill {
            height: 100%;
            background: #28a745;
            width: 0%;
            transition: width 0.3s;
        }
        
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 15px;
            }
            
            .nav-links {
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .images-grid {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <div class="logo">ThellSol Dashboard</div>
            <div class="nav-links">
                <a href="index.php">Propiedades</a>
                <a href="images.php" class="active">Imágenes</a>
                <a href="logout.php">Cerrar Sesión</a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="upload-section">
            <h2 style="margin-bottom: 20px;">Subir Imágenes</h2>
            
            <div class="upload-area" id="uploadArea">
                <div class="upload-icon">
                    <i class="fas fa-cloud-upload-alt"></i>
                </div>
                <div class="upload-text">Arrastra y suelta imágenes aquí</div>
                <div class="upload-hint">o haz clic para seleccionar archivos</div>
                <input type="file" id="fileInput" class="file-input" multiple accept="image/*">
            </div>
            
            <div class="progress-bar" id="progressBar" style="display: none;">
                <div class="progress-fill" id="progressFill"></div>
            </div>
            
            <div style="margin-top: 20px;">
                <button class="btn btn-primary" onclick="document.getElementById('fileInput').click()">
                    <i class="fas fa-folder-open"></i> Seleccionar Archivos
                </button>
            </div>
        </div>

        <div class="images-grid" id="imagesGrid">
            <!-- Las imágenes se cargarán aquí -->
        </div>
    </div>

    <script>
        const uploadArea = document.getElementById('uploadArea');
        const fileInput = document.getElementById('fileInput');
        const progressBar = document.getElementById('progressBar');
        const progressFill = document.getElementById('progressFill');
        const imagesGrid = document.getElementById('imagesGrid');

        // Cargar imágenes existentes
        loadImages();

        // Eventos de drag and drop
        uploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadArea.classList.add('dragover');
        });

        uploadArea.addEventListener('dragleave', () => {
            uploadArea.classList.remove('dragover');
        });

        uploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadArea.classList.remove('dragover');
            const files = e.dataTransfer.files;
            handleFiles(files);
        });

        uploadArea.addEventListener('click', () => {
            fileInput.click();
        });

        fileInput.addEventListener('change', (e) => {
            handleFiles(e.target.files);
        });

        function handleFiles(files) {
            Array.from(files).forEach(file => {
                if (file.type.startsWith('image/')) {
                    uploadFile(file);
                }
            });
        }

        function uploadFile(file) {
            const formData = new FormData();
            formData.append('image', file);

            progressBar.style.display = 'block';
            progressFill.style.width = '0%';

            fetch('../api/upload-image.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    progressFill.style.width = '100%';
                    setTimeout(() => {
                        progressBar.style.display = 'none';
                        loadImages();
                    }, 1000);
                } else {
                    alert('Error al subir la imagen: ' + data.error);
                    progressBar.style.display = 'none';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al subir la imagen');
                progressBar.style.display = 'none';
            });
        }

        function loadImages() {
            fetch('../api/images.php')
                .then(response => response.json())
                .then(images => {
                    imagesGrid.innerHTML = '';
                    
                    images.forEach(image => {
                        const card = document.createElement('div');
                        card.className = 'image-card';
                        card.innerHTML = `
                            <img src="../${image.path}" alt="${image.name}" class="image-preview">
                            <div class="image-info">
                                <div class="image-name">${image.name}</div>
                                <div class="image-size">${formatFileSize(image.size)}</div>
                                <div class="image-actions">
                                    <button class="btn btn-small btn-primary" onclick="copyImageUrl('${image.path}')">
                                        <i class="fas fa-copy"></i> Copiar URL
                                    </button>
                                    <button class="btn btn-small btn-danger" onclick="deleteImage('${image.id}')">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                </div>
                            </div>
                        `;
                        imagesGrid.appendChild(card);
                    });
                })
                .catch(error => {
                    console.error('Error cargando imágenes:', error);
                });
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        function copyImageUrl(url) {
            navigator.clipboard.writeText(url).then(() => {
                alert('URL copiada al portapapeles');
            });
        }

        function deleteImage(id) {
            if (confirm('¿Estás seguro de que quieres eliminar esta imagen?')) {
                fetch(`../api/images.php?id=${id}`, {
                    method: 'DELETE'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        loadImages();
                        alert('Imagen eliminada correctamente');
                    } else {
                        alert('Error al eliminar la imagen');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al eliminar la imagen');
                });
            }
        }
    </script>
</body>
</html> 