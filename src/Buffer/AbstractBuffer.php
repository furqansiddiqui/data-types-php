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
 * Class AbstractBuffer
 * @package FurqanSiddiqui\DataTypes\Buffer
 * @property-read int $sizeInBytes
 */
abstract class AbstractBuffer
{
    /** @var null|string */
    private $data;
    /** @var int */
    private $len;
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
     * @return array
     */
    public function __debugInfo()
    {
        return [
            "bytes" => $this->size()->bytes(),
            "bits" => $this->size()->bits(),
            "data" => $this->data
        ];
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
     * @return AbstractBuffer
     */
    public function clone()
    {
        return $this->copy();
    }

    /**
     * @return AbstractBuffer
     */
    public function __clone()
    {
        return $this->clone();
    }

    /**
     * @param int|null $start
     * @param int|null $length
     * @return $this
     */
    public function substr(?int $start = null, ?int $length = null)
    {
        if (!$start && !$length) {
            throw new \InvalidArgumentException('Both start/end arguments cannot be empty');
        }

        $data = $this->data;
        if (is_int($start)) {
            $data = is_int($length) ? substr($data, $start, $length) : substr($data, $start);
            if ($data === false) {
                throw new \UnexpectedValueException('Unexpected fail after applying substr');
            }
        }

        $this->set($data);
        return $this;
    }

    /**
     * @param int|null $start
     * @param int|null $length
     * @return AbstractBuffer
     */
    public function trim(?int $start = null, ?int $length = null)
    {
        return $this->substr($start, $length);
    }

    /**
     * @param string $data
     * @return $this
     */
    public function append(string $data)
    {
        $this->set($this->data . $data);
        return $this;
    }

    /**
     * @param string $data
     * @return $this
     */
    public function prepend(string $data)
    {
        $this->set($data . $this->data);
        return $this;
    }

    /**
     * @param bool $set
     * @return $this
     */
    public function readOnly(bool $set = true)
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