# BotRate
[![Build Status](https://travis-ci.org/ChiVincent/BotRate.svg?branch=master)](https://travis-ci.org/ChiVincent/BotRate)

A library to get live exchange rate from Taiwan Bank. 

## Usage

Install: 
```
composer require chivincent/bot-rate
```

Usage: 
```php
<?php

require __DIR__.'/vendor/autoload.php'; 

$botRate = new Chivincent\BotRate\BotRate();
$botRate->fetch()->toJson(); // json string
```