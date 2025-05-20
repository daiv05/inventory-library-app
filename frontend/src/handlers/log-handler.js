// src/handlers/log-handler.js

export default {
    install(app) {
        app.config.errorHandler = (err, vm, info) => {
            // Loguea el error en la consola del navegador
            console.error('Error capturado:', err, info);

            // Aquí puedes enviar el error a un servicio externo si lo deseas

            // Opcional: mostrar una notificación al usuario
            // Por ejemplo, usando un sistema de notificaciones global
            // app.config.globalProperties.$notify({ type: 'error', message: 'Ocurrió un error inesperado.' });
        };
    }
};
