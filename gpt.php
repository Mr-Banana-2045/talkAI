<?php
header('Content-Type: application/json; charset=utf-8');

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
    echo json_encode(['error' => 'An error occurred.']);
    exit;
}

curl_close($ch);
$data = json_decode($response, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['error' => 'An error occurred while decoding JSON.']);
    exit;
}

if (isset($data['results'])) {
    $results = $data['results'];
    $del = ['' => '😊'];
    $translatedText = strtr($results, array_flip($del));

    $translateUrl = "https://api.codebazan.ir/translate/?type=json&from=fa&to=en&text=" . urlencode($results);
    
    $chTranslate = curl_init($translateUrl);
    curl_setopt($chTranslate, CURLOPT_RETURNTRANSFER, true);
    
    $translateResponse = curl_exec($chTranslate);
    if ($translateResponse === false) {
        echo json_encode(['error' => 'An error occurred while calling Codebazan API.']);
        exit;
    }

    curl_close($chTranslate);
    $translateData = json_decode($translateResponse, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode(['error' => 'An error occurred while decoding translation JSON.']);
        exit;
    }

    if (isset($translateData['translation'])) {
        echo json_encode([
            'fa' => strtr($results, array_flip($del)),
            'en' => strtr($translateData['translation'], array_flip($del))
        ]);
    } else {
        echo json_encode(['error' => 'No translation found.']);
    }
} else {
    echo json_encode(['error' => 'No results found.']);
}
?>
