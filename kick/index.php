<?php

// Stream TSV or CSV file contains list of URL redirection data
if (
    is_file($f = LOT . DS . 'page' . DS . 'kick.csv') ||
    is_file($f = LOT . DS . 'page' . DS . 'kick.tsv')
) {
    // Get current URL path to be redirected
    $path = $url->path . $url->query . $url->hash;
    // Stream now!
    if (false !== ($h = fopen($f, 'r'))) {
        $csv = 'csv' === pathinfo($f, PATHINFO_EXTENSION);
        while (false !== ($v = fgetcsv($h, 1024, $csv ? ',' : "\t"))) {
            if ($path === $v[0] && !empty($v[1])) {
                fclose($h);
                header('location: ' . URL::long($v[1], false));
                exit;
            }
        }
        fclose($h);
    }
}
