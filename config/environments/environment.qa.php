<?php
    $APP_URL = 'http://qa-apipedidos-sugerencias.msb.gob.pe';
    $URL_FRONTEND = 'http://qa-pedidos-sugerencias.msb.gob.pe';
    $HOST_INTRANET_MSB = 'https://qa-intranet.msb.gob.pe';
    $HOST_EXTRANET_MSB = 'https://qa-extranet.msb.gob.pe';
    $BASE_URL_AUTH = 'http://qa-apiautenticacion.msb.gob.pe';

    return [
        'SISTEMA_MSB' => 'SISPS',
        'APP_URL' => $APP_URL,
        'URL_FRONTEND' => $URL_FRONTEND,
        'HOST_INTRANET_MSB' => $HOST_INTRANET_MSB,
        'HOST_EXTRANET_MSB' => $HOST_EXTRANET_MSB,
        'BASE_URL_AUTH' => $BASE_URL_AUTH,
        'USER_BASIC_AUTH' => '4UTH3NT1C4C10N@MSB*2024_',
        'PWD_BASIC_AUTH' => '*mUnC!:SOH251MzX@nkU9Ann3',
        'GOOGLE_RECAPTCHA_VERIFY_URL' => 'https://www.google.com/recaptcha/api/siteverify',
        'GOOGLE_RECAPTCHA_KEY_PRIVATE' => '6Lc1BcsrAAAAALttCqPjkW01gPlEdupQRIC1LsVs',
        'MIN_SCORE_RECAPTCHA' => 0.5,

        // AUTH
        'URL_AUTH_LOGIN_API' => $BASE_URL_AUTH.'/api/auth/login',
        'URL_AUTH_LOGOUT_API' => $BASE_URL_AUTH.'/api/auth/logout',
        'URL_VALIDATE_JWT_API' => $BASE_URL_AUTH.'/api/auth/validate-jwt',
        'URL_CHECK_INTRANET_URL_API' => $BASE_URL_AUTH.'/api/auth/check-intranet-url',
        'URL_USER_MAGIC_AD_MATCH_API' => $BASE_URL_AUTH.'/api/auth/user-magic-ad-match',

        // HOME
        'URL_ROLES_USER_X_SISTEMA_API' => $BASE_URL_AUTH.'/api/home/roles-by-user-sistema',
        'URL_ROLES_GENERATE_MENU_API' => $BASE_URL_AUTH.'/api/home/generate-menu',
        'URL_CHANGE_ROL_API' => $BASE_URL_AUTH.'/api/home/change-rol',

        // EMAIL
        'URL_SEND_MAIL_INTRANET' => $HOST_INTRANET_MSB.'/intranet/plataforma-digital-servicios/env',

        // FILE
        'URL_EXTENSIONES_METADATOS_API' => $BASE_URL_AUTH.'/api/extensiones-metadatos',
    ];
