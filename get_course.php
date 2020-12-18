<?php

require_once 'vendor/autoload.php';

use App\Currency as Currency;

$shortopts  = "";
$longopts  = [
    "from:",
    "to:"
];
$options = getopt($shortopts, $longopts);

$currency = new Currency($options);
echo $currency->calcCurrency();
echo "\n";
