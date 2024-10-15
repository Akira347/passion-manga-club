<?php

function redirectToUrl($url)
{
    header("Location:{$url}");
    exit;
}

function debugToConsole($data) {
    $output = $data;
    if (is_array($output)) {
        $output = implode(',', $output);
    }

    echo "<script>console.log('Debug Objects : " . $output . "' );</script>";
}

?>