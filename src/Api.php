<?php

/**
 * Api.php
 *
 * @category Class
 * @package  Ryuamy\WAQiscus
 *
 * @author   Ryu Amy <ryuamy.mail@gmail.com>
 */

namespace Ryuamy\WAQiscus;

/**
 * Class Api
 *
 * @category Class
 * @package  Ryuamy\WAQiscus
 *
 * @author   Ryu Amy <ryuamy.mail@gmail.com>
 */
class Api
{
    /**
     * Send HTTP Request to Qiscus.
     */
    public static function sendRequest(string $serviceType, string $appId, array $requestBody = [], string $channelId = '', string $authToken = ''): object
    {
        $baseUrl = 'https://multichannel.qiscus.com/';

        $requestHeaders = array();
        $requestHeaders[] = 'Accept: application/json';

        switch ($serviceType) {
            case 'AUTHENTICATION': {
                $baseUrl = $baseUrl . 'api/v1/auth';
            }
            break;
            case 'SETTING_WEBHOOKS': {
                $requestHeaders[] = 'Authorization: ' . $authToken;
                $requestHeaders[] = 'Content-Type: application/json';
                $requestHeaders[] = 'app_id: ' . $appId;

                $baseUrl = $baseUrl . 'whatsapp/' . $appId . '/' . $channelId . '/' . 'settings';
            }
            break;
            case 'SESSION_MESSAGE': {
                $requestHeaders[] = 'Authorization: ' . $authToken;
                $requestHeaders[] = 'Content-Type: application/json';
                $requestHeaders[] = 'app_id: ' . $appId;

                $baseUrl = $baseUrl . 'whatsapp/v1/' . $appId . '/' . $channelId . '/' . 'messages';
            }
            break;
            case 'TEMPLATE_MESSAGE': {
                $requestHeaders[] = 'Authorization: ' . $authToken;
                $requestHeaders[] = 'Content-Type: application/json';
                $requestHeaders[] = 'app_id: ' . $appId;

                $baseUrl = $baseUrl . 'whatsapp/v1/' . $appId . '/' . $channelId . '/' . 'messages';
            }
            break;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $baseUrl);
        curl_setopt($ch, CURLOPT_TIMEOUT, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $requestHeaders);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        if($serviceType === 'AUTHENTICATION') {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);
        } else {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestBody));
        }

        $httpRequest = curl_exec($ch);
        $httpEffectiveUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        Validator::validateResponseCode($httpCode);

        return json_decode($httpRequest);
    }
}
