<?php
function calculateDeposit($openingBalance, $transactionAmount)
{
    return $openingBalance + $transactionAmount;
}

function calculateWithdrawal($openingBalance, $transactionAmount)
{
    return $openingBalance - $transactionAmount;
}

function calculateTransactionFee($transactionType, $transactionAmount)
{
    if ($transactionType == "Deposit") {
        return 0;
    } elseif ($transactionType == "Withdrawal" && $transactionAmount < 500) {
        return 2;
    } elseif ($transactionType == "Withdrawal" && $transactionAmount >= 500) {
        return 5;
    } else {
        return 0;
    }
}

function calculateInterest($accountType, $finalBalance, $duration)
{
    if ($accountType == "Savings") {
        $rate = 0.05;
    } elseif ($accountType == "Current") {
        $rate = 0.02;
    } elseif ($accountType == "Business") {
        $rate = 0.03;
    } else {
        $rate = 0;
    }

    return $finalBalance * $rate * $duration;
}

function calculateTotalCharges($transactionFee)
{
    return $transactionFee;
}

function calculateFinalBalance($openingBalance, $transactionAmount, $transactionType, $totalCharges)
{
    if ($transactionType == "Deposit") {
        return $openingBalance + $transactionAmount - $totalCharges;
    } else {
        return $openingBalance - $transactionAmount - $totalCharges;
    }
}

function checkAccountStatus($finalBalance)
{
    if ($finalBalance >= 5000) {
        return "High Balance";
    } elseif ($finalBalance >= 1000) {
        return "Medium Balance";
    } else {
        return "Low Balance";
    }
}

function calculateFutureBalance($finalBalance, $accountType, $duration = 1)
{
    $interest = calculateInterest($accountType, $finalBalance, $duration);
    return $finalBalance + $interest;
}
?>
