<?php
header('Content-Type: application/json');
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'روش نامعتبر است']);
    exit;
}

$phone = $_POST['phone'] ?? '';
if (!preg_match('/^09[0-9]{9}$/', $phone)) {
    echo json_encode(['success' => false, 'message' => 'شماره موبایل معتبر نیست']);
    exit;
}

// تولید OTP
$otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
$_SESSION['otp'] = $otp;
$_SESSION['otp_expire'] = time() + 90;
$_SESSION['phone'] = $phone;

// اطلاعات ورود smsg.ir
$username = 'ali-amin';
$password = 'aslkf@#j123o21joj23';
$sender   = '3000XXXXXXX'; // شماره فرستنده
$text     = "کد تایید شما: $otp";

// ساخت URL وب‌سرویس قدیمی
$url = "http://smsg.ir/rest/?method=send"
     . "&arg1=" . urlencode($username)
     . "&arg2=" . urlencode($password)
     . "&arg3=" . urlencode($phone)
     . "&arg4=" . urlencode($sender)
     . "&arg5=" . urlencode($text);

// ارسال
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

echo json_encode([
    'success' => true,
    'message' => 'کد تأیید ارسال شد ✅',
    'debug'   => $response // 🔎 خروجی خام برای تست
]);
