<?php

require __DIR__ . '/../vendor/autoload.php';

use raphievila\Tools\Units;

$u = new Units();
$u::$format = 'cm';

echo $u->returnDimensions(2.54);
