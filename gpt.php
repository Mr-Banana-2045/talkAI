<?php
header('Content-Type: text/html; charset=utf-8');

error_reporting(0);
ini_set('display_errors', 0);

$url = "https://req.wiki-api.ir/apis-1/ChatGPT?q=" . urlencode($_GET['text']);

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Accept-Charset: utf-8'
]);

$response = curl_exec($ch);

if ($response === false) {
    die('An error occurred.');
}

curl_close($ch);

$data = json_decode($response, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    die('An error occurred.');
}

if (isset($data['results'])) {
   $results = $data['results'];
   $dec = ['kh' => 'خ', 'oo' => 'و', 'b' => 'ب', 'y' => 'ی', 'i' => 'ی', 'sa' => 'س', 'a' => 'ا', 'l' => 'ل', 'm' => 'م', 'd' => 'د', 't' => 'ت','gh' => 'ق', 'ghe' => 'غ', 'he' => 'ح', 'tt' => 'ط', 'j' => 'ج', 'n' => 'ن', 'see' => 'ص', 'r' => 'ر', 'ze' => 'ظ', 'zee' => 'ذ', 'zz' => 'ض', 'ss' => 'ث', 'zhe' => 'ژ', 'che' => 'چ', 'c' => 'ک', 'h' => 'ه', 'z' => 'ز', 'f' => 'ف', 'p' => 'پ', 'k' => 'ک', 'sh' => 'ش', 'g' => 'گ', 'e' => '', 'ea' => 'ع', '.' => '؟', '   ' => '،', ' ' => '!', '  ' => '```', '' => '😊'];
   $res = strtr($results, array_flip($dec));
   echo $res;
} else {
    echo "No results found.";
}
?>
