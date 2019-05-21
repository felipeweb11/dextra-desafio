<?php

use Money\Currencies\ISOCurrencies;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money;

function formatMoney(Money $money, $locale = 'pt_BR'): string {
    $numberFormatter = new NumberFormatter($locale, NumberFormatter::CURRENCY);
    $moneyFormatter = new IntlMoneyFormatter($numberFormatter, new ISOCurrencies);
    return $moneyFormatter->format($money);
}