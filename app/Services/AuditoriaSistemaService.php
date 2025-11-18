<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;

class AuditoriaSistemaService
{
    private HttpService $httpService;
    private string $sistema;
    private array $accionesPermitidas;
    private string $url_save_auditoria_endpoint_api;
    private string $url_save_auditoria_dml_api;

    public function __construct(HttpService $httpService)
    {
        $this->httpService = $httpService;
        $this->sistema = config('environment.SISTEMA_MSB');
        $this->accionesPermitidas = ['I', 'U', 'D'];
        $this->url_save_auditoria_endpoint_api = config('environment.URL_SAVE_AUDITORIA_ENDPOINT_API');
        $this->url_save_auditoria_dml_api = config('environment.URL_SAVE_AUDITORIA_DML_API');
    }

    public function save_log_auditoria_endpoint(int $statusCode, array $responseData): array
    {
        $jwtToken = request()->JWT_token;
        $headers = $this->httpService->bearer_header($jwtToken);
        $audit = [
            ...getAudit(),
            'method' => request()->method(),
            'payload' => getPayload(),
            'status_code' => $statusCode,
            'response' => $responseData,
        ];

        $params = [
            'json' => [
                'siglas_sistema' => $this->sistema,
                'audit' => $audit,
            ],
        ];

        return $this->httpService->sendRequest('post', $this->url_save_auditoria_endpoint_api, $params, $headers);
    }

    public function save_log_auditoria_dml(?Model $modelo_before, ?Model $modelo_after, ?array $where_clause, string $action): array
    {
        if (!$modelo_before && !$modelo_after) {
             validationError('Error en el proceso de Auditoría');
        }

        $jwtToken = request()->JWT_token ?? null;

        if (!$jwtToken) {
             validationError('Token de autenticación no proporcionado.');
        }

        $headers = $this->httpService->bearer_header($jwtToken);

        $action = strtoupper($action);

        if (!in_array($action, $this->accionesPermitidas, true)) {
             validationError("Acción no válida: {$action}");
        }

        $modeloBase = $modelo_before ?? $modelo_after;
        [$schema, $table] = $this->getSchemaTable($modeloBase);

        if (!$table) {
             validationError('No se pudo determinar la tabla asociada al modelo.');
        }

        $connection = $modeloBase->getConnection();
        $config = $connection->getConfig();

        $audit = [
            ...getAudit(),
            'db_ip' => $config['host'] ?? null,
            'db_connection' => $connection->getDriverName() ?? null,
            'db_name' => $config['database'] ?? null,
            'db_schema' => $schema,
            'db_table' => $table,
            'dml_action' => $action,
            'where_clause' => $where_clause ?? null,
            'row_before' => $modelo_before?->toArray(),
            'row_after' => $modelo_after?->toArray(),
        ];

        $params = [
            'json' => [
                'siglas_sistema' => $this->sistema,
                'audit' => $audit,
            ],
        ];

        return $this->httpService->sendRequest('post', $this->url_save_auditoria_dml_api, $params, $headers);
    }

    private function getSchemaTable(?Model $modelo): ?array
    {
        if (!$modelo) {
            return [null, null];
        }

        $getTable = $modelo->getTable();

        if (strpos($getTable, '.') === false) {
            return [null, $getTable];
        }

        $parts = explode('.', $getTable);
        $table = array_pop($parts);
        $schema = implode('.', $parts);

        return [$schema ?: null, $table];
    }
}
