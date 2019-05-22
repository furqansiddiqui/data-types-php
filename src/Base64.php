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

use FurqanSiddiqui\DataTypes\Buffer\AbstractBuffer;

/**
 * Class Base64
 * @package FurqanSiddiqui\DataTypes
 */
class Base64 extends AbstractBuffer
{
    /**
     * @param string|null $data
     * @return string
     */
    public function validatedDataTypeValue(?string $data): string
    {
        if (!DataTypes::isBase64($data)) {
            throw new \InvalidArgumentException('First argument must be a Base64 encoded string');
        }

        $decoded = base64_decode($data);
        if ($decoded === false) {
            throw new \UnexpectedValueException('Base64 decode failed');
        }

        return $data;
    }

    /**
     * @return string
     */
    public function encoded(): string
    {
        return $this->data();
    }

    /**
     * @return string
     */
    public function getBase64Encoded(): string
    {
        return $this->encoded();
    }

    /**
     * @return Binary
     */
    public function binary(): Binary
    {
        return new Binary(base64_decode($this->data()));
    }

    /**
     * @return Binary
     */
    public function getBinary(): Binary
    {
        return $this->binary();
    }
}