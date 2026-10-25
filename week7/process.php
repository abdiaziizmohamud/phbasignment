
<?php
require_once __DIR__ . '/function.php';

if (
    !isset($_POST['full_name']) ||
    !isset($_POST['account_number']) ||
    !isset($_POST['gender']) ||
    !isset($_POST['account_type']) ||
    !isset($_POST['transaction_type']) ||
    !isset($_POST['opening_balance']) ||
    !isset($_POST['transaction_amount']) ||
    !isset($_POST['duration'])
) {

}

function escapeOutput($value)
{
    return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function getPostValue($key)
{
    if (
        !isset($_POST[$key]) ||
        !is_string($_POST[$key])
    ) {
        return '';
    }

    return trim($_POST[$key]);
}

function getUploadedFileValue($file, $key)
{
    if (!isset($file[$key]) || !is_string($file[$key])) {
        return '';
    }

    return $file[$key];
}

$fullName = getPostValue('full_name');
$accountNumber = getPostValue('account_number');
$gender = getPostValue('gender');
$accountType = getPostValue('account_type');
$transactionType = getPostValue('transaction_type');
$openingBalanceInput = getPostValue('opening_balance');
$transactionAmountInput = getPostValue('transaction_amount');
$durationInput = getPostValue('duration');

$errors = [];

if ($fullName === '') {
    $errors[] = 'Customer full name is required.';
}

if ($accountNumber === '') {
    $errors[] = 'Account number is required.';
}

if (!in_array($gender, ['Male', 'Female'], true)) {
    $errors[] = 'Please select a valid gender.';
}

if (!in_array($accountType, ['Savings', 'Current', 'Business'], true)) {
    $errors[] = 'Please select a valid account type.';
}

if (!in_array($transactionType, ['Deposit', 'Withdrawal'], true)) {
    $errors[] = 'Please select a valid transaction type.';
}

if (
    $openingBalanceInput === '' ||
    !is_numeric($openingBalanceInput) ||
    (float)$openingBalanceInput < 0
) {
    $errors[] = 'Opening balance must be zero or greater.';
}

if (
    $transactionAmountInput === '' ||
    !is_numeric($transactionAmountInput) ||
    (float)$transactionAmountInput <= 0
) {
    $errors[] = 'Transaction amount must be greater than zero.';
}

if (
    $durationInput === '' ||
    filter_var($durationInput, FILTER_VALIDATE_INT) === false ||
    (int)$durationInput < 0
) {
    $errors[] = 'Account duration must be a whole number of zero or more.';
}

$openingBalance = (float)$openingBalanceInput;
$transactionAmount = (float)$transactionAmountInput;
$duration = (int)$durationInput;

$transactionFee = 0;

if (
    in_array($transactionType, ['Deposit', 'Withdrawal'], true) &&
    $transactionAmount > 0
) {
    $transactionFee = calculateTransactionFee(
        $transactionType,
        $transactionAmount
    );
}

if (
    $transactionType === 'Withdrawal' &&
    $transactionAmount > 0 &&
    ($transactionAmount + $transactionFee) > $openingBalance
) {
    $errors[] = 'The withdrawal and transaction fee cannot be more than the opening balance.';
}

// File upload variables
$uploadedFileName = '';
$savedFileName = '';
$uploadedFileType = '';
$uploadedFileSize = 0;

$uploadFolder = __DIR__ . DIRECTORY_SEPARATOR . 'uploads';

// Validate uploaded document
$document = isset($_FILES['id_document']) && is_array($_FILES['id_document'])
    ? $_FILES['id_document']
    : [];

$uploadError = isset($document['error']) && is_int($document['error'])
    ? $document['error']
    : UPLOAD_ERR_NO_FILE;
$uploadSize = isset($document['size']) && is_numeric($document['size'])
    ? (float)$document['size']
    : 0;
$temporaryFile = getUploadedFileValue($document, 'tmp_name');

if ($document === []) {
    $errors[] = 'Please select an identification document.';
} elseif ($uploadError === UPLOAD_ERR_NO_FILE) {
    $errors[] = 'Please select an identification document.';
} elseif ($uploadError !== UPLOAD_ERR_OK) {
    $errors[] = 'The document could not be uploaded. Please select it again.';
} elseif ($uploadSize > 2 * 1024 * 1024) {
    $errors[] = 'The identification document must not be larger than 2 MB.';
} elseif ($temporaryFile === '' || !is_uploaded_file($temporaryFile)) {
    $errors[] = 'The uploaded document could not be verified.';
}

// Save uploaded document
if (count($errors) === 0) {
    $clientFileName = getUploadedFileValue($document, 'name');
    $uploadedFileName = basename(str_replace('\\', '/', $clientFileName));

    $fileBaseName = pathinfo($uploadedFileName, PATHINFO_FILENAME);
    $fileExtension = pathinfo($uploadedFileName, PATHINFO_EXTENSION);

    $safeBaseName = preg_replace('/[^A-Za-z0-9_-]/', '_', $fileBaseName);
    $safeBaseName = trim($safeBaseName, '_-');
    $safeExtension = preg_replace('/[^A-Za-z0-9]/', '', $fileExtension);

    if ($safeBaseName === '') {
        $safeBaseName = 'document';
    }

    if (!is_dir($uploadFolder)) {
        if (!mkdir($uploadFolder, 0755, true)) {
            $errors[] = 'Could not create the uploads folder.';
        }
    }

    if (
        count($errors) === 0 &&
        !is_writable($uploadFolder)
    ) {
        $errors[] = 'The uploads folder is not writable.';
    }

    if (count($errors) === 0) {
        $savedFileName = $safeBaseName;

        if ($safeExtension !== '') {
            $savedFileName .= '.' . $safeExtension;
        }

        $destination = $uploadFolder . DIRECTORY_SEPARATOR . $savedFileName;
        $copyNumber = 1;

        while (file_exists($destination)) {
            $savedFileName = $safeBaseName . '_' . $copyNumber;

            if ($safeExtension !== '') {
                $savedFileName .= '.' . $safeExtension;
            }

            $destination = $uploadFolder . DIRECTORY_SEPARATOR . $savedFileName;
            $copyNumber++;
        }

        if (move_uploaded_file($temporaryFile, $destination)) {
            $detectedType = (new finfo(FILEINFO_MIME_TYPE))->file($destination);
            $savedSize = filesize($destination);
            $uploadedFileType = is_string($detectedType) ? $detectedType : 'Unknown';
            $uploadedFileSize = is_int($savedSize) ? $savedSize : 0;
        } else {
            $errors[] = 'The document could not be saved. Check the uploads folder permissions.';
        }
    }
}

// Display validation errors
if (count($errors) > 0) {
    http_response_code(400);
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Check Your Form</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <main class="result-card">
            <h1>Please check your form</h1>

            <ul class="error-list">
                <?php foreach ($errors as $error): ?>
                    <li><?= escapeOutput($error) ?></li>
                <?php endforeach; ?>
            </ul>

            <a class="button-link" href="bank.html">Back to the form</a>
        </main>
    </body>
    </html>
    <?php
    exit;
}

// Calculate transaction
if ($transactionType === 'Deposit') {
    $transactionBalance = calculateDeposit(
        $openingBalance,
        $transactionAmount
    );
} else {
    $transactionBalance = calculateWithdrawal(
        $openingBalance,
        $transactionAmount
    );
}

$totalCharges = calculateTotalCharges($transactionFee);

$finalBalance = calculateFinalBalance(
    $openingBalance,
    $transactionAmount,
    $transactionType,
    $totalCharges
);

$accountStatus = checkAccountStatus($finalBalance);
$interest = calculateInterest($accountType, $finalBalance, $duration);
$futureBalance = calculateFutureBalance($finalBalance, $accountType, $duration);

// Interest rate
if ($accountType === 'Savings') {
    $interestRate = '5%';
} elseif ($accountType === 'Current') {
    $interestRate = '2%';
} else {
    $interestRate = '3%';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Result</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main class="result-card">
        <h1>Transaction Result</h1>

        <p class="success-message">
            The transaction was processed successfully.
        </p>

        <table>
            <tr>
                <th>Customer Name</th>
                <td><?= escapeOutput($fullName) ?></td>
            </tr>
            <tr>
                <th>Account Number</th>
                <td><?= escapeOutput($accountNumber) ?></td>
            </tr>
            <tr>
                <th>Gender</th>
                <td><?= escapeOutput($gender) ?></td>
            </tr>
            <tr>
                <th>Account Type</th>
                <td><?= escapeOutput($accountType) ?></td>
            </tr>
            <tr>
                <th>Opening Balance</th>
                <td>$<?= number_format($openingBalance, 2) ?></td>
            </tr>
            <tr>
                <th>Transaction</th>
                <td><?= escapeOutput($transactionType) ?></td>
            </tr>
            <tr>
                <th>Transaction Amount</th>
                <td>$<?= number_format($transactionAmount, 2) ?></td>
            </tr>
            <tr>
                <th>Transaction Fee</th>
                <td>$<?= number_format($transactionFee, 2) ?></td>
            </tr>
            <tr>
                <th>Balance After Transaction</th>
                <td>$<?= number_format($transactionBalance, 2) ?></td>
            </tr>
            <tr>
                <th>Final Balance After Fees</th>
                <td>$<?= number_format($finalBalance, 2) ?></td>
            </tr>
            <tr>
                <th>Account Status</th>
                <td><?= escapeOutput($accountStatus) ?></td>
            </tr>
            <tr>
                <th>Account Duration</th>
                <td><?= escapeOutput($duration) ?> year(s)</td>
            </tr>
            <tr>
                <th>Interest Rate</th>
                <td><?= escapeOutput($interestRate) ?></td>
            </tr>
            <tr>
                <th>Interest</th>
                <td>$<?= number_format($interest, 2) ?></td>
            </tr>
            <tr>
                <th>Future Balance</th>
                <td>$<?= number_format($futureBalance, 2) ?></td>
            </tr>
            <tr>
                <th>Document Name</th>
                <td><?= escapeOutput($uploadedFileName) ?></td>
            </tr>
            <tr>
                <th>Saved File Name</th>
                <td><?= escapeOutput($savedFileName) ?></td>
            </tr>
            <tr>
                <th>Document Type</th>
                <td><?= escapeOutput($uploadedFileType) ?></td>
            </tr>
            <tr>
                <th>Document Size</th>
                <td><?= number_format($uploadedFileSize / 1024, 2) ?> KB</td>
            </tr>
            <tr>
                <th>Upload Status</th>
                <td>Uploaded successfully</td>
            </tr>
        </table>

        <a class="button-link" href="bank.html">
            Process another transaction
        </a>
    </main>
</body>
</html>
