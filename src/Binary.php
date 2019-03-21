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

/**
 * Class Binary
 * @package FurqanSiddiqui\DataTypes
 */
class Binary extends AbstractBuffer
{
    /** @var null|Encoder */
    private $encoder;

    /**
     * @return string|null
     */
    public function raw(): ?string
    {
        return parent::data();
    }

    /**
     * @param int|null $start
     * @param int|null $end
     * @return string|null
     */
    public function bytes(?int $start = null, ?int $end = null): ?string
    {
        return parent::data($start, $end);
    }

    /**
     * @param int|null $start
     * @param int|null $end
     * @return Binary
     */
    public function copy(?int $start = null, ?int $end = null): Binary
    {
        return new Binary($this->bytes($start, $end));
    }

    /**
     * @return Encoder
     */
    public function get(): Encoder
    {
        if (!$this->encoder) {
            $this->encoder = new Encoder($this);
        }

        return $this->encoder;
    }

    /**
     * @param string|null $data
     * @return Binary
     */
    public function set(?string $data): Binary
    {
        parent::set($data);
        return $this;
    }

    /**
     * @param string $binary
     * @return Binary
     */
    public function append(string $binary): Binary
    {
        $this->set($this->raw() . $binary);
        return $this;
    }

    /**
     * @param string $binary
     * @return Binary
     */
    public function prepend(string $binary): Binary
    {
        $this->set($binary . $this->raw());
        return $this;
    }

    /**
     * @return Hashing
     */
    public function hash(): Hashing
    {
        return new Hashing($this);
    }
}