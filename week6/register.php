<?php
declare(strict_types=1);
session_start();

// Keep uploaded photos in a folder beside this file.
$uploadDir = __DIR__ . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR;
$maxImageBytes = 2 * 1024 * 1024; // 2 MB
$allowedImageTypes = [
    'image/jpeg' => 'jpg',
    'image/png'  => 'png',
    'image/gif'  => 'gif',
    'image/webp' => 'webp',
];

$fields = [
    'name' => 'Student Name',
    'pob' => 'Place of Birth',
    'dob' => 'Date of Birth',
    'address' => 'Address',
    'gender' => 'Gender',
    'telephone' => 'Student Telephone',
    'email' => 'Email',
    'parent_name' => 'Parent Name',
    'parent_telephone' => 'Parent Telephone',
    'relationship' => 'Relationship',
    'student_id' => 'Student ID',
    'faculty' => 'Faculty',
    'department' => 'Department',
    'class' => 'Class',
    'registration_date' => 'Registration Date',
];

$old = array_fill_keys(array_keys($fields), '');
$errors = [];
$notice = '';

if (isset($_GET['message']) && $_GET['message'] === 'missing') {
    $notice = 'Foomka marka hore buuxi oo dir si bogga natiijadu u furmo.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($fields as $key => $label) {
        $value = $_POST[$key] ?? '';
        $old[$key] = is_string($value) ? trim($value) : '';
        if ($old[$key] === '') {
            $errors[$key] = "$label waa waajib.";
        }
    }

    if ($old['name'] !== '' && !preg_match('/^[\p{L}\s]+$/u', $old['name'])) {
        $errors['name'] = 'Magaca ku qor xarfo iyo firaaqooyin oo keliya.';
    }
    if ($old['email'] !== '' && !filter_var($old['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Geli email sax ah.';
    }
    if ($old['dob'] !== '' && strtotime($old['dob']) === false) {
        $errors['dob'] = 'Geli taariikh dhalasho sax ah.';
    }
    if ($old['registration_date'] !== '' && strtotime($old['registration_date']) === false) {
        $errors['registration_date'] = 'Geli taariikh diiwaangelin sax ah.';
    }

    $image = $_FILES['image'] ?? null;
    if (!is_array($image) || !isset($image['error']) || $image['error'] === UPLOAD_ERR_NO_FILE) {
        $errors['image'] = 'Fadlan geli sawirka ardayga.';
    } elseif ($image['error'] !== UPLOAD_ERR_OK) {
        $errors['image'] = $image['error'] === UPLOAD_ERR_INI_SIZE || $image['error'] === UPLOAD_ERR_FORM_SIZE
            ? 'Sawirku wuu ka weyn yahay xadka server-ka.'
            : 'Sawirka lama soo gelin karin. Mar kale isku day.';
    } elseif (($image['size'] ?? 0) > $maxImageBytes) {
        $errors['image'] = 'Sawirku waa inuu ahaadaa 2 MB ama ka yar.';
    } elseif (!is_uploaded_file($image['tmp_name'] ?? '')) {
        $errors['image'] = 'Faylka la soo geliyey lama aqoonsan.';
    } else {
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($image['tmp_name']);
        if (!isset($allowedImageTypes[$mime])) {
            $errors['image'] = 'Nooca sawirka la oggol yahay: JPG, PNG, GIF ama WEBP.';
        }
    }

    if (!$errors) {
        if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true) && !is_dir($uploadDir)) {
            $errors['image'] = 'Folder-ka uploads lama samayn karin. Hubi oggolaanshaha folder-ka.';
        } else {
            $extension = $allowedImageTypes[$mime];
            $imageName = bin2hex(random_bytes(16)) . '.' . $extension;
            if (!move_uploaded_file($image['tmp_name'], $uploadDir . $imageName)) {
                $errors['image'] = 'Sawirka lama kaydin karin. Hubi folder-ka uploads.';
            } else {
                $old['image'] = $imageName;
                $_SESSION['student_registration'] = $old;
                session_regenerate_id(true);
                header('Location: result.php');
                exit;
            }
        }
    }
}

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function fieldValue(string $key, array $old): string
{
    return e($old[$key] ?? '');
}

