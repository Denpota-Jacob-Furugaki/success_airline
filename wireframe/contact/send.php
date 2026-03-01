<?php
/**
 * Contact form handler for Success Career Airline
 * Place this file alongside index.html on the WordPress server.
 */

// Set response type
header('Content-Type: application/json; charset=utf-8');

// Only accept POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Collect and sanitize input
$name    = isset($_POST['name'])    ? trim(strip_tags($_POST['name']))    : '';
$email   = isset($_POST['email'])   ? trim(strip_tags($_POST['email']))   : '';
$phone   = isset($_POST['phone'])   ? trim(strip_tags($_POST['phone']))   : '';
$message = isset($_POST['message']) ? trim(strip_tags($_POST['message'])) : '';

// Validate required fields
$errors = [];
if ($name === '') {
    $errors[] = 'お名前を入力してください。';
}
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = '有効なメールアドレスを入力してください。';
}
if ($message === '') {
    $errors[] = 'メッセージを入力してください。';
}

if (!empty($errors)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => implode("\n", $errors)]);
    exit;
}

// Prepare email
$to = 'succes.airline@gmail.com';
$subject = 'お問い合わせページから：' . $name . '様';

$body  = "【お問い合わせ】\n\n";
$body .= "お名前：{$name}\n";
$body .= "メールアドレス：{$email}\n";
$body .= "電話番号：{$phone}\n\n";
$body .= "メッセージ：\n{$message}\n";

$headers  = "From: {$name} <{$email}>\r\n";
$headers .= "Reply-To: {$email}\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

// Send email
$sent = mb_send_mail($to, $subject, $body, $headers);

if ($sent) {
    echo json_encode(['success' => true, 'message' => 'お問い合わせを送信しました。ありがとうございます。']);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => '送信に失敗しました。お手数ですが直接メールにてご連絡ください。']);
}
