<?php
session_start();
function getAccessToken() {
    $tenantId = '969e1afa-36ab-4d9e-bbc6-e9ce7ea47e99';
    $clientId = '14d457d3-e384-4bb4-833c-f9eeaa8f29d1';
    $clientSecret = 'whJ8Q~PxHRRH.DqQ~hDPNCwHyN4W3CAc~Nf44bkk';
    $scope = 'https://graph.microsoft.com/.default';
    $tokenUrl = "https://login.microsoftonline.com/$tenantId/oauth2/v2.0/token";

    $data = [
        'grant_type' => 'client_credentials',
        'client_id' => $clientId,
        'client_secret' => $clientSecret,
        'scope' => $scope
    ];

    $ch = curl_init($tokenUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/x-www-form-urlencoded'
    ]);

    $response = curl_exec($ch);

    if ($response === false) {
        $error = curl_error($ch);
        curl_close($ch);
        die("Curl error: $error");
    }

    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode !== 200) {
        die("HTTP error: $httpCode - Response: $response");
    }

    $tokenData = json_decode($response, true);

    if (isset($tokenData['access_token'])) {
        return $tokenData['access_token'];
    } else {
        die('Error retrieving access token - Response: ' . print_r($tokenData, true));
    }
}

$userEmail = 'santiago.parraga@bullmarketing.com.co';
echo $userEmail;
// $accessToken = getAccessToken();

// echo  "Access Token: $accessToken\n";

// $photoUrl = "https://graph.microsoft.com/v1.0/users/$userEmail/photo/\$value";

// $ch = curl_init($photoUrl);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch, CURLOPT_HTTPHEADER, [
//     'Authorization: Bearer ' . $accessToken,
//     'Content-Type: image/jpeg'
// ]);

// $certPath = __DIR__ . '/path/to/cacert.pem';
// if (file_exists($certPath)) {
//     curl_setopt($ch, CURLOPT_CAINFO, $certPath);
// } else {
//     die("El archivo cacert.pem no se encuentra en la ruta especificada.");
// }

// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

// $photo = curl_exec($ch);

// if ($photo === false) {
//     die('Curl error: ' . curl_error($ch));
// }

// $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
// curl_close($ch);

// if ($httpCode == 200 && $photo) {
//     $_SESSION['user_photo'] = base64_encode($photo);
// } else {
//     $_SESSION['user_photo'] = null;
//     echo "No se pudo obtener la foto. Código HTTP: $httpCode";
// }

// header('Location: showPhoto.php');
exit;
?>