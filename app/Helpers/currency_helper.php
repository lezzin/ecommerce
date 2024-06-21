<?php

/**
 * Format number to BRL currency
 */
function format_currency($number): string
{
    return 'R$' . number_format($number, 2, ',', '.');
}