Gu�a de Uso: Sistema de Gesti�n de Insumos
Bienvenido al sistema de gesti�n de insumos. Esta gu�a te ayudar� a entender las funcionalidades principales y el flujo de trabajo de la aplicaci�n.

1. Selecci�n de Rol (P�gina de Inicio)
Al iniciar la aplicaci�n, ser�s dirigido a la p�gina de inicio (/). Aqu� podr�s seleccionar tu rol. Esta simulaci�n de autenticaci�n permite que la interfaz se adapte a tus permisos sin necesidad de credenciales reales.

Roles Disponibles:

Encargado de Compras: Puede gestionar �rdenes de compra.

Operario de Stock: Puede gestionar la entrada y salida de insumos.

Gerente de Producci�n: Tiene acceso a todas las vistas.

2. Gesti�n de Insumos
La p�gina de gesti�n de insumos (/insumos) es el centro de control para el inventario.

Registro de Nuevos Insumos
Utiliza el formulario en la parte superior para registrar un nuevo insumo.

Leer de Balanza: Haz clic en el bot�n "Leer de Balanza" para obtener el peso directamente desde el servidor local y completar el campo stock_actual.

Campos: Completa los campos restantes (C�digo, Descripci�n, Proveedor, etc.) y haz clic en "Registrar Insumo". La aplicaci�n enviar� la informaci�n a la API y el insumo se a�adir� a la tabla.

Listado y Acciones
La tabla en la parte inferior de la p�gina muestra todos los insumos registrados.

Visualizaci�n: Puedes ver los detalles clave de cada insumo, como su c�digo, descripci�n y stock.

Eliminar: Utiliza el bot�n "Eliminar" en cada fila para remover un insumo de forma permanente.

3. Gesti�n de Productos
La p�gina de gesti�n de productos (/productos) te permite dar de alta nuevos productos finales y vincularlos a los insumos necesarios para su fabricaci�n.

Registro de Nuevos Productos
Formulario: Completa los campos de c�digo, descripci�n y unidad de medida.

Insumos Necesarios: Utiliza el bot�n "Agregar Insumo" para especificar los insumos y la cantidad requerida para cada producto.

Listado de Productos
La tabla de productos te muestra todos los art�culos que has registrado y te permite gestionarlos.

4. Gesti�n de �rdenes de Compra
La p�gina de �rdenes de compra (/ordenes-compra) te permite visualizar y gestionar los pedidos.

Visualizaci�n por Rol
La visibilidad de los botones de acci�n se adapta a tu rol.

Encargado de Compras: Puede ver y gestionar el estado de las �rdenes.

Operario de Stock: Solo puede ver las �rdenes que necesita preparar.

Gerente de Producci�n: Puede ver todas las �rdenes.

5. Dashboard (Pr�ximo Paso)
El pr�ximo paso es la creaci�n de un dashboard central. Este ser� el punto de control para ver el estado general del sistema.

Stock Residual: El dashboard mostrar� una visi�n en tiempo real del stock de todos los insumos.

Estado de �rdenes: Podr� mostrar las �rdenes de compra pendientes y su estado de "realizable" o "no realizable" en funci�n del stock actual.

Alertas: Se mostrar�n alertas visuales para los insumos que est�n por debajo de su stock m�nimo.

6. API de Balanza
La comunicaci�n con la balanza se maneja a trav�s de un servicio independiente en services/balanza_api.jsx. Este m�dulo se conecta a un servidor local de Python (http://localhost:5000) para leer el peso y asegura que la l�gica est� separada y sea f�cil de mantener.

Requisitos:

Aseg�rate de que el servidor de la balanza est� en ejecuci�n antes de intentar leer el peso.