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
use FurqanSiddiqui\DataTypes\Buffer\Binary\Encoder;
use FurqanSiddiqui\DataTypes\Buffer\Binary\Hashing;
use FurqanSiddiqui\DataTypes\Buffer\Binary\LengthSize;
use FurqanSiddiqui\DataTypes\Buffer\LengthSizeInterface;

/**
 * Class Binary
 * @package FurqanSiddiqui\DataTypes
 */
class Binary extends AbstractBuffer
{
    /** @var LengthSize */
    private $size;
    /** @var null|Encoder */
    private $encoder;

    /**
     * @return string|null
     */
    public function __toString()
    {
        return $this->raw();
    }

    /**
     * @return array
     */
    public function __debugInfo()
    {
        return [
            "bytes" => $this->size()->bytes(),
            "bits" => $this->size()->bits(),
            "hexits" => $this->size()->hexits(),
            "value" => $this->encode()->base16()->hexits(true) // 0x prefixed
        ];
    }

    /**
     * @return string|null
     */
    public function raw(): ?string
    {
        return $this->data();
    }

    /**
     * @param int|null $start
     * @param int|null $end
     * @return string|null
     */
    public function bytes(?int $start = null, ?int $end = null): ?string
    {
        return $this->data($start, $end);
    }

    /**
     * @param $data
     * @return string
     */
    public function validatedDataTypeValue(?string $data): string
    {
        return $data ?? "";
    }

    /**
     * @return Encoder
     */
    public function get(): Encoder
    {
        return $this->encode();
    }

    /**
     * @return Encoder
     */
    public function encode(): Encoder
    {
        if (!$this->encoder) {
            $this->encoder = new Encoder($this);
        }

        return $this->encoder;
    }

    /**
     * @return Hashing
     */
    public function hash(): Hashing
    {
        return new Hashing($this);
    }

    /**
     * @return LengthSize
     */
    public function size(): LengthSizeInterface
    {
        if (!$this->size) {
            $this->size = new LengthSize($this);
        }

        return $this->size;
    }
}