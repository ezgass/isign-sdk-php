# iSign.io API PHP Client

## How to start?

Check integration tests under `tests/Integration` for library use cases.

## Logging requests

### Log by printing output to screen

Set second parameter to `true`.

    $client = Isign\Client::create([
        'apiKey' => 'xxxxxx',
        'sandbox' => true,
    ], true);


### Custom PSR-3 logger

    use Monolog\Handler\StreamHandler;
    use Monolog\Logger;

    $log = new Logger('requests');
    $log->pushHandler(new StreamHandler(__DIR__ . '/path/to/info.log', Logger::INFO));

    $client = Isign\Client::create([
        'apiKey' => 'xxxxxx',
        'sandbox' => true,
    ], $log);

Read more:

http://www.php-fig.org/psr/psr-3/
https://github.com/guzzle/log-subscriber
https://github.com/Seldaek/monolog


## Debugging

To dig more into occured error use following methods. A

    echo (string) $exception->getMessage()
    echo (string) $exception->getPrevious()->getResponse()
    var_dump( $exception->getResponseData() )

Available on all exception classes except `UnexpectedError` and `QueryValidator`.

## Develop

Whole testsuite including integrational tests

    phpunit

Don't forget to define `SANDBOX_API_KEY` in your phpunit.xml.


Running unit tests only:

    phpunit --testsuite=Unit

Running integrational tests only:
    
    phpunit --testsuite=Integration

Running single testcase:

    phpunit tests/Integration/MobileSignTest.php
