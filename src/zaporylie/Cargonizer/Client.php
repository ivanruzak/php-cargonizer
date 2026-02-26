<?php

namespace zaporylie\Cargonizer;

use Http\Client\Exception\RequestException;
use Http\Discovery\Psr17FactoryDiscovery;
use Psr\Http\Client\ClientInterface;

/**
 * Class Client
 *
 * @package zaporylie\Cargonizer
 */
abstract class Client {

  protected $resource = null;
  protected $method = null;

  /**
   * PSR-18 HTTP client.
   *
   * @var \Psr\Http\Client\ClientInterface
   */
  protected ClientInterface $client;

  /**
   * PSR-17 request factory.
   *
   * @var \Psr\Http\Message\RequestFactoryInterface
   */
  protected $requestFactory;

  /**
   * PSR-17 stream factory.
   *
   * @var \Psr\Http\Message\StreamFactoryInterface
   */
  protected $streamFactory;

  public function __construct($client = null) {
    $this->client = Config::clientFactory($client);
  }

  /**
   * @return mixed
   * @throws \Exception
   */
  public function getResource() {
    if (!isset($this->resource)) {
      throw new \Exception('Undefined resource');
    }
    return $this->resource;
  }

  /**
   * @return string
   * @throws \Exception
   */
  public function getMetod() {
    if (!isset($this->method)) {
      throw new \Exception('Undefined method');
    }
    return $this->method;
  }

  /**
   * @param array $headers
   * @param mixed $data
   *
   * @return mixed
   * @throws \Exception
   */
  protected function request(array $headers = [], $data = null) {
    $headers += [
      'X-Cargonizer-Key' => Config::get('secret'),
      'X-Cargonizer-Sender' => Config::get('sender'),
    ];

    try {
      // Build request.
      $request = $this->requestFactory()
        ->createRequest(
          $this->getMetod(),
          Config::get('endpoint') . $this->getResource() . ($this->getMetod() === 'GET' && !empty($data) ? '?' . http_build_query($data) : '')
        );

      foreach ($headers as $name => $value) {
        $request = $request->withHeader($name, $value);
      }

      if ($this->getMetod() !== 'GET' && $data !== null) {
        $request = $request->withBody(
          $this->streamFactory()->createStream(
            is_string($data) ? $data : http_build_query($data)
          )
        );
      }
      // Make a request.
      $response = $this->client->sendRequest($request);
      $content = $response->getBody()->getContents();
      $xml = @simplexml_load_string($content);
      // Handle errors.
      if ($response->getStatusCode() === 400 && !isset($xml->error) && !isset($xml->consignment->errors->error)) {
        throw new CargonizerException((string) $content, $request);
      }
      elseif (isset($xml->error)) {
        throw new CargonizerException((string) $xml->error, $request);
      }
      elseif (isset($xml->consignment->errors->error)) {
        throw new CargonizerException((string) $xml->consignment->errors->error, $request);
      }

      // Return XML response.
      return $xml;
    } catch (RequestException $e) {
      throw $e;
    } catch (\Exception $e) {
      throw new \Exception($e->getMessage(), $e->getCode(), $e);
    }
  }

  /**
   * @return \Psr\Http\Message\RequestFactoryInterface
   */
  protected function requestFactory() {
    if (!isset($this->requestFactory)) {
      $this->requestFactory = Psr17FactoryDiscovery::findRequestFactory();
    }
    return $this->requestFactory;
  }

  /**
   * @return \Psr\Http\Message\StreamFactoryInterface
   */
  protected function streamFactory() {
    if (!isset($this->streamFactory)) {
      $this->streamFactory = Psr17FactoryDiscovery::findStreamFactory();
    }
    return $this->streamFactory;
  }

}