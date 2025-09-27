<?php
session_start();
header('Content-Type: application/json');

// بررسی متد POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'روش نامعتبر']);
    exit;
}

// شماره موبایل کاربر از POST
$phone = trim($_POST['phone'] ?? '');
if (!$phone || !preg_match('/^09[0-9]{9}$/', $phone)) {
    echo json_encode(['success' => false, 'message' => 'شماره موبایل معتبر نیست']);
    exit;
}

// تولید کد OTP 6 رقمی و ذخیره در session
$otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
$_SESSION['otp'] = $otp;
$_SESSION['otp_expire'] = time() + 300; // 5 دقیقه اعتبار
$_SESSION['phone'] = $phone;

 // اطلاعات API smsg.ir
// $apiToken = 'YOUR_API_TOKEN'; // ← اینجا توکن واقعی خودت را قرار بده
// $url = 'https://api.smsg.ir/v1/otp/send';
$url = "https://smsg.ir/rest/?method=sendOTP&arg1=USER&arg2=PASS&arg3=PHONE&arg5=BRAND"

// داده‌های مورد نیاز برای ارسال OTP
$data = [
    'phone' => $phone,
    'token' => $apiToken,
    'template' => 'کد تأیید شما: {{code}}', // قالب پیامک
    'expire' => 5
];

// ارسال درخواست با cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
$response = curl_exec($ch);

if(curl_errno($ch)) {
    echo json_encode(['success' => false, 'message' => 'خطا در اتصال به سرور پیامک']);
    curl_close($ch);
    exit;
}
curl_close($ch);

// بررسی پاسخ API
$result = json_decode($response, true);
if(isset($result['status']) && $result['status'] == 'success') {
    echo json_encode(['success' => true, 'message' => 'کد تأیید به شماره '.$phone.' ارسال شد ✅']);
} else {
    echo json_encode([
        'success' => false,
        'message' => $result['message'] ?? 'خطا در ارسال پیامک ❌',
        'raw_response' => $response
    ]);
}
?>
