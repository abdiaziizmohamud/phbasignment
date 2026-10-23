<?php
declare(strict_types=1);

$message = '';
$uploadedInfo = null;
$maxSize = 5 * 1024 * 1024; // 5 MB
$uploadFolder = __DIR__ . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR;
$allowedMimeTypes = [
    'image/png'  => 'png',
    'image/jpeg' => 'jpg',
];

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $file = $_FILES['image'] ?? null;

    if (!is_array($file) || !isset($file['error']) || $file['error'] === UPLOAD_ERR_NO_FILE) {
        $message = 'Fadlan dooro sawir aad soo geliso.';
    } elseif ($file['error'] !== UPLOAD_ERR_OK) {
        $message = 'Faylka lama soo gelin karin. Hubi xadka upload-ka PHP.';
    } elseif (($file['size'] ?? 0) > $maxSize) {
        $message = 'Faylku aad buu u weyn yahay. Xadka ugu badan waa 5 MB.';
    } elseif (!is_uploaded_file($file['tmp_name'] ?? '')) {
        $message = 'Faylka la soo geliyey lama aqoonsan.';
    } else {
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($file['tmp_name']);

        if (!isset($allowedMimeTypes[$mimeType])) {
            $message = 'Nooca faylka lama oggola. Isticmaal PNG, JPG ama JPEG.';
        } else {
            $extension = $allowedMimeTypes[$mimeType];
            $originalName = basename((string)$file['name']);
            $requestedName = trim((string)($_POST['fullname'] ?? ''));
            $baseName = $requestedName !== ''
                ? pathinfo($requestedName, PATHINFO_FILENAME)
                : pathinfo($originalName, PATHINFO_FILENAME);
            $safeBaseName = preg_replace('/[^A-Za-z0-9_-]/', '_', $baseName) ?? '';
            $safeBaseName = trim($safeBaseName, '_-');

            if ($safeBaseName === '') {
                $message = 'Geli magac fayl oo sax ah.';
            } elseif (!is_dir($uploadFolder) && !mkdir($uploadFolder, 0755, true) && !is_dir($uploadFolder)) {
                $message = 'Folder-ka uploads lama samayn karin. Hubi oggolaanshaha folder-ka.';
            } else {
                $finalName = $safeBaseName . '.' . $extension;
                $destination = $uploadFolder . $finalName;

                if (file_exists($destination)) {
                    $message = 'Fayl magacan wata ayaa hore ugu jira folder-ka uploads. Dooro magac kale.';
                } elseif (move_uploaded_file($file['tmp_name'], $destination)) {
                    $message = 'Sawirka si guul leh ayaa loo soo geliyey.';
                    $uploadedInfo = [
                        'original_name' => $originalName,
                        'saved_name' => $finalName,
                        'size' => (int)$file['size'],
                        'type' => $mimeType,
                        'temp' => (string)$file['tmp_name'],
                        'destination' => $destination,
                    ];
                } else {
                    $message = 'Upload-ku wuu fashilmay. Hubi in folder-ka uploads la qori karo.';
                }
            }
        }
    }
}
?>
<!doctype html>
<html lang="so">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Image Upload</title>
    <style>
        body{font-family:Arial,sans-serif;background:#f3f6fb;margin:0;padding:32px}
        main{max-width:650px;margin:auto;background:#fff;padding:24px;border-radius:10px;box-shadow:0 4px 18px #0001}
        label{display:block;margin:16px 0 6px}input{padding:9px;max-width:100%}
        button{margin-top:18px;padding:10px 18px;background:#123b66;color:#fff;border:0;border-radius:5px;cursor:pointer}
        .message{padding:12px;background:#eef5ff;border-radius:5px;margin:18px 0}
        .details{overflow-wrap:anywhere}hr{border:0;border-top:1px solid #ddd}
    </style>
</head>
<body>
<main>
    <h1>Image Upload</h1>
    <form action="files.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="MAX_FILE_SIZE" value="5242880">
        <label for="image">Dooro sawir (PNG, JPG ama JPEG):</label>
        <input type="file" name="image" id="image" accept="image/png,image/jpeg" required>

        <label for="fullname">Magaca faylka cusub (ikhtiyaari):</label>
        <input type="text" name="fullname" id="fullname" placeholder="Tusaale: sawirka_ardayga">

        <br>
        <button type="submit" name="submit" value="1">Upload</button>
    </form>

    <?php if ($message !== ''): ?>
        <div class="message"><?= e($message) ?></div>
    <?php endif; ?>

    <?php if ($uploadedInfo !== null): ?>
        <section class="details">
            <h2>Faahfaahinta faylka</h2>
            <p>Magacii asalka ahaa: <?= e($uploadedInfo['original_name']) ?></p>
            <p>Cabbirka: <?= e((string)round($uploadedInfo['size'] / 1024, 2)) ?> KB</p>
            <p>Nooca la xaqiijiyey: <?= e($uploadedInfo['type']) ?></p>
            <p>Meesha ku-meelgaarka ahayd: <?= e($uploadedInfo['temp']) ?></p>
            <p>Xadka cabbirka: <?= $uploadedInfo['size'] <= $maxSize ? 'Waa hagaag (ugu badnaan 5 MB)' : 'Wuu ka weyn yahay xadka' ?></p>
            <p>Magaca kaydsan: <?= e($uploadedInfo['saved_name']) ?></p>
            <p>Goobta kaydinta: <?= e($uploadedInfo['destination']) ?></p>
        </section>
    <?php endif; ?>
</main>
</body>
</html>
