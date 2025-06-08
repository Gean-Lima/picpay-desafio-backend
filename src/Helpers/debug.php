<?php

function dd() {
    $args = func_get_args();

    foreach ($args as $arg) {
        echo '<pre><code>';
        var_dump($arg);
        echo '</code></pre>';
    }

    die;
}
