# shopfx
Sistema de gestión y organización de archivos PHP para el proyecto ShopFX  
# ShopFX
 Sistema de gestión y organización de archivos PHP para el proyecto ShopFX
 ## 📌 Autor
 Carlos Ubilla Reyes
 ## 🎯 Propósito del proyecto
 Este proyecto automatiza la organización de archivos PHP y verifica su integridad mediante el algoritmo de hash SHA-256. Garantiza que los archivos copiados sean idénticos a los originales.
 ## 🚀 Cómo usar el programa
 1. Ubícate en la carpeta del proyecto
 2. Ejecuta en la terminal:
    python organizador_php.py
 ## 📁 Estructura del proyecto
 - organizador_php.py → Script principal
 - config/public/ → Archivos PHP del sistema
 - README.md → Este archivo
 ## 🔒 Seguridad en el desarrollo
 ### Vulnerabilidades identificadas:
 1. *Inyección SQL:* Se evita usando consultas preparadas
 2. *CSRF:* Se implementan tokens únicos por formulario
 3. *XSS:* Se sanitizan todas las entradas de usuario
 ### Enfoque de seguridad:
 - Validación de datos de entrada
 - Verificación de integridad de archivos
 - Registro y monitoreo de cambios
 - ## 📊 Metodologías de desarrollo
 - *Scrum:* Equipos pequeños, entregas periódicas, mejora continua
 - *Kanban:* Flujo visual, sin plazos fijos, mejora incremental
 - *Spiral:* Basada en gestión de riesgos, iterativa
 - *RAD:* Desarrollo rápido con prototipos funcionales
 - *XP:* Prácticas rigurosas, pruebas continuas
 - *Depox:* Enfoque en gestión de dependencias
