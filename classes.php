<?php


class User
{
    public string $name;

    public function __construct(string $name)
    {
        $this->name = $name;

    }
    public function insertCard(): void
    {
        echo $this->name . " insert card";
    }

    public function enterPin()
    {

    }
    public function chooseOption()
    {

    }

}
class Card
{
    public int $cardNumber;
    public int $pin;
    public array $cardPinMap = [
      1234432156788765 => 2345,
      6789987654322345 => 1234,
    ];
    public function __construct(int $cardNumber)
    {
        $this->cardNumber = $cardNumber;
        $this->pin = self::$cardNumber
    }
}


class Bankomat
{
    public int $balance;
    public function enterPin(): void
    {
        echo "Enter your Pin-Code";
    }
    public function checkValidPin()
    {

    }
    public function checkBalance()
    {

    }
    public function withdraw()
    {

    }
    public function deposit()
    {

    }

}

