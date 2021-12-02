<?php

define('DB_USER', getenv('MYSQL_USER', true));
define('DB_NAME', getenv('MYSQL_DATABASE', true));
define('DB_PASS', getenv('MYSQL_PASSWORD', true));
define('DB_HOST', 'db');
define('DB_PORT', '3306');

# define main directories
define('APP_DIR', __DIR__ . '/..');
define('UPLOADS_DIR', APP_DIR . '/uploads');
