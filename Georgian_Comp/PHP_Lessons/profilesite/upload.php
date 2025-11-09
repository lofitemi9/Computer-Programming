<?php
require_once __DIR__ . '/./config.php';
require_once __DIR__ . '/./classes/ProfileRepository.php';

// Basic presence validation
$name  = trim($_POST['name']  ?? '');
$email = trim($_POST['email'] ?? '');
$bio   = trim($_POST['bio']   ?? '');
$file  = $_FILES['image']     ?? null;

if ($name === '' || $email === '' || !$file) {
    http_response_code(400);
    exit('Missing required fields.');
}

// Ensure uploads dir exists
if (!is_dir(UPLOAD_DIR)) {
    if (!mkdir(UPLOAD_DIR, 0755, true)) {
        http_response_code(500);
        exit('Server error: cannot create uploads folder.');
    }
}

// Check PHP upload error
if (!isset($file['error']) || is_array($file['error'])) {
    http_response_code(400);
    exit('Invalid file upload.');
}

if ($file['error'] !== UPLOAD_ERR_OK) {
    $map = [
        UPLOAD_ERR_INI_SIZE   => 'File too large (php.ini).',
        UPLOAD_ERR_FORM_SIZE  => 'File too large (form).',
        UPLOAD_ERR_PARTIAL    => 'Partial upload.',
        UPLOAD_ERR_NO_FILE    => 'No file uploaded.',
        UPLOAD_ERR_NO_TMP_DIR => 'No temporary folder.',
        UPLOAD_ERR_CANT_WRITE => 'Failed to write file.',
        UPLOAD_ERR_EXTENSION  => 'A PHP extension stopped the upload.',
    ];
    $msg = $map[$file['error']] ?? 'Unknown upload error.';
    http_response_code(400);
    exit('Upload error: ' . $msg);
}

// Enforce size limit
if ($file['size'] > MAX_UPLOAD_BYTES) {
    http_response_code(400);
    exit('File too large (limit 2MB).');
}

// Validate extension
$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
$allowed = ['jpg', 'jpeg', 'png', 'gif'];
if (!in_array($ext, $allowed, true)) {
    http_response_code(400);
    exit('Invalid file type. Allowed: jpg, jpeg, png, gif.');
}

// Move file
$filename   = uniqid('img_', true) . '.' . $ext;
$targetPath = rtrim(UPLOAD_DIR, '/\\') . DIRECTORY_SEPARATOR . $filename;

if (!is_uploaded_file($file['tmp_name'])) {
    http_response_code(400);
    exit('Invalid file upload (tmp missing).');
}
if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
    http_response_code(500);
    exit('Failed to save image on server.');
}

// Store relative path to serve in <img src="">
$imageRelativePath = 'uploads/' . $filename;

$repo = new ProfileRepository();
$repo->create($name, $email, $bio, $imageRelativePath);

// Redirect to list
header('Location: profiles.php');
exit;
