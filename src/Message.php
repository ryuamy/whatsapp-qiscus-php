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
     * Required parameters for Sending Session Message.
     *
     * @var array
     */
    private static $sessionMsgRequiredParams = [
        'whatsapp_number',
        'message'
    ];

    /**
     * Required parameter types for Sending Session Message.
     *
     * @var array
     */
    private static $sessionMsgTypeParams = [
        'whatsapp_number' => 'string',
        'message' => 'string'
    ];

    /**
     * Required parameters for Sending Template Message.
     *
     * @var array
     */
    private static $templateMsgRequiredParams = [
        'whatsapp_number',
        'template_namespace',
        'template_name',
        'language_code',
        'components'
    ];

    /**
     * Required parameter types for Sending Template Message.
     *
     * @var array
     */
    private static $templateMsgTypeParams = [
        'whatsapp_number' => 'string',
        'template_namespace' => 'string',
        'template_name' => 'string',
        'language_code' => 'string',
        'components' => 'array'
    ];

    /**
     * Sending session message.
     * In order to start chat with this Sandbox number, user will need to initiate the chat with client number first here :
     * https://wa.me/(client number)
     * Please refer to this documentations as well to understand the possibility of the payload :
     * https://developers.facebook.com/docs/whatsapp/api/messages/text
     * https://developers.facebook.com/docs/whatsapp/api/messages/media
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

        $requestBody = [
            'recipient_type' => 'individual',
            'to' => $params['whatsapp_number'],
            'type' => 'text',
            'text' => [
                'body' => $params['message']
            ]
        ];

        return Api::sendRequest('SESSION_MESSAGE', $appId, $requestBody, $channelId, $auth);
    }

    /**
     * Sending template message.
     * You need to setup template first in your Qiscus Dashboard, if you already have then you can continue to use this API.
     * Please refer this documentations as well to understand the possibility of the payload :
     * https://developers.facebook.com/docs/whatsapp/api/messages/message-templates
     * https://developers.facebook.com/docs/whatsapp/api/messages/message-templates/media-message-templates
     *
     * @param   boolean     $flag
     * @param   array       $params
     *
     * @return object
     *
     * @throws \TypeError
     * @throws \ArgumentCountError
     */
    public static function template(string $appId, string $auth, string $channelId, array $params): object
    {
        Validator::validateRequirement(self::$templateMsgRequiredParams, $params)->validateType(self::$templateMsgTypeParams, $params);

        $requestBody = [
            'to' => $params['whatsapp_number'],
            'type' => 'template',
            'template' => [
                'namespace' => $params['template_namespace'],
                'name' => $params['template_name'],
                'language' => [
                    'policy' => 'deterministic',
                    'code' => $params['language_code']
                ],
                'components' => $params['components']
            ]
        ];

        return Api::sendRequest('TEMPLATE_MESSAGE', $appId, $requestBody, $channelId, $auth);
    }
}
