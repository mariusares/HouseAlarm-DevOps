#!/usr/bin/python3
import socketserver
import signal
import os
import threading
from lib.sensors_data import return_data, get_db_data, get_sensors, setup_gpios
from lib.sensors_data import alarm_run, trigger, check_temperature, alarm_reset, GPIO

class SocketMessage(socketserver.BaseRequestHandler):
    """
    Args:
        socketserver (_type_): Python Library for socket connesctions
        Here the Application CLient interface messages are translated
    """
    def handle(self):
        try:
            transfer_data = self.request.recv(1024).strip()
            transfer_data = transfer_data.decode()
            print(transfer_data)
            # alarm_reset()
            return_data()
            if transfer_data == "reqestData":
                self.request.sendall(str.encode(
                    ",".join([str(return_data())])))
            elif transfer_data == "updateSensor":
                get_db_data()
                get_sensors()
                setup_gpios()
                alarm_run()
                return_data()
            elif transfer_data == "requestTrigger":
                # print(trigger)
                self.request.sendall(str.encode(
                    ",".join([str(trigger), str(check_temperature())])))
            elif transfer_data == "alarmUnset":
                alarm_reset()
            elif transfer_data == "alarmSet":
                alarm_reset()
            elif transfer_data == "alarmUnmute":
                alarm_reset()
            elif transfer_data == "alarmMute":
                alarm_reset()
            else:
                pass
        except IndexError:
            pass
class MessageServer(socketserver.ThreadingMixIn, socketserver.TCPServer):
    """
    Args:
        MessageServer class build
    """
    pass
def socket_server():
    """
    Socket Server Function
    This function will use the socketserver class to create the
    socket protocol on port 72
    """
    try:
        MessageServer.allow_reuse_address = True
        server = MessageServer(("0.0.0.0", 72), SocketMessage)
        #ip, port = server.server_address
        server_thread = threading.Thread(target=server.serve_forever)
        server_thread.daemon = True
        server_thread.start()
        server.serve_forever()
        server.shutdown()
        server.server_close()
    except KeyboardInterrupt:
        GPIO.cleanup()
        print("exit sistem")
        os.kill(os.getpid(), signal.SIGTERM)
alarm_run()
socket_server()
