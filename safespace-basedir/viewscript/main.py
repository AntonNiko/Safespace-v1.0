import os,shutil
import time
from threading import Thread

## Time to wait until delete new file (secs.)
TIME_TO_DELETE = 10
## Time interval for every folder scan (secs.)
SCAN_INTERVAL = 0.5

class FileDeleteThread(Thread):
    def __init__(self,fileName):
         Thread.__init__(self)
         self.fileName = fileName

    def run(self):
        time.sleep(TIME_TO_DELETE)
        shutil.rmtree(self.fileName)
        print("Deleted '{}'".format(self.fileName))
        
class FileManager:
    def __init__(self):
        os.chdir("C:\\xampp\\htdocs\\files")
        self.filesHistory = os.listdir()

    def scan(self):
        os.chdir("C:\\xampp\\htdocs\\files")
        filesCurrent = os.listdir()
        if not self.newFiles(filesCurrent):
            self.filesHistory = filesCurrent
            return None
        else:
            filesNew = self.newFiles(filesCurrent)
            self.filesHistory = filesCurrent
            return filesNew 

    def newFiles(self,fileList):
        newFiles = []
        for file in fileList:
            if file not in self.filesHistory:
                newFiles.append(file)
        return newFiles

fileManager = FileManager()  
while True:
    newFiles = fileManager.scan()
    if newFiles:
        ## Generate New Instance of Delete Thread for each new File
        for file in newFiles:
            deleteThread = FileDeleteThread(file)
            print("Starting Thread...")
            deleteThread.start()
    else:
        pass
    time.sleep(SCAN_INTERVAL)
