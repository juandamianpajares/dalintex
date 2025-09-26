Guía de Uso: Sistema de Gestión de Insumos
Bienvenido al sistema de gestión de insumos. Esta guía te ayudará a entender las funcionalidades principales y el flujo de trabajo de la aplicación.

1. Selección de Rol (Página de Inicio)
Al iniciar la aplicación, serás dirigido a la página de inicio (/). Aquí podrás seleccionar tu rol. Esta simulación de autenticación permite que la interfaz se adapte a tus permisos sin necesidad de credenciales reales.

Roles Disponibles:

Encargado de Compras: Puede gestionar órdenes de compra.

Operario de Stock: Puede gestionar la entrada y salida de insumos.

Gerente de Producción: Tiene acceso a todas las vistas.

2. Gestión de Insumos
La página de gestión de insumos (/insumos) es el centro de control para el inventario.

Registro de Nuevos Insumos
Utiliza el formulario en la parte superior para registrar un nuevo insumo.

Leer de Balanza: Haz clic en el botón "Leer de Balanza" para obtener el peso directamente desde el servidor local y completar el campo stock_actual.

Campos: Completa los campos restantes (Código, Descripción, Proveedor, etc.) y haz clic en "Registrar Insumo". La aplicación enviará la información a la API y el insumo se añadirá a la tabla.

Listado y Acciones
La tabla en la parte inferior de la página muestra todos los insumos registrados.

Visualización: Puedes ver los detalles clave de cada insumo, como su código, descripción y stock.

Eliminar: Utiliza el botón "Eliminar" en cada fila para remover un insumo de forma permanente.

3. Gestión de Productos
La página de gestión de productos (/productos) te permite dar de alta nuevos productos finales y vincularlos a los insumos necesarios para su fabricación.

Registro de Nuevos Productos
Formulario: Completa los campos de código, descripción y unidad de medida.

Insumos Necesarios: Utiliza el botón "Agregar Insumo" para especificar los insumos y la cantidad requerida para cada producto.

Listado de Productos
La tabla de productos te muestra todos los artículos que has registrado y te permite gestionarlos.

4. Gestión de Órdenes de Compra
La página de órdenes de compra (/ordenes-compra) te permite visualizar y gestionar los pedidos.

Visualización por Rol
La visibilidad de los botones de acción se adapta a tu rol.

Encargado de Compras: Puede ver y gestionar el estado de las órdenes.

Operario de Stock: Solo puede ver las órdenes que necesita preparar.

Gerente de Producción: Puede ver todas las órdenes.

5. Dashboard (Próximo Paso)
El próximo paso es la creación de un dashboard central. Este será el punto de control para ver el estado general del sistema.

Stock Residual: El dashboard mostrará una visión en tiempo real del stock de todos los insumos.

Estado de Órdenes: Podrá mostrar las órdenes de compra pendientes y su estado de "realizable" o "no realizable" en función del stock actual.

Alertas: Se mostrarán alertas visuales para los insumos que estén por debajo de su stock mínimo.

6. API de Balanza
La comunicación con la balanza se maneja a través de un servicio independiente en services/balanza_api.jsx. Este módulo se conecta a un servidor local de Python (http://localhost:5000) para leer el peso y asegura que la lógica esté separada y sea fácil de mantener.

Requisitos:

Asegúrate de que el servidor de la balanza esté en ejecución antes de intentar leer el peso.