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

namespace furqansiddiqui\DataTypes;

use furqansiddiqui\DataTypes\Buffer\AbstractStringType;

/**
 * Class ASCII
 * @package furqansiddiqui\DataTypes
 */
class ASCII extends AbstractStringType
{
    /**
     * Encodes ASCII string into Hexits, This may be used instead of Base64 encoding if necessary
     * @param string $str
     * @return self
     */
    public static function Encode(string $str): self
    {
        if (DataTypes::isUtf8($str)) {
            throw new \InvalidArgumentException('String must not contain UTF8 characters');
        }

        $hex = "";
        for ($i = 0; $i < strlen($str); $i++) {
            $hex .= dechex(ord($str[$i]));
        }

        return new self($hex);
    }

    /**
     * Decodes encoded strings (via Encode method) back to original string value
     * @param string $hex
     * @return string
     */
    public static function Decode(string $hex): string
    {
        if (!DataTypes::isBase16($hex)) {
            throw new \InvalidArgumentException('First argument must be hexadecimal string');
        }

        $hex = substr($hex, 0, 2) === "0x" ? substr($hex, 2) : $hex;
        $str = "";
        for ($i = 0; $i < strlen($hex) - 1; $i += 2) {
            $str .= chr(hexdec($hex[$i] . $hex[$i + 1]));
        }

        return $str;
    }
}