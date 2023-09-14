<?php

$curl = curl_init();

curl_setopt_array($curl, [
  CURLOPT_URL => "https://rapiboy.com/v1/NextDayBasic/GetList",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_POSTFIELDS => "{\n  \"FechaDesde\": \"2023/7/8\",\n  \"FechaHasta\": \"2023/7/10\"\n}",
  CURLOPT_HTTPHEADER => [
    "Accept: */*",
    "Content-Type: application/json",
    "Token: 64f7261e-26ec-44e7-8977-0055feaecaf7"
  ],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} 

?>