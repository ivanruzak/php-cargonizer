<?php

namespace zaporylie\Cargonizer\Data;

class Sender extends Address {

  /**
   * @var \zaporylie\Cargonizer\Data\Plan
   */
  protected $plan;

  /**
   * @var string
   */
  protected $contactPerson;

  /**
   * @var string
   */
  protected $externalNumber;

  /**
   * @var int
   */
  protected $id;

  /**
   * @var string
   */
  protected $returnAddress1;

  /**
   * @var string
   */
  protected $returnAddress2;

  /**
   * @var string
   */
  protected $returnCity;

  /**
   * @var string
   */
  protected $returnCountry;

  /**
   * @var string
   */
  protected $returnPostcode;

  /**
   * @var string
   */
  protected $label;

  /**
   * @return \zaporylie\Cargonizer\Data\Plan
   */
  public function getPlan() {
    return $this->plan;
  }

  /**
   * @return string
   */
  public function getContactPerson() {
    return $this->contactPerson;
  }

  /**
   * @return string
   */
  public function getExternalNumber() {
    return $this->externalNumber;
  }

  /**
   * @return int
   */
  public function getId() {
    return $this->id;
  }

  /**
   * @return string
   */
  public function getReturnAddress1() {
    return $this->returnAddress1;
  }

  /**
   * @return string
   */
  public function getReturnAddress2() {
    return $this->returnAddress2;
  }

  /**
   * @return string
   */
  public function getReturnCity() {
    return $this->returnCity;
  }

  /**
   * @return string
   */
  public function getReturnCountry() {
    return $this->returnCountry;
  }

  /**
   * @return string
   */
  public function getReturnPostcode() {
    return $this->returnPostcode;
  }

  /**
   * @return string
   */
  public function getLabel() {
    return $this->label;
  }

  /**
   * @param \zaporylie\Cargonizer\Data\Plan $plan
   */
  public function setPlan(Plan $plan) {
    $this->plan = $plan;
  }

  /**
   * @param string $contactPerson
   */
  public function setContactPerson($contactPerson) {
    $this->contactPerson = $contactPerson;
  }

  /**
   * @param string $externalNumber
   */
  public function setExternalNumber($externalNumber) {
    $this->externalNumber = $externalNumber;
  }

  /**
   * @param int $id
   */
  public function setId($id) {
    $this->id = $id;
  }

  /**
   * @param string $label
   */
  public function setLabel($label) {
    $this->label = $label;
  }

  /**
   * @param string $returnAddress1
   */
  public function setReturnAddress1($returnAddress1) {
    $this->returnAddress1 = $returnAddress1;
  }

  /**
   * @param string $returnAddress2
   */
  public function setReturnAddress2($returnAddress2) {
    $this->returnAddress2 = $returnAddress2;
  }

  /**
   * @param string $returnCity
   */
  public function setReturnCity($returnCity) {
    $this->returnCity = $returnCity;
  }

  /**
   * @param string $returnCountry
   */
  public function setReturnCountry($returnCountry) {
    $this->returnCountry = $returnCountry;
  }

  /**
   * @param string $returnPostcode
   */
  public function setReturnPostcode($returnPostcode) {
    $this->returnPostcode = $returnPostcode;
  }

  /**
   * {@inheritdoc}
   * @param \SimpleXMLElement $xml
   * @param \zaporylie\Cargonizer\Data\AddressInterface|null $address
   */
  public static function fromXML(\SimpleXMLElement $xml, AddressInterface $address = NULL) {
    $sender = new Sender();
    parent::fromXML($xml, $sender);
    $sender->setPlan(Plan::fromXML($xml->{'plan'}));
    $sender->setContactPerson((string) $xml->{'contact-person'});
    $sender->setExternalNumber((string) $xml->{'external-number'});
    $sender->setId((int) $xml->{'id'});
    $sender->setLabel((string) $xml->{'label'});
    $sender->setReturnAddress1((string) $xml->{'return-address1'});
    $sender->setReturnAddress2((string) $xml->{'return-address2'});
    $sender->setReturnCity((string) $xml->{'return-city'});
    $sender->setReturnCountry((string) $xml->{'return-country'});
    $sender->setReturnPostcode((string) $xml->{'return-postcode'});
    return $sender;
  }

  /**
   * {@inheritdoc}
   */
  public function toXML(\SimpleXMLElement $xml) {
    $sender = $xml->addChild('sender');
    parent::toXML($sender);
    $sender->addChild('contact-person', $this->getContactPerson());
    $sender->addChild('external-number', $this->getContactPerson());
    $sender->addChild('id', $this->getContactPerson())->addAttribute('type', 'integer');
    $sender->addChild('return-address1', $this->getReturnAddress1());
    $sender->addChild('return-address2', $this->getReturnAddress2());
    $sender->addChild('return-city', $this->getReturnCity());
    $sender->addChild('return-country', $this->getReturnCountry());
    $sender->addChild('return-postcode', $this->getReturnPostcode());
    $this->getPlan()->toXML($sender);
    return $xml;
  }
}
