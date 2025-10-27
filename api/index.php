<?php
// Lấy tham số từ URL
$email = $_GET['email'] ?? '';
$subject = $_GET['subject'] ?? '';
$body = $_GET['body'] ?? '';

// Kiểm tra user-agent để phát hiện Zalo (tùy chọn, để giới hạn)
$userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
if (strpos($userAgent, 'Zalo') === false) {
    // Nếu không phải Zalo, hiển thị thông báo (hoặc redirect khác)
    http_response_code(403);
    echo "Vui lòng quét QR bằng Zalo.";
    exit;
}

// Mã hóa cho URL mailto (thay khoảng trắng bằng %20, v.v.)
$subject_encoded = urlencode($subject);
$body_encoded = urlencode($body);

// Tạo URL mailto hoặc deep link Gmail
$mailto_url = "mailto:$email?subject=$subject_encoded&body=$body_encoded";

// Ưu tiên deep link Gmail nếu có thể
$gmail_deep_link = "googlegmail:///co?to=$email&subject=$subject_encoded&body=$body_encoded";

// Redirect (301: Permanent Redirect)
header("Location: $gmail_deep_link", true, 301);
// Fallback nếu deep link không hỗ trợ
// header("Location: $mailto_url", true, 301);

exit;
?>
