<?php

$env = env('APP_ENV', 'local');

return require __DIR__ . "/environments/environment.$env.php";
