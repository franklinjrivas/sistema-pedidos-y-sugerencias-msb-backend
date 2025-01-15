# Cambiar el nombre del proyecto clonado

Cuando clones este proyecto y necesites usarlo como base para un nuevo desarrollo, sigue estos pasos para cambiar el nombre del proyecto:

---

## 1. Actualiza el nombre en `composer.json`
1. Abre el archivo `composer.json`.
2. Busca la propiedad `"name": "skeleton-msb-backend"`.
3. Reemplaza `skeleton-msb-backend` por el nuevo nombre del proyecto, por ejemplo: `sistema-planillas-backend`.

---

## 2. Renombra la carpeta del proyecto (opcional)
1. Si lo deseas, también puedes cambiar el nombre de la carpeta del proyecto a `sistema-planillas-backend`.

---

## 3. Actualiza el archivo `.env`
1. Abre el archivo `.env` en la raíz del proyecto.
2. Modifica las siguientes variables según corresponda:
   - `APP_NAME`: Cambia el nombre de la aplicación.

---

## 4. Limpia las cachés de configuración
1. Ejecuta los siguientes comandos para asegurarte de que los cambios en `.env` y otras configuraciones sean aplicados:
   ```bash
   php artisan config:clear
   php artisan cache:clear
   php artisan config:cache
   ```

---

## 5. Instala las dependencias
1. Ejecuta el siguiente comando para instalar las dependencias del proyecto:
   ```bash
   composer install
   ```

---

## 6. Genera la clave de la aplicación
1. Ejecuta el comando:
   ```bash
   php artisan key:generate
   ```

---

## 7. Verifica que el proyecto se ejecuta correctamente
1. Inicia el servidor de desarrollo con el comando:
   ```bash
   php artisan serve
   ```
2. Accede al proyecto en tu navegador usando la URL proporcionada (por defecto, `http://127.0.0.1:8000`).

---

## 8. Opcional: Limpia el caché si encuentras problemas
1. Si experimentas problemas al cambiar el nombre del proyecto, ejecuta:
   ```bash
   php artisan cache:clear
   php artisan route:clear
   php artisan view:clear
   ```

---

## 9. Configuración del archivo `.env` para la integración con el Servicio de Autenticación
1. Modifica el archivo `.env` para incluir las credenciales de autenticación necesarias:
   - `USER_BASIC_AUTH` y `PWD_BASIC_AUTH`: No realices cambios en estas variables.
   - `GOOGLE_RECAPTCHA_KEY_PRIVATE`: Solicita al área de OGD las credenciales para reCaptcha en la consola oficial: [Google Recaptcha](https://www.google.com/recaptcha/about/) y actualiza el valor de esta variable con la clave privada obtenida. 

2. Abre el archivo `database/data_seeds/credenciales_for_auth_basic_api.json` y modifica las credenciales por unas nuevas. Puedes generar contraseñas seguras utilizando esta herramienta: [Password Generator](https://www.lastpass.com/es/features/password-generator)

3. Asegúrate de que las credenciales del archivo `database/data_seeds/credenciales_for_auth_basic_api.json` coincidan con los valores valores de las propiedades `USER_AUTH_BASIC` y `PWD_AUTH_BASIC` del Frontend.
