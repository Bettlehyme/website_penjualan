<?php

if (!function_exists('rupiah')) {
    /**
     * Format number to Indonesian Rupiah currency
     *
     * @param  float|int  $value
     * @param  bool $withRp
     * @return string
     */
    function rupiah($value, $withRp = true)
    {
        $formatted = number_format($value, 0, ',', '.'); // 1000000 => 1.000.000
        return $withRp ? 'Rp ' . $formatted : $formatted;
    }
}
