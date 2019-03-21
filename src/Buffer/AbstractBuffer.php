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

namespace furqansiddiqui\DataTypes\Buffer;

/**
 * Class AbstractBuffer
 * @package furqansiddiqui\DataTypes\Buffer
 * @property-read int $sizeInBytes
 */
abstract class AbstractBuffer
{
    /** @var null|string */
    protected $data;
    /** @var int */
    protected $len;

    /** @var bool */
    private $readOnly;
    /** @var null|Size */
    private $size;

    /**
     * AbstractBuffer constructor.
     * @param string|null $data
     */
    public function __construct(?string $data = null)
    {
        $this->readOnly = false;
        $this->set($data);
    }

    /**
     * @param $prop
     * @return int
     */
    public function __get($prop)
    {
        switch ($prop) {
            case "sizeInBytes":
                return $this->len;
        }

        throw new \DomainException('Cannot get value of inaccessible property');
    }

    /**
     * @param string|null $data
     * @return $this
     */
    public function set(?string $data)
    {
        if ($this->readOnly) {
            throw new \BadMethodCallException('Buffer is in read-only state');
        }

        $this->data = $data;
        $this->len = strlen($this->data);
        return $this;
    }

    /**
     * @param int|null $start
     * @param int|null $length
     * @return string|null
     */
    public function data(?int $start = null, ?int $length = null): ?string
    {
        if (!is_string($this->data)) {
            return null;
        }

        $data = $this->data;
        if (is_int($start)) {
            $data = is_int($length) ? substr($data, $start, $length) : substr($data, $start);
            if ($data === false) {
                return null;
            }
        }

        return $data;
    }

    /**
     * @param int|null $start
     * @param int|null $end
     * @return AbstractBuffer
     */
    public function copy(?int $start = null, ?int $end = null)
    {
        return new static($this->data($start, $end) ?? "");
    }

    /**
     * @param bool $set
     * @return AbstractBuffer
     */
    public function readOnly(bool $set = true): self
    {
        $this->readOnly = $set;
        return $this;
    }

    /**
     * @return Size
     */
    public function size(): Size
    {
        if (!$this->size) {
            $this->size = new Size($this);
        }

        return $this->size;
    }

    /**
     * @return Size
     */
    public function length(): Size
    {
        return $this->size();
    }
}