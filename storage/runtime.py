#!/usr/bin/python

from threading import Timer
import time
import sys
import signal
import os
import subprocess
def kill(p):
    try:
        p.kill()
    except OSError:
        pass # ignore
    
def main():
    path =  str(sys.argv[1])
    #path = "HI"
    MAX_RUNTIME = 2
    FREQ = 1
    flag = False
    #execution = threading.Thread(target = runner,args = (MAX_RUNTIME,FREQ))
    #execution.start()
    proc = subprocess.Popen(path,shell=True)
    count = 0
    pid = proc.pid
    print (pid)
    while True:
        if proc.poll() is None:
            time.sleep(FREQ)
            count = count + FREQ
            #print(count)
            if count > MAX_RUNTIME:
                
                os.kill(pid, signal.SIGTERM) #or signal.SIGKILL 
                #print("NOT OK")
                break
        if proc.poll() != None:
            #print("OK")
            #print ("0")
            sys.exit(0)
    #print("1")
    sys.exit(1)

if __name__ == "__main__":
    main()
