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
 * @property-read int $charCount
 */
abstract class AbstractBuffer
{
    /** @var null|string */
    private $data;
    /** @var int */
    private $len;
    /** @var bool */
    private $readOnly;

    /** @var null|LengthSize */
    private $size;

    /**
     * @param AbstractBuffer ...$buffers
     * @return AbstractBuffer
     */
    public static function Concat(AbstractBuffer ...$buffers)
    {
        $concat = "";
        foreach ($buffers as $buffer) {
            if (!$buffer instanceof static) {
                throw new \RuntimeException(
                    sprintf('Concatenation expects all buffers to by of type "%s"', static::class)
                );
            }

            $concat .= $buffer->data();
        }

        return new static($concat);
    }

    /**
     * AbstractBuffer constructor.
     * @param string|null $data
     */
    public function __construct(?string $data = null)
    {
        $this->readOnly = false;
        $this->data = "";
        $this->len = 0;

        if ($data) {
            $this->set($data);
        }
    }

    /**
     * @return array
     */
    public function __debugInfo()
    {
        return [
            "length" => $this->size()->chars(),
            "size" => $this->size()->size(),
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
            case "charCount":
                return mb_strlen($this->data);
        }

        throw new \DomainException('Cannot get value of inaccessible property');
    }

    /**
     * @param $data
     * @return string
     */
    abstract protected function validatedDataTypeValue(?string $data): string;

    /**
     * @param string|null $data
     * @return $this
     */
    public function set(?string $data)
    {
        if ($this->readOnly) {
            throw new \BadMethodCallException('Buffer is in read-only state');
        }

        $validated = $this->validatedDataTypeValue($data);
        $this->data = $validated;
        $this->len = strlen($this->data);
        return $this;
    }

    /**
     * @param string $data
     * @return $this
     */
    public function append($data)
    {
        if ($data instanceof AbstractBuffer) {
            $data = $data->data();
        }

        if (!is_string($data)) {
            throw new \InvalidArgumentException('Appending data must be of type String or a Buffer');
        }

        $appended = $this->data() . $data;
        $this->set($appended);
        return $this;
    }

    /**
     * @param $data
     * @return $this
     */
    public function prepend($data)
    {
        if ($data instanceof AbstractBuffer) {
            $data = $data->data();
        }

        if (!is_string($data)) {
            throw new \InvalidArgumentException('Prepend data must be of type String or a Buffer');
        }

        $prepended = $data . $this->data();
        $this->set($prepended);
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
     * @return static
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
     * @param bool $set
     * @return $this
     */
    public function readOnly(bool $set = true)
    {
        $this->readOnly = $set;
        return $this;
    }

    /**
     * @param \Closure $callback
     */
    public function apply(\Closure $callback): void
    {
        $new = $callback($this->data);
        if (!is_string($new)) {
            throw new \UnexpectedValueException('Callback method supplied to "apply" method must return String');
        }

        $this->set($new);
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