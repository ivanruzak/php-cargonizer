<?php

namespace zaporylie\Cargonizer;

use Http\Discovery\Psr18ClientDiscovery;
use Psr\Http\Client\ClientInterface;

/**
 * Class Config
 *
 * @package zaporylie\Cargonizer
 */
class Config
{
  const SANDBOX = 'https://sandbox.cargonizer.no';
  const PRODUCTION = 'https://cargonizer.no';

  protected static $config = [
    'endpoint' => self::SANDBOX,
    'sender' => NULL,
    'secret' => NULL,
  ];

  public function __construct() {}
  public function __wakeup() {}

  public static function set($key, $val): void
  {
    self::$config[$key] = $val;
  }

  public static function get($key)
  {
    return self::$config[$key];
  }

  /**
   * Use this static method to get default HTTP Client.
   *
   * @param \Psr\Http\Client\ClientInterface|null $client
   *
   * @return \Psr\Http\Client\ClientInterface
   */
  public static function clientFactory(?ClientInterface $client = null): ClientInterface
  {
    if ($client === null) {
      return Psr18ClientDiscovery::find();
    }

    if (!$client instanceof ClientInterface) {
      throw new \LogicException(sprintf(
        'HTTP client must implement "%s".',
        ClientInterface::class
      ));
    }

    return $client;
  }

}
