<?php
class User
{
    public string $name;
    public Card $card;
    public function __construct(string $name, Card $card)
    {
        $this->name = $name;
        $this->card = $card;

    }
    public function insertCard(Bankomat $bankomat): void
    {
        $bankomat->takeCard($this->card);
    }
    public function enterPin(Bankomat $bankomat, int $pin): void
    {
       $bankomat->takePin($pin);
    }
    public function chooseOption()
    {

    }
}
class Card
{
    private int $number;
    private int $pin;
    private int $cardBalance;
    public function __construct(int $number, int $pin, int $cardBalance)
    {
        $this->number = $number;
        $this->pin = $pin;
        $this->cardBalance = $cardBalance;
    }
    public function getNumber(): int
    {
        return $this->number;
    }
    public function getPin(): int
    {
        return $this->pin;
    }
    public function getCardBalance(): int
    {
        return $this->cardBalance;
    }
}
class BankomatStatusOutput
{
    private Bankomat $bankomat;
    public function __construct(Bankomat $bankomat)
    {
        $this->bankomat = $bankomat;
    }
    public function output(int $step): void
    {
        switch ($step) {
            case Bankomat::STEP_AWAIT_ENTER_CARD:
                echo "Insert card " . PHP_EOL;
                break;
            case Bankomat::STEP_AWAIT_ENTER_PIN:
                echo "Enter your Pin-Code: " . PHP_EOL;
                break;
            case Bankomat::STEP_VALID_PIN:
                echo "Choose option: Check balance, Withdraw or Deposit money " . PHP_EOL;
                break;
            case Bankomat::STEP_NOT_VALID_PIN:
                echo "Wrong pin code. Try again " . PHP_EOL;
                break;
            case Bankomat::STEP_CHECK_BALANCE:
                echo "Your balance is {$this->bankomat->checkBalance()}" . PHP_EOL;
                break;
            case Bankomat::STEP_WITHDRAW:
                echo "Enter the amount you want to withdraw " . PHP_EOL;
                break;
            case Bankomat::STEP_DEPOSIT:
                echo "You can put no more than 5,000 on the card at a time " . PHP_EOL;
                break;
        }
    }
}


class Bankomat
{
    public const STEP_AWAIT_ENTER_CARD = 1;
    public const STEP_AWAIT_ENTER_PIN = 2;
    public const STEP_VALID_PIN = 3;
    public const STEP_NOT_VALID_PIN = 4;
    public const STEP_CHECK_BALANCE = 5;
    public const STEP_WITHDRAW = 6;
    public const STEP_DEPOSIT = 7;
    private BankomatStatusOutput $bankomatStatusOutput;
    private int $step = self::STEP_AWAIT_ENTER_CARD;
    public ?Card $card = null;
    private int $bankomatBalance = 5000;
    public function __construct()
    {
        $this->bankomatStatusOutput = new BankomatStatusOutput();
    }
    public function takeCard(Card $card): self
    {
        $this->card = $card;
        $this->changeStep(self::STEP_AWAIT_ENTER_PIN);
        return $this;
    }
    public function checkValidPin($pin): static
    {
        if($pin === $this->card->getPin())
            $this->changeStep(self::STEP_VALID_PIN);
        else
            $this->changeStep(self::STEP_NOT_VALID_PIN);
        return $this;
    }
    public function changeStep(int $step): void
    {
        $this->step = $step;
        $this->bankomatStatusOutput->output($this->step);
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
    public function getStep(): int
    {
        return $this->step;
    }
    public function takePin(int $pin): void
    {
        $this->checkValidPin($pin);
    }
    private function bankomatBalance()
    {

    }
}

