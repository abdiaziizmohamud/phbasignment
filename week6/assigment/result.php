<?php
declare(strict_types=1);
session_start();

$student = $_SESSION['student_registration'] ?? null;
if (!is_array($student)) {
    header('Location: register.php?message=missing');
    exit;
}

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$sections = [
    'Xogta Ardayga' => [
        'name' => 'Magaca Ardayga', 'pob' => 'Goobta Dhalashada (POB)',
        'dob' => 'Taariikhda Dhalashada (DOB)', 'address' => 'Cinwaanka',
        'gender' => 'Jinsiga', 'telephone' => 'Telefoonka Ardayga', 'email' => 'Email',
    ],
    'Xogta Waalidka' => [
        'parent_name' => 'Magaca Waalidka', 'parent_telephone' => 'Telefoonka Waalidka',
        'relationship' => 'Xiriirka Waalidka',
    ],
    'Xogta Waxbarashada' => [
        'student_id' => 'Aqoonsiga Ardayga (ID)', 'faculty' => 'Kulliyadda (Faculty)',
        'department' => 'Waaxda (Department)', 'class' => 'Fasalka (Class)',
        'registration_date' => 'Taariikhda Diiwaangelinta',
    ],
];
$imageName = basename((string)($student['image'] ?? ''));
$imagePath = __DIR__ . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $imageName;
$imageUrl = 'uploads/' . rawurlencode($imageName);
?>
<!doctype html>
<html lang="so">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Natiijada Diiwaangelinta | JUST</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<main class="container py-5" style="max-width:1000px">
    <div class="card shadow border-0"><div class="card-body p-4 p-md-5">
        <h1 class="h2 text-center text-success">Diiwaangelintu way guulaysatay</h1>
        <p class="text-center text-secondary">Xogta ardayga ee aad dirtay</p>
        <?php if ($imageName !== '' && is_file($imagePath)): ?>
            <div class="text-center mb-4"><img src="<?= e($imageUrl) ?>" alt="Sawirka ardayga" class="rounded border" style="max-width:180px;max-height:200px;object-fit:cover"></div>
        <?php endif; ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark"><tr><th>Qaybta</th><th>Macluumaadka</th><th>Jawaabta</th></tr></thead>
                <tbody>
                <?php foreach ($sections as $section => $items): ?>
                    <?php foreach ($items as $key => $label): ?>
                        <tr><th scope="row"><?= e($section) ?></th><td><?= e($label) ?></td><td><?= e((string)($student[$key] ?? '')) ?></td></tr>
                    <?php endforeach; ?>
                <?php endforeach; ?>
                <?php if ($imageName !== ''): ?>
                    <tr><th scope="row">Xogta Ardayga</th><td>Magaca faylka sawirka</td><td><?= e($imageName) ?></td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="d-flex flex-wrap gap-2 justify-content-center mt-4">
            <a class="btn btn-primary" href="register.php">Diiwaangeli arday kale</a>
            <button class="btn btn-outline-secondary" type="button" onclick="window.print()">Daabac</button>
        </div>
    </div></div>
</main>
</body>
</html>
