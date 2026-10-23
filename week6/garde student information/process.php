<?php
require_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: index.html');
    exit;
}

$name = isset($_POST['student_name']) && is_string($_POST['student_name'])
    ? trim($_POST['student_name'])
    : '';
$studentId = isset($_POST['student_id']) && is_string($_POST['student_id'])
    ? trim($_POST['student_id'])
    : '';
$gender = isset($_POST['gender']) && is_string($_POST['gender'])
    ? $_POST['gender']
    : '';
$faculty = isset($_POST['faculty']) && is_string($_POST['faculty'])
    ? $_POST['faculty']
    : '';
$phpMark = isset($_POST['php_mark']) && is_string($_POST['php_mark'])
    ? trim($_POST['php_mark'])
    : '';
$databaseMark = isset($_POST['database_mark']) && is_string($_POST['database_mark'])
    ? trim($_POST['database_mark'])
    : '';
$networkingMark = isset($_POST['networking_mark']) && is_string($_POST['networking_mark'])
    ? trim($_POST['networking_mark'])
    : '';

$error = '';

if (empty($name) || empty($studentId)) {
    $error = 'Please enter the student name and student ID.';
} elseif ($gender != 'Male' && $gender != 'Female') {
    $error = 'Please select a gender.';
} elseif (
    $faculty != 'IT' &&
    $faculty != 'Business' &&
    $faculty != 'Accounting'
) {
    $error = 'Please select a faculty.';
} elseif (
    $phpMark === '' ||
    $databaseMark === '' ||
    $networkingMark === '' ||
    !is_numeric($phpMark) ||
    !is_numeric($databaseMark) ||
    !is_numeric($networkingMark)
) {
    $error = 'Please enter all three marks as numbers.';
} else {
    $phpMark = (float)$phpMark;
    $databaseMark = (float)$databaseMark;
    $networkingMark = (float)$networkingMark;

    if (
        $phpMark < 0 || $phpMark > 100 ||
        $databaseMark < 0 || $databaseMark > 100 ||
        $networkingMark < 0 || $networkingMark > 100
    ) {
        $error = 'Each mark must be between 0 and 100.';
    }
}

$originalName = '';
$fileType = '';
$fileSize = 0;
$uploadStatus = '';

if ($error == '') {
    if (!isset($_FILES['certificate'])) {
        $error = 'Please choose a certificate file.';
    } elseif ($_FILES['certificate']['error'] == UPLOAD_ERR_NO_FILE) {
        $error = 'Please choose a certificate file.';
    } elseif ($_FILES['certificate']['error'] != UPLOAD_ERR_OK) {
        $error = 'The certificate could not be uploaded. Please try again.';
    } elseif ($_FILES['certificate']['size'] > 2 * 1024 * 1024) {
        $error = 'The certificate must be 2 MB or smaller.';
    } else {
        $originalName = basename($_FILES['certificate']['name']);
        $temporaryFile = $_FILES['certificate']['tmp_name'];
        $uploadFolder = __DIR__ . '/uploads/';
        $fileExtension = pathinfo($originalName, PATHINFO_EXTENSION);
        $fileBaseName = pathinfo($originalName, PATHINFO_FILENAME);
        $safeBaseName = preg_replace('/[^A-Za-z0-9_-]/', '_', $fileBaseName);
        $safeBaseName = trim($safeBaseName, '_-');

        if ($safeBaseName === '' || $fileExtension === '') {
            $error = 'Please choose a certificate with a valid filename.';
        } elseif (!is_dir($uploadFolder) && !mkdir($uploadFolder, 0755, true)) {
            $error = 'The uploads folder could not be created.';
        } else {
            $savedName = $safeBaseName . '.' . $fileExtension;
            $destination = $uploadFolder . $savedName;
            $copyNumber = 1;

            while (file_exists($destination)) {
                $savedName = $safeBaseName . '_' . $copyNumber . '.' . $fileExtension;
                $destination = $uploadFolder . $savedName;
                $copyNumber++;
            }

            if (move_uploaded_file($temporaryFile, $destination)) {
                $fileType = (new finfo(FILEINFO_MIME_TYPE))->file($destination);
                $fileSize = filesize($destination);
                $uploadStatus = 'Uploaded successfully';
            } else {
                $error = 'The certificate could not be saved.';
            }
        }
    }
}

function escapeOutput($value)
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

if ($error != '') {
    http_response_code(400);
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Form Error</title>
        <style>
         
        </style>
    </head>
    <body>
        <main>
            <h2>There is a problem with your form</h2>
            <p class="error"><?= escapeOutput($error) ?></p>
            <p><a href="index.html">Go back to the form</a></p>
        </main>
    </body>
    </html>
    <?php
    exit;
}

$total = calculateTotal($phpMark, $databaseMark, $networkingMark);
$average = calculateAverage($total);
$grade = calculateGrade($average);
$result = checkResult($average);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Grade Results</title>
    <style>

        th,td{padding:11px 12px;border:1px solid #d3c5c5;text-align:left}
      
       
    </style>
</head>
<body>
    <main>
        <h1>Student Grade Results</h1>
        <table>
            <tr><th>Student Full Name</th><td><?= escapeOutput($name) ?></td></tr>
            <tr><th>Student ID</th><td><?= escapeOutput($studentId) ?></td></tr>
            <tr><th>Gender</th><td><?= escapeOutput($gender) ?></td></tr>
            <tr><th>Faculty</th><td><?= escapeOutput($faculty) ?></td></tr>
            <tr><th>PHP Mark</th><td><?= escapeOutput($phpMark) ?></td></tr>
            <tr><th>Database Mark</th><td><?= escapeOutput($databaseMark) ?></td></tr>
            <tr><th>Networking Mark</th><td><?= escapeOutput($networkingMark) ?></td></tr>
            <tr><th>Total Marks</th><td><?= escapeOutput($total) ?> / 300</td></tr>
            <tr><th>Average Marks</th><td><?= number_format($average, 2) ?></td></tr>
            <tr><th>Grade</th><td><?= escapeOutput($grade) ?></td></tr>
            <tr><th>Pass or Fail</th><td><?= escapeOutput($result) ?></td></tr>
            <tr><th>Certificate Name</th><td><?= escapeOutput($originalName) ?></td></tr>
            <tr><th>File Type</th><td><?= escapeOutput($fileType) ?></td></tr>
            <tr><th>File Size</th><td><?= number_format($fileSize / 1024, 2) ?> KB</td></tr>
            <tr><th>Upload Status</th><td><?= escapeOutput($uploadStatus) ?></td></tr>
        </table>
        <a class="back-link" href="index.html">Back to the form</a>
    </main>
</body>
</html>
