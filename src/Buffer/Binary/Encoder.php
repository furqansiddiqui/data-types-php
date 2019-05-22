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

use FurqanSiddiqui\BcMath\BcNumber;
use FurqanSiddiqui\DataTypes\Base16;
use FurqanSiddiqui\DataTypes\Base64;
use FurqanSiddiqui\DataTypes\Binary;

/**
 * Class Encoder
 * @package FurqanSiddiqui\DataTypes\Buffer\Binary
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
     * @return BcNumber
     */
    public function base10(): BcNumber
    {
        return $this->BcNumber();
    }

    /**
     * @return BcNumber
     */
    public function decimals(): BcNumber
    {
        return $this->BcNumber();
    }

    /**
     * @return BcNumber
     */
    public function BcNumber(): BcNumber
    {
        return BcNumber::Decode($this->base16());
    }

    /**
     * @return Base64
     */
    public function base64(): Base64
    {
        return new Base64(base64_encode($this->binary->raw() ?? ""));
    }

    /**
     * @return Base16
     */
    public function base16(): Base16
    {
        return new Base16(bin2hex($this->binary->raw() ?? ""));
    }

    /**
     * @return Base16
     */
    public function hex(): Base16
    {
        return $this->base16();
    }
}