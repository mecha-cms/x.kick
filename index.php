<?php

// Stream TSV or CSV file contains list of URL redirection data
if (
    is_file($file = LOT . D . 'page' . D . 'kick.csv') ||
    is_file($file = LOT . D . 'page' . D . 'kick.tsv')
) {
    // Get current URL path to be redirected
    $path = $url->path . $url->query . $url->hash;
    // Stream now!
    if (false !== ($h = fopen($file, 'r'))) {
        $csv = 'csv' === pathinfo($file, PATHINFO_EXTENSION);
        while (false !== ($v = fgetcsv($h, 1024, $csv ? ',' : "\t"))) {
            if ($path === $v[0] && !empty($v[1])) {
                fclose($h);
                header('location: ' . long($v[1]));
                exit;
            }
        }
        fclose($h);
    }
}