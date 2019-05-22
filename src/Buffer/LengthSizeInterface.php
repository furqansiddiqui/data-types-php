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
 * Interface LengthSizeInterface
 * @package FurqanSiddiqui\DataTypes\Buffer
 */
interface LengthSizeInterface
{
    /**
     * Length of buffer (multi-byte characters will count as 1)
     * @return int
     */
    public function chars(): int;

    /**
     * Size of buffer in bytes
     * @return int
     */
    public function size(): int;
}