<?php

require_once 'classes.php';
require_once 'functions.php';



$user = new User('Denis', 1234432156788765);
$card = new Card(1234432156788765, 1209, 1500);
$bankomat = new Bankomat(5000);

$user->insertCard($bankomat);
$bankomat->takeCard($card);
$user->enterPin($bankomat, 1209);
$bankomat->takePin($card->getPin());
$user->chooseOption($bankomat);
$bankomat->checkBalance();
$bankomat->deposit(1000);
$bankomat->withdraw(1000);