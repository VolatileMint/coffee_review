<?php

declare(strict_types=1);
$ym = "2020-05";
$day = 1;
echo date('Y-m-d', strtotime($ym . "-" . $day));