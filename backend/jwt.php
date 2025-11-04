<?php
// jwt.php
require_once 'config.php';

function base64url_encode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}
function base64url_decode($data) {
    $remainder = strlen($data) % 4;
    if ($remainder) $data .= str_repeat('=', 4 - $remainder);
    return base64_decode(strtr($data, '-_', '+/'));
}

function jwt_create($payload) {
    $header = ['alg' => 'HS256', 'typ' => 'JWT'];
    $payload['iat'] = time();
    $payload['exp'] = time() + JWT_EXPIRY;
    $header_b = base64url_encode(json_encode($header));
    $payload_b = base64url_encode(json_encode($payload));
    $signature = hash_hmac('sha256', "$header_b.$payload_b", JWT_SECRET, true);
    $signature_b = base64url_encode($signature);
    return "$header_b.$payload_b.$signature_b";
}

function jwt_verify($token) {
    $parts = explode('.', $token);
    if (count($parts) !== 3) return false;
    list($header_b, $payload_b, $signature_b) = $parts;
    $signature_check = base64url_encode(hash_hmac('sha256', "$header_b.$payload_b", JWT_SECRET, true));
    if (!hash_equals($signature_check, $signature_b)) return false;
    $payload_json = base64url_decode($payload_b);
    $payload = json_decode($payload_json, true);
    if (!$payload) return false;
    if (isset($payload['exp']) && time() > $payload['exp']) return false;
    return $payload;
}
