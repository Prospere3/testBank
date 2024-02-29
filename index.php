<?php
require_once 'classes.php';

$bankomat = new Bankomat();

$card = new Card(1595959595959, 495);

$user = new User('Denis', $card);

$user->insertCard($bankomat);
