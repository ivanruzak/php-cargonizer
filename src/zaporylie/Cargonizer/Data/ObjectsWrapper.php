<?php

namespace zaporylie\Cargonizer\Data;

abstract class ObjectsWrapper implements \Iterator
{

  /**
   * Array of mixed objects.
   *
   * @var array
   */
  protected $array = [];

  /**
   * Creates a new iterator from an ArrayObject instance.
   *
   * @return \ArrayIterator
   *   An array iterator.
   */
  #[\ReturnTypeWillChange]
  public function getIterator() {
    return new \ArrayIterator($this->array);
  }

  /**
   * Remove item from array.
   *
   * @param string|int $delta
   *
   * @return self
   */
  public function removeItem($delta) {
    if (isset($this->array[$delta])) {
      unset($this->array[$delta]);
    }
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  #[\ReturnTypeWillChange]
  public function rewind() {
    return reset($this->array);
  }

  /**
   * {@inheritdoc}
   */
  #[\ReturnTypeWillChange]
  public function current() {
    return current($this->array);
  }

  /**
   * {@inheritdoc}
   */
  #[\ReturnTypeWillChange]
  public function key() {
    return key($this->array);
  }

  /**
   * {@inheritdoc}
   */
  #[\ReturnTypeWillChange]
  public function next() {
    return next($this->array);
  }

  /**
   * {@inheritdoc}
   */
  #[\ReturnTypeWillChange]
  public function valid() {
    return key($this->array) !== null;
  }

}
