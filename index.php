<?php

define('START_TIME', microtime(true));
define('ROOT_DIR', __DIR__);
require 'core/main/Kernel.php';
core\main\Kernel::init();
