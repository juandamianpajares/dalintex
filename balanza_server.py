import serial
from flask import Flask, jsonify
from flask_cors import CORS

# Reemplaza 'COM3' con el puerto COM de tu balanza.
# Puedes encontrar el puerto en el Administrador de Dispositivos de Windows.
SERIAL_PORT = 'COM3' 

# La velocidad de transmisión de la balanza RADWAG WLC 30/F1/K es 9600 baudios.
BAUD_RATE = 9600

# Inicializa la aplicación Flask
app = Flask(__name__)
# Habilita CORS para permitir que tu aplicación web se comunique con este servidor
CORS(app)

@app.route('/read_weight', methods=['GET'])
def read_weight():
    """
    Endpoint de la API que lee el peso de la balanza y lo devuelve.
    """
    try:
        with serial.Serial(SERIAL_PORT, BAUD_RATE, timeout=2) as ser:
            line = ser.readline().decode('utf-8').strip()
            # El manual de la balanza WLC indica que la salida es de 16 caracteres.
            # El peso generalmente se encuentra en los primeros 11 caracteres.
            # Ejemplo: "   12.500 g"
            
            # Utiliza una expresión regular para encontrar el peso (número flotante)
            import re
            weight_match = re.search(r'([-+]?\s*\d+\.\d+)\s*g', line)
            
            if weight_match:
                weight = float(weight_match.group(1))
                return jsonify({
                    "status": "success",
                    "weight": weight
                })
            else:
                return jsonify({
                    "status": "error",
                    "message": "No se pudo leer el peso de la balanza o formato inválido."
                }), 500

    except serial.SerialException as e:
        return jsonify({
            "status": "error",
            "message": f"Error de puerto serial: {e}. Asegúrate de que el puerto COM es correcto y no está en uso."
        }), 500
    except Exception as e:
        return jsonify({
            "status": "error",
            "message": f"Error inesperado: {e}"
        }), 500

if __name__ == '__main__':
    # Ejecuta el servidor en http://127.0.0.1:5000
    app.run(host='0.0.0.0', port=5000)
