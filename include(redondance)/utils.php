<?php
function formatDatetimeFr(string $datetime): string {
    $timestamp = strtotime($datetime);
    if ($timestamp === false) {
        return $datetime;
    }
    return date('d/m/Y à H\hi', $timestamp);
}
?>
