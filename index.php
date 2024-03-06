<?php

require_once 'classes.php';
require_once 'functions.php';


$card = new Card(1234432156788131, 1209, 1500);
$user = new User('Denis', $card);
$bankomat = new Bankomat(1000);


$user->insertCard($bankomat);

$user->enterPin($bankomat, readline());

$user->chooseOption($bankomat);

