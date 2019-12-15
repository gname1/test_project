import os
import time
import mysql.connector
import paho.mqtt.client as mqtt
import urlparse3
import re
from mysql.connector import Error




def is_connect_db():
    if mydb.is_connected():
        print('db: SUCCESS')
    else:
        print('db: ERROR')


# Define event callbacks
def on_connect(client, userdata, flags, rc):
    if rc == 0:
        print('mqtt: SUCCESS')
    else:
        print('mqtt: ERROR. ')

def on_message(client, obj, mess):
    message = str(mess.payload)[2:-1]

    print("message: " + message + "; topic: " + mess.topic)
    global msg
    msg = message;
    global top
    top = mess.topic;

    sql = "INSERT INTO topics_data (topic, message) VALUES(%s, %s)"
    val = (mess.topic, message)
    mycursor.execute(sql, val)
    mydb.commit()

def check_change():
    
    if msg != "" and top != "":
        
        pattern_bulb = r"^iot\/bulb(\d+)\/set$";
        regex_rezult = re.search(pattern_bulb, top)
        if regex_rezult:
            bulb_id = regex_rezult.group(1)      
            if int(bulb_id) in bulbs_id:
                #print("currnet bulb_id: " + bulb_id)            
                mqttc.publish("iot/bulb" + bulb_id + "/get", msg)
        
        pattern_bulb_mode = r"^iot\/bulb(\d+)\/mode\/set$";
        regex_rezult_mode = re.search(pattern_bulb_mode, top)
        if regex_rezult_mode:
            bulb_id = regex_rezult_mode.group(1)
            mqttc.publish("iot/bulb" + bulb_id + "/mode/get", msg)      
            mqttc.publish("iot/bulb" + bulb_id + "/get", "0")      


# DB
mydb = mysql.connector.connect(host='db',database='myDb',user='user',password='test')
is_connect_db()
mycursor = mydb.cursor()

# MQTT
mqttc = mqtt.Client()
# Assign event callbacks
mqttc.on_connect = on_connect
mqttc.on_message = on_message

# Connect
mqttc.username_pw_set("kllzeooz", "Gg5nBhn0TWWd")
mqttc.connect("postman.cloudmqtt.com", 15043)

mqttc.subscribe("#", 0)

msg = ""
top = ""
bulbs_id = set([1, 3, 4])




while True:

    mqttc.loop_start()

    #mqttc.publish(topic, "my message")
    check_change()
    time.sleep(1)

    mqttc.loop_stop(force=False)










