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
        global $URL_API;

        $query = http_build_query([
            'action' => 'analize_domain',
            'url' => $url            
        ]);
        
        $url_api = $URL_API . "?" . $query;
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url_api
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        
        if (!is_null($response) && isset($response)) {                        
            $analysis_result = json_decode($response);
            if ($analysis_result->status == 'OK'){
                $data = array();
                $data_array = $analysis_result->data;                
                $data['tags'] = $data_array->tags;
                $data['classification'] = $data_array->classification;
                $data['url'] = $data_array->url;
                $result['data'] = $data;
                $result['status'] = 'OK';
            }else{
                $result['status'] = 'NO';
                $result['message'] = 'An error has ocurred.';
            }

        }
    } catch (Exception $ex) {
        $result['status'] = 'NO';
        $result['message'] = 'An error has occurred.';
    }
}

echo json_encode($result);
