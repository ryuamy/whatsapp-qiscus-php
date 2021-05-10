<?php

/**
 * Authentication.php
 *
 * @category Class
 * @package  Ryuamy\WAQiscus
 *
 * @author   Ryu Amy <ryuamy.mail@gmail.com>
 */

namespace Ryuamy\WAQiscus;

/**
 * Class Authentication
 *
 * @category Class
 * @package  Ryuamy\WAQiscus
 *
 * @author   Ryu Amy <ryuamy.mail@gmail.com>
 */
class Message
{
    /**
     * Required parameters for Login Client.
     *
     * @var array
     */
    private static $sessionMsgRequiredParams = [
        'to',
        'message'
    ];

    /**
     * Required parameter types for Login Client.
     *
     * @var array
     */
    private static $sessionMsgTypeParams = [
        'to' => 'string',
        'message' => 'string'
    ];

    /**
     * Client login into Treasury and obtain the bearer token for new user registration.
     *
     * @param   boolean     $flag
     * @param   array       $params
     *
     * @return object
     *
     * @throws \TypeError
     * @throws \ArgumentCountError
     */
    public static function session(string $appId, string $auth, string $channelId, array $params): object
    {
        Validator::validateRequirement(self::$sessionMsgRequiredParams, $params)->validateType(self::$sessionMsgTypeParams, $params);

        $params['recipient_type'] = 'individual';
        $params['type'] = 'text';
        $params['text'] = [
            'body' => $params['message']
        ];
        unset($params['message']);

        return Api::sendRequest('SESSION_MESSAGE', $appId, $params, $channelId, $auth);
    }
}
