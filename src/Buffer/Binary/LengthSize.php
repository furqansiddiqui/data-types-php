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

namespace FurqanSiddiqui\DataTypes\Buffer\Binary;

/**
 * Class LengthSize
 * @package FurqanSiddiqui\DataTypes\Buffer\Binary
 */
class LengthSize extends \FurqanSiddiqui\DataTypes\Buffer\LengthSize
{
    /**
     * @return int
     */
    public function bits(): int
    {
        return $this->buffer->sizeInBytes * 8;
    }

    /**
     * @return int
     */
    public function hexits(): int
    {
        return $this->buffer->sizeInBytes * 2;
    }

    /**
     * @return int
     */
    public function bytes(): int
    {
        return $this->buffer->sizeInBytes;
    }
}