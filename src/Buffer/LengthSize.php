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

namespace FurqanSiddiqui\DataTypes\Buffer;

/**
 * Class LengthSize
 * @package FurqanSiddiqui\DataTypes\Buffer
 */
class LengthSize implements LengthSizeInterface
{
    /** @var AbstractBuffer */
    protected $buffer;

    /**
     * Size constructor.
     * @param AbstractBuffer $buffer
     */
    public function __construct(AbstractBuffer $buffer)
    {
        $this->buffer = $buffer;
    }

    /**
     * @return int
     */
    public function chars(): int
    {
        return $this->buffer->charCount;
    }

    /**
     * @return int
     */
    public function size(): int
    {
        return $this->buffer->sizeInBytes;
    }
}