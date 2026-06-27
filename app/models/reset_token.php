<?php
require_once __DIR__ . "/../../env.php";

function generateResetToken(string $email): string
{
    global $app_secret;

    $expiration = time() + 1800; // valable 30 minutes
    $payload = $email . '|' . $expiration;
    $payloadEncoded = base64_encode($payload);
    $signature = hash_hmac('sha256', $payload, $app_secret);

    return $payloadEncoded . '.' . $signature;
}

function verifyResetToken(string $token): string|false
{
    global $app_secret;

    $parts = explode('.', $token);
    if (count($parts) !== 2) {
        return false;
    }

    [$payloadEncoded, $signature] = $parts;
    $payload = base64_decode($payloadEncoded);

    $expectedSignature = hash_hmac('sha256', $payload, $app_secret);
    if (!hash_equals($expectedSignature, $signature)) {
        return false;
    }

    [$email, $expiration] = explode('|', $payload);
    if ((int)$expiration < time()) {
        return false;
    }

    return $email;
}
