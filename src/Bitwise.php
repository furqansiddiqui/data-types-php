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
 * Class Bitwise
 * @package FurqanSiddiqui\DataTypes
 */
class Bitwise extends AbstractBuffer
{
    /**
     * @param string|null $data
     * @return string
     */
    public function validatedDataTypeValue(?string $data): string
    {
        if (!DataTypes::isBitwise($data)) {
            throw new \InvalidArgumentException('First argument must be a Binary bitwise (1s and 0s) value');
        }

        return $data;
    }

    /**
     * @return Base16
     */
    public function base16(): Base16
    {
        return new Base16(BcBaseConvert::BaseConvert($this->data() ?? "", 2, 16));
    }

    /**
     * @return Binary
     */
    public function binary(): Binary
    {
        return $this->base16()->binary();
    }

    /**
     * @return array
     */
    public function chunksByByte(): array
    {
        return $this->chunks(8);
    }

    /**
     * @return array
     */
    public function chunksByNibble(): array
    {
        return $this->chunks(4);
    }

    /**
     * @param int $len
     * @return array
     */
    private function chunks(int $len): array
    {
        return explode(" ", chunk_split($this->data() ?? "", $len, " "));
    }
}