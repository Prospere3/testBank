<?php

require_once 'classes.php';
require_once 'functions.php';


$card = new Card(1234432156788765, 1209, 1500);
$user = new User('Denis', $card);
$bankomat = new Bankomat(1000);


$user->insertCard($bankomat);
$bankomat->takeCard($card);
$user->enterPin($bankomat, 1209);
$bankomat->takePin($card->getPin());
$user->chooseOption($bankomat);
$bankomat->checkBalance();
$bankomat->deposit(1000);
$bankomat->withdraw(1000);