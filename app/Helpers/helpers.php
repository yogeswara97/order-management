<?php

if (!function_exists('format_currency')) {
    /**
     * Format a number as currency.
     *
     * @param float $amount
     * @param string $currency
     * @param string $locale
     * @return string
     */
    function format_currency(float $amount, string $currency = 'USD', string $locale = 'en_US'): string
    {
        $formatter = new \NumberFormatter($locale, \NumberFormatter::CURRENCY);
        return $formatter->formatCurrency($amount, $currency);
    }
}
