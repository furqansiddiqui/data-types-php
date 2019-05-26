<?php
/**
 * This file is a part of "furqansiddiqui/data-types-php" package.
 * https://github.com/furqansiddiqui/data-types-php
 *
 * Copyright (c) 2019 Furqan A. Siddiqui <hello@furqansiddiqui.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code or visit following link:
 * https://github.com/furqansiddiqui/data-types-php/blob/master/LICENSE
 */

declare(strict_types=1);

namespace FurqanSiddiqui\DataTypes;

/**
 * Class DataTypes
 * @package FurqanSiddiqui\DataTypes
 */
class DataTypes
{
    /** string Version (Major.Minor.Release-Suffix) */
    public const VERSION = "0.2.20";
    /** int Version (Major * 10000 + Minor * 100 + Release) */
    public const VERSION_ID = 220;

    /**
     * Checks if argument is of type String and encoded in Base16
     * @param $val
     * @return bool
     */
    public static function isBase16($val): bool
    {
        return is_string($val) && preg_match('/^(0x)?[a-f0-9]+$/i', $val) ? true : false;
    }

    /**
     * Checks if argument is of type String and encoded as Hexadecimals (Base16)
     * @param $val
     * @return bool
     */
    public static function isHex($val): bool
    {
        return self::isBase16($val);
    }

    /**
     * Checks if argument is of type String and encoded in Base64
     * @param $val
     * @return bool
     */
    public static function isBase64($val): bool
    {
        return is_string($val) && preg_match('/^[a-z0-9\+\/]+={0,2}$/i', $val) ? true : false;
    }

    /**
     * Checks if string may have UTF8 characters
     * @param string $val
     * @return bool
     */
    public static function isUtf8(string $val): bool
    {
        return strlen($val) !== mb_strlen($val) ? true : false;
    }
}