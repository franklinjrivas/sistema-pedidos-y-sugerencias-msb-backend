<?php

namespace App\Taps;

use App\Exceptions\BusinessLogicException;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\LogRecord;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Throwable;

class LogToDatabaseTap
{
    /**
     * Receives the Illuminate\Log\Logger (wrapper). We obtain the Monolog logger internals
     * and push a handler compatible with Monolog 3 (LogRecord).
     *
     * @param  mixed  $logger  (Illuminate\Log\Logger)
     * @return void
     */
    public function __invoke($logger): void
    {
        // $logger is Illuminate\Log\Logger; get the Monolog\Logger instance
        $monolog = method_exists($logger, 'getLogger') ? $logger->getLogger() : $logger;

        $monolog->pushHandler(new class extends AbstractProcessingHandler {
            protected function write(LogRecord $record): void
            {
                try {
                    $e = $record->context['exception'] ?? null;

                    if ($e instanceof BusinessLogicException) {
                        return;
                    }

                    $file = $record->context['file']  ?? null;
                    $line = $record->context['line']  ?? null;
                    $trace = $record->context['trace'] ?? null;
                    $prettyTrace = null;

                    if ($e instanceof Throwable) {
                        $file = $file ?? $e->getFile();
                        $line = $line ?? $e->getLine();

                        $trace = $e->getTrace();

                        $trace = array_map(static function (array $frame): array {
                            unset($frame['args']);
                            return $frame;
                        }, $trace);

                        array_unshift($trace, [
                            'file' => $e->getFile(),
                            'line' => $e->getLine(),
                            'class' => null,
                            'type' => null,
                            'function' => null,
                        ]);

                        $prettyTrace = array_values(array_map(
                            static function (int $idx, array $f): string {
                                $fFile = $f['file'] ?? '[internal function]';
                                $fLine = (int)($f['line'] ?? 0);
                                $cls = $f['class'] ?? '';
                                $typ = $f['type'] ?? '';
                                $fun = $f['function'] ?? '{main}';
                                $call = $cls ? ($cls . $typ . $fun) : $fun;

                                return sprintf('#%d %s(%d): %s()', $idx, $fFile, $fLine, $call);
                            },
                            array_keys($trace),
                            $trace
                        ));
                    }

                    $audit = [
                        'level' => strtolower($record->level->getName()),
                        'message' => (string) $record->message,
                        'file' => $file,
                        'line' => $line,
                        'trace' => $trace,
                        'pretty_trace' => $prettyTrace,
                        'timestamp' => now()->toDateTimeString(),
                    ];

                    $payload = [
                        'uuid' => (string) Str::uuid(),
                        'siglas_sistema' => config('environment.SISTEMA_MSB', null),
                        'audit' => $audit,
                    ];

                    Http::withBasicAuth(
                        config('environment.USER_BASIC_AUTH'),
                        config('environment.PWD_BASIC_AUTH')
                    )
                        ->timeout(3)
                        ->post(config('environment.URL_SAVE_AUDITORIA_ERROR_API'), $payload);
                } catch (\Throwable $e) {
                    // Intencionalmente silencioso: no relanzar ni volver a loguear para evitar bucles infinitos
                }
            }
        });
    }
}
