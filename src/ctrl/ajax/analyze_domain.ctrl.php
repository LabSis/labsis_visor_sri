<?php

require_once '../../../config.php';
/**
 * The SRI returns a json with following format:
 * { "resultadosTags": [ { "tag": "<script ...>", 
 *                         "usaCdn": true|false, 
 *                         "cdn": "https://..", 
 *                         "verificaIntegridad": true|false,
 *                         "tipoVerificacion": "[SHA_256|SHA_386|SHA_512|null"
 *                       }
 *                     ],
 *   "clasificacion": "HTTPS|HTTP|MIXED",
 *   "url": "https://domain_analyzed.com"
 * }
 */
ini_set("display_errors", 1);
$result = array();

$url = filter_input(INPUT_POST, "url", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

if (!filter_var($url, FILTER_VALIDATE_URL)) {
    $result['status'] = 'NO';
    $result['message'] = 'Invalid url.';
} else {
    try {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        
        if (!is_null($response) && isset($response)) {
            $analysis_result = json_decode(join("", $analysis_result));
            $data = array();
            $data['tags'] = $analysis_result->resultadosTags;
            $data['classification'] = $analysis_result->clasificacion;
            $data['url'] = $analysis_result->url;

            $result['status'] = 'OK';
            $result['data'] = $data;
        }
    } catch (Exception $ex) {
        $result['status'] = 'NO';
        $result['message'] = 'An error has occurred.';
    }
}

echo json_encode($result);
