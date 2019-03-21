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
 * Class Base16
 * @package FurqanSiddiqui\DataTypes
 */
class Base16 extends Binary
{
    /**
     * Base16 constructor.
     * @param string $hexits
     */
    public function __construct(string $hexits)
    {
        parent::__construct(hex2bin(self::checkHexits($hexits)));
    }

    /**
     * @param bool|null $prefixed
     * @return string
     */
    public function hexits(?bool $prefixed = false): string
    {
        return $this->get()->base16($prefixed);
    }

    /**
     * Checks if argument is valid Base16, and removes "0x" prefix if found
     * @param $val
     * @return string
     */
    private static function checkHexits($val): string
    {
        if (!DataTypes::isBase16($val)) {
            throw new \InvalidArgumentException('First argument must be a Hexadecimal value');
        }

        return substr($val, 0, 2) === "0x" ? substr($val, 2) : $val;
    }
}