<?php

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| The first thing we will do is create a new Laravel application instance
| which serves as the "glue" for all the components of Laravel, and is
| the IoC container for the system binding all of the various parts.
|
*/

if (strpos($_SERVER['HTTP_HOST'], '7.local')){
    define("SITE", '7.local');
    define("PATH", 'new');
}
else{
    define("SITE", '');
    define("PATH", '');
}


$app = new Illuminate\Foundation\Application(
    $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
);

/*
|--------------------------------------------------------------------------
| Bind Important Interfaces
|--------------------------------------------------------------------------
|
| Next, we need to bind some important interfaces into the container so
| we will be able to resolve them when needed. The kernels serve the
| incoming requests to this application from both the web and CLI.
|
*/

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    App\Http\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

/*
|--------------------------------------------------------------------------
| Return The Application
|--------------------------------------------------------------------------
|
| This script returns the application instance. The instance is given to
| the calling script so we can separate the building of the instances
| from the actual running of the application and sending responses.
|
*/

function mb_ucfirst($string, $encoding = 'UTF-8') {
    return mb_strtoupper(mb_substr($string, 0, 1, $encoding), $encoding) .
        mb_substr($string, 1, null, $encoding);
}

function formatPhone($phone) {
    // Удаляем всё, кроме цифр
    $digits = preg_replace('/\D+/', '', $phone);

    // Проверим длину
    if (strlen($digits) === 11 && $digits[0] == '7') {
        return '+7 (' . substr($digits, 1, 3) . ') ' . substr($digits, 4, 3) . '-' . substr($digits, 7, 2) . '-' . substr($digits, 9, 2);
    }

    // Если невалидный — вернем как есть
    return $phone;
}

return $app;
