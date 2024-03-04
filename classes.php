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
    public function chooseOption(Bankomat $bankomat): void
    {
        $option = readline();
        switch ($option) {
            case 1:
                $bankomat->checkBalance();
                break;
            case 2:
                $bankomat->withdraw();
                break;
            case 3:
                $bankomat->deposit(readline());
                break;
            default:
                $bankomat->chooseNotValidOption();
                break;
        }
    }
}
class Card
{
    private int $number;
    private int $pin;
    private int $balance;
    public function __construct(int $number, int $pin, int $balance)
    {
        $this->number = $number;
        $this->pin = $pin;
        $this->balance = $balance;
    }
    public function getNumber(): int
    {
        return $this->number;
    }
    public function getPin(): int
    {
        return $this->pin;
    }
    public function getBalance(): int
    {
        return $this->balance;
    }
    public function setBalance(int $balance): void
    {
        $this->balance = $balance;
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
                echo "1. Check Balance" . PHP_EOL;
                echo "2. Withdraw money" . PHP_EOL;
                echo "3. Deposit money" . PHP_EOL;
                echo "Choose your option number: " . PHP_EOL;
                break;
            case Bankomat::STEP_NOT_VALID_PIN:
                echo "Wrong pin code. Try again " . PHP_EOL;
                break;
            case Bankomat::STEP_CHECK_BALANCE:
                echo "Your balance is: " . PHP_EOL;
                break;
            case Bankomat::STEP_WITHDRAW:
                echo "Enter the amount you want to withdraw " . PHP_EOL;
                break;
            case Bankomat::STEP_DEPOSIT:
                echo "You can put your money " . PHP_EOL;
                break;
            case Bankomat::STEP_NOT_VALID_OPTION:
                echo "Invalid option selected " . PHP_EOL;
                break;
            case Bankomat::STEP_NOT_MONEY_ON_CARD:
                echo "Not enough money on card for withdraw " . PHP_EOL;
                break;
            case Bankomat::STEP_NOT_MONEY_ON_BANKOMAT:
                echo "Not enough money in bankomat for withdraw " . PHP_EOL;
                break;
            case Bankomat::STEP_VALID_WITHDRAW:
                echo "Take your money {$this->bankomat->withdraw()}" . PHP_EOL;
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
    public const STEP_NOT_VALID_OPTION = 8;
    public const STEP_NOT_MONEY_ON_CARD = 9;
    public const STEP_NOT_MONEY_ON_BANKOMAT = 10;
    public const STEP_VALID_WITHDRAW = 11;
    private BankomatStatusOutput $bankomatStatusOutput;
    private int $step = self::STEP_AWAIT_ENTER_CARD;
    public ?Card $card = null;
    private int $balance;
    public function __construct(int $balance)
    {
        $this->bankomatStatusOutput = new BankomatStatusOutput();
        $this->balance = $balance;
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
        $this->bankomatStatusOutput->output($this->getStep());
    }
    public function checkBalance(): int
    {
        $this->changeStep(self::STEP_CHECK_BALANCE);
        $balance = $this->card->getBalance();
        return $balance;
    }
    public function withdraw($amount): void
    {
        $this->changeStep(self::STEP_WITHDRAW);
        $cardBalance = $this->card->getBalance();
        $bankBalance = $this->balance;
        if($amount > $cardBalance)
            $this->changeStep(self::STEP_NOT_MONEY_ON_CARD);
        elseif ($amount >$bankBalance)
            $this->changeStep(self::STEP_NOT_MONEY_ON_BANKOMAT);
        else
            $newCardBalance = $cardBalance - $amount;
            $newBankBalance = $bankBalance - $amount;
            $this->card->setBalance($newCardBalance);
            $this->setBalance($newBankBalance);
            $this->changeStep(self::STEP_VALID_WITHDRAW);

    }
    public function deposit(int $amount): void
    {
        $this->changeStep(self::STEP_DEPOSIT);
        $currentCardBalance = $this->card->getBalance();
        $currentBankBalance = $this->balance;
        $newCardBalance = $currentCardBalance + $amount;
        $newBankBalance = $currentBankBalance + $amount;
        $this->card->setBalance($newCardBalance);
        $this->setBalance($newBankBalance);
    }
    public function getStep(): int
    {
        return $this->step;
    }
    public function takePin(int $pin): void
    {
        $this->checkValidPin($pin);
    }
    public function chooseNotValidOption(): void
    {
        $this->changeStep(self::STEP_NOT_VALID_OPTION);
    }
    public function setBalance(int $balance): void
    {
        $this->balance = $balance;
    }
}

