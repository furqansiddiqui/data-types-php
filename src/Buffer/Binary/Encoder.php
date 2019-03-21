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

namespace furqansiddiqui\DataTypes\Buffer\Binary;

use furqansiddiqui\DataTypes\Binary;

/**
 * Class Encoder
 * @package furqansiddiqui\DataTypes\Buffer\Binary
 */
class Encoder
{
    /** @var Binary */
    private $binary;

    /**
     * Encoder constructor.
     * @param Binary $binary
     */
    public function __construct(Binary $binary)
    {
        $this->binary = $binary;
    }

    /**
     * @return string|null
     */
    public function raw(): ?string
    {
        return $this->binary->raw();
    }

    /**
     * @return string
     */
    public function base64(): string
    {
        return base64_encode($this->binary->raw() ?? "");
    }

    /**
     * @param bool|null $prefixed
     * @return string
     */
    public function base16(bool $prefixed = false): string
    {
        $prefix = $prefixed ? "0x" : "";
        return $prefix . bin2hex($this->binary->raw() ?? "");
    }

    /**
     * @param bool $prefixed
     * @return string
     */
    public function hex(bool $prefixed = false): string
    {
        return $this->base16($prefixed);
    }
}