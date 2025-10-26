<?php
// core/ImageUploader.php



class ImageUploader {
    private $uploadPath;
    private $allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
    private $maxSize = 5 * 1024 * 1024; // 5 MB

    public function __construct(string $uploadDirectory) {
        $this->uploadPath = $uploadDirectory;
    }

    /**
     * Processa o upload de um único arquivo.
     * @param array $file O array do arquivo vindo de $_FILES.
     * @return string|false O novo nome do arquivo em caso de sucesso, ou false em caso de falha.
     */
    public function upload(array $file) {
        // 1. Validação básica
        if ($file['error'] !== UPLOAD_ERR_OK) {
            error_log("Upload error: " . $file['error']);
            return false;
        }

        // 2. Validação de tamanho
        if ($file['size'] > $this->maxSize) {
            error_log("File too large: " . $file['name']);
            return false;
        }

        // 3. Validação de tipo (MIME type)
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($file['tmp_name']);
        if (!in_array($mimeType, $this->allowedTypes)) {
            error_log("Invalid file type: " . $mimeType);
            return false;
        }

        // 4. Gerar um nome de arquivo seguro e único
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $safeFilename = uniqid('', true) . '.' . strtolower($extension);
        
        $destination = $this->uploadPath . '/' . $safeFilename;

        // 5. Mover o arquivo do diretório temporário para o destino final
        if (move_uploaded_file($file['tmp_name'], $destination)) {
            return $safeFilename;
        }

        error_log("Failed to move uploaded file: " . $file['name']);
        return false;
    }
}
