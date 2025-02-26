<?php

declare(strict_types=1);

use Hyperf\Engine\DefaultOption;

! defined('BASE_PATH') && define('BASE_PATH', dirname(__DIR__));
! defined('CURRENT_VERSION') && define('CURRENT_VERSION', '0.1.0');
! defined('DEFAULT_APP_ENV') && define('DEFAULT_APP_ENV', 'dev');
! defined('DEFAULT_APP_NAME') && define('DEFAULT_APP_NAME', 'template_name');
! defined('DEFAULT_TIMEZONE') && define('DEFAULT_TIMEZONE', 'UTC');
! defined('SWOOLE_HOOK_FLAGS') && define('SWOOLE_HOOK_FLAGS', DefaultOption::hookFlags());
