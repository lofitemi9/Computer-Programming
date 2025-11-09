<?php
header('Content-Type: application/json');
// attaching config.php
require_once __DIR__ . '\config.php';



function fetchCatApi($endpoint, $params = [])
{
    $url = CAT_API_URL . $endpoint;
    if (!empty($params)) $url .= '?' . http_build_query($params);
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => ['x-api-key: ' . CAT_API_KEY]
    ]);
    $res = curl_exec($ch);
    curl_close($ch);
    return $res;
}


$action = $_GET['action'] ?? '';
if ($action === 'breeds') echo fetchCatApi('/breeds');
elseif ($action === 'random') {
    $breed = $_GET['breed_id'] ?? '';
    $params = ['limit' => 1, 'has_breeds' => 1];
    if ($breed) $params['breed_ids'] = $breed;
    echo fetchCatApi('/images/search', $params);
} else echo json_encode(['error' => 'Unknown action']);
