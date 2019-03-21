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
 * Class AbstractStringType
 * This class should be extended to define Strings as custom data types for type hinting purposes
 * @package FurqanSiddiqui\DataTypes\Buffer
 */
abstract class AbstractStringType extends AbstractBuffer
{
    /**
     * @param int|null $start
     * @param int|null $length
     * @return string|null
     */
    public function get(?int $start = null, ?int $length = null): ?string
    {
        return $this->data($start, $length);
    }

    /**
     * @param int|null $start
     * @param int|null $length
     * @return string|null
     */
    public function value(?int $start = null, ?int $length = null): ?string
    {
        return $this->data($start, $length);
    }
}