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

use FurqanSiddiqui\BcMath\BcBaseConvert;
use FurqanSiddiqui\DataTypes\Buffer\AbstractBuffer;

/**
 * Class Base16
 * @package FurqanSiddiqui\DataTypes
 */
class Base16 extends AbstractBuffer
{
    /**
     * @param string|null $data
     * @return string
     */
    public function validatedDataTypeValue(?string $data): string
    {
        if (!DataTypes::isBase16($data)) {
            throw new \InvalidArgumentException('First argument must be a Hexadecimal value');
        }

        // Remove "0x" prefix
        if (substr($data, 0, 2) === "0x") {
            $data = substr($data, 2);
        }

        // Even-out uneven number of hexits
        if (strlen($data) % 2 !== 0) {
            $data = "0" . $data;
        }

        return $data;
    }

    /**
     * @param bool $prefixed
     * @return string
     */
    public function hexits(bool $prefixed = false): string
    {
        $prefix = $prefixed === true ? "0x" : "";
        return $prefix . $this->data();
    }

    /**
     * @return Bitwise
     */
    public function bitwise(): Bitwise
    {
        $hexits = $this->data();
        if (!$hexits) {
            throw new \UnexpectedValueException('Base16 buffer is NULL or empty');
        }

        // Make sure nibbles are even
        if (strlen($hexits) % 2 !== 0) {
            $hexits = "0" . $hexits;
        }

        $expectedBits = strlen($hexits) * 4;
        $bitwise = BcBaseConvert::BaseConvert($hexits, 16, 2);
        if (strlen($bitwise) < $expectedBits) {
            $bitwise = str_repeat("0", $expectedBits - strlen($bitwise)) . $bitwise;
        }

        return new Bitwise($bitwise);
    }

    /**
     * @return Binary
     */
    public function binary(): Binary
    {
        return new Binary(hex2bin($this->data()));
    }

    /**
     * @return Binary
     */
    public function getBinary(): Binary
    {
        return $this->binary();
    }
}