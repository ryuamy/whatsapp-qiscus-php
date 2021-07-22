<?php

/**
 * Validator.php
 *
 * @category Class
 * @package  Ryuamy\WAQiscus
 *
 * @author   Ryu Amy <ryuamy.mail@gmail.com>
 */

namespace Ryuamy\WAQiscus;

/**
 * Class Validator
 *
 * @category Class
 * @package  Ryuamy\WAQiscus
 *
 * @author   Ryu Amy <ryuamy.mail@gmail.com>
 */
class Validator
{
    /**
     * List of invalid response codes.
     *
     * @var array
     */
    private static $invalidResponseCode = [
        400 => 'Invalid Parameters',
        401 => 'Invalid Token',
        403 => 'Invalid Authorization',
        404 => 'Invalid Endpoint',
        429 => 'Request Limit',
        500 => 'Contact Qiscus PIC',
        502 => 'Contact Qiscus PIC',
        503 => 'Contact Qiscus PIC'
    ];

    /**
     * Check if required parameters is exists in the request parameters.
     *
     * @param   array   $requiredParams
     * @param   array   $params
     *
     * @return self
     */
    public static function validateRequirement(array $requiredParams, array $params): self
    {
        $arrIntersect = array_intersect(array_keys($params), $requiredParams);
        $missingParams = array_diff($requiredParams, $arrIntersect);

        if (count($missingParams)) {
            $implodedParams = implode(', ', $missingParams);

            throw new \BadFunctionCallException('Parameter '. $implodedParams . ' is required.');
        }

        return new self();
    }

    /**
     * Check if the request parameters have the correct data type.
     *
     * @param   array   $typeParams
     * @param   array   $params
     *
     * @return void
     */
    public static function validateType(array $typeParams, array $params): void
    {
        foreach ($params as $key => $value) {
            $typeParam = explode('|', $typeParams[$key]);

            if (!in_array(gettype($value), $typeParam)) {
                throw new \InvalidArgumentException('Parameter ' . $key . ' must be ' . implode(' or ', $typeParam) . '.');
            }
        }
    }

    /**
     * Check if response code from API is valid.
     *
     * @param   int  $responseCode
     *
     * @return void
     */
    public static function validateResponseCode(int $responseCode, string $responseBody): void
    {
        if ($responseCode !== 200 && $responseCode !== 201) {
            if (isset(self::$invalidResponseCode[$responseCode])) {
                throw new \ErrorException('Qiscus API Response Code: ' . $responseCode. '. ' . $responseBody . '. ' . self::$invalidResponseCode[$responseCode] . '.');
            }

            throw new \ErrorException('Invalid Qiscus API Response Code: ' . $responseCode);
        }
    }
}