function fieldError(string $key, array $errors): string
{
    if (!isset($errors[$key])) {
        return '';
    }
    return '<div class="text-danger small mt-1">' . e($errors[$key]) . '</div>';
}
?>
<!doctype html>
<html lang="so">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Diiwaangelinta Ardayga | JUST</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body{background:#f3f6fb}.main-card{max-width:950px;margin:35px auto}.section-title{background:#123b66;color:#fff;padding:12px 16px;border-radius:7px;margin:24px 0 16px}.required{color:#dc3545}
    </style>
</head>
<body>
<main class="container main-card">
    <div class="card shadow border-0"><div class="card-body p-4 p-md-5">
        <h1 class="h2 text-center fw-bold">Jamhuriya University</h1>
        <p class="text-center text-secondary">Faculty of Computer &amp; IT — Diiwaangelinta Ardayga</p>
        <?php if ($notice !== ''): ?><div class="alert alert-info"><?= e($notice) ?></div><?php endif; ?>
        <?php if ($errors): ?><div class="alert alert-danger">Fadlan sax meelaha casaanka ah ee foomka.</div><?php endif; ?>

        <form action="register.php" method="post" enctype="multipart/form-data" novalidate>
            <input type="hidden" name="MAX_FILE_SIZE" value="2097152">
            <h2 class="h5 section-title">1. Xogta Ardayga</h2>
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label" for="name">Magaca Ardayga <span class="required">*</span></label><input class="form-control" id="name" name="name" value="<?= fieldValue('name', $old) ?>" required><?= fieldError('name', $errors) ?></div>
                <div class="col-md-6"><label class="form-label" for="pob">Goobta Dhalashada (POB) *</label><input class="form-control" id="pob" name="pob" value="<?= fieldValue('pob', $old) ?>" required><?= fieldError('pob', $errors) ?></div>
                <div class="col-md-6"><label class="form-label" for="dob">Taariikhda Dhalashada (DOB) *</label><input type="date" class="form-control" id="dob" name="dob" value="<?= fieldValue('dob', $old) ?>" required><?= fieldError('dob', $errors) ?></div>
                <div class="col-md-6"><label class="form-label" for="address">Cinwaanka *</label><input class="form-control" id="address" name="address" value="<?= fieldValue('address', $old) ?>" required><?= fieldError('address', $errors) ?></div>
                <div class="col-md-6"><label class="form-label" for="gender">Jinsiga *</label><select class="form-select" id="gender" name="gender" required><option value="">Dooro...</option><option value="Male" <?= ($old['gender'] ?? '') === 'Male' ? 'selected' : '' ?>>Lab</option><option value="Female" <?= ($old['gender'] ?? '') === 'Female' ? 'selected' : '' ?>>Dhedig</option><option value="Other" <?= ($old['gender'] ?? '') === 'Other' ? 'selected' : '' ?>>Kale</option></select><?= fieldError('gender', $errors) ?></div>
                <div class="col-md-6"><label class="form-label" for="telephone">Telefoonka Ardayga *</label><input type="tel" class="form-control" id="telephone" name="telephone" value="<?= fieldValue('telephone', $old) ?>" required><?= fieldError('telephone', $errors) ?></div>
                <div class="col-md-6"><label class="form-label" for="email">Email *</label><input type="email" class="form-control" id="email" name="email" value="<?= fieldValue('email', $old) ?>" required><?= fieldError('email', $errors) ?></div>
                <div class="col-md-6"><label class="form-label" for="image">Sawirka Ardayga (JPG, PNG, GIF, WEBP; ugu badnaan 2 MB) *</label><input type="file" class="form-control" id="image" name="image" accept="image/jpeg,image/png,image/gif,image/webp" required><?= fieldError('image', $errors) ?></div>
            </div>

            <h2 class="h5 section-title">2. Xogta Waalidka</h2>
            <div class="row g-3">
                <div class="col-md-4"><label class="form-label" for="parent_name">Magaca Waalidka *</label><input class="form-control" id="parent_name" name="parent_name" value="<?= fieldValue('parent_name', $old) ?>" required><?= fieldError('parent_name', $errors) ?></div>
                <div class="col-md-4"><label class="form-label" for="parent_telephone">Telefoonka Waalidka *</label><input type="tel" class="form-control" id="parent_telephone" name="parent_telephone" value="<?= fieldValue('parent_telephone', $old) ?>" required><?= fieldError('parent_telephone', $errors) ?></div>
                <div class="col-md-4"><label class="form-label" for="relationship">Xiriirka Waalidka *</label><input class="form-control" id="relationship" name="relationship" value="<?= fieldValue('relationship', $old) ?>" required><?= fieldError('relationship', $errors) ?></div>
            </div>

            <h2 class="h5 section-title">3. Xogta Waxbarashada</h2>
            <div class="row g-3">
                <div class="col-md-4"><label class="form-label" for="student_id">Aqoonsiga Ardayga (ID) *</label><input class="form-control" id="student_id" name="student_id" value="<?= fieldValue('student_id', $old) ?>" required><?= fieldError('student_id', $errors) ?></div>
                <div class="col-md-4"><label class="form-label" for="faculty">Kulliyadda (Faculty) *</label><input class="form-control" id="faculty" name="faculty" value="<?= fieldValue('faculty', $old) ?>" required><?= fieldError('faculty', $errors) ?></div>
                <div class="col-md-4"><label class="form-label" for="department">Waaxda (Department) *</label><input class="form-control" id="department" name="department" value="<?= fieldValue('department', $old) ?>" required><?= fieldError('department', $errors) ?></div>
                <div class="col-md-6"><label class="form-label" for="class">Fasalka (Class) *</label><input class="form-control" id="class" name="class" value="<?= fieldValue('class', $old) ?>" required><?= fieldError('class', $errors) ?></div>
                <div class="col-md-6"><label class="form-label" for="registration_date">Taariikhda Diiwaangelinta *</label><input type="date" class="form-control" id="registration_date" name="registration_date" value="<?= fieldValue('registration_date', $old) ?>" required><?= fieldError('registration_date', $errors) ?></div>
            </div>
            <div class="d-grid mt-4"><button class="btn btn-primary btn-lg" type="submit">Register / Diiwaangeli</button></div>
        </form>
    </div></div>
</main>
</body>
</html>
