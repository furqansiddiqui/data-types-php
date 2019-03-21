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

/**
 * Class Base64
 * @package furqansiddiqui\DataTypes
 */
class Base64 extends Binary
{
    /**
     * Base64 constructor.
     * @param string $data
     */
    public function __construct(string $data)
    {
        if (!DataTypes::isBase64($data)) {
            throw new \InvalidArgumentException('First argument must be a Base64 encoded string');
        }

        $decoded = base64_decode($data);
        if ($decoded === false) {
            throw new \UnexpectedValueException('Base64 decode failed');
        }

        parent::__construct($data);
    }

    /**
     * @return string
     */
    public function encoded(): string
    {
        return base64_encode($this->data);
    }
}