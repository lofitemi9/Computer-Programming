# Import all the necessary libraries
import openpyxl 
import os
import datetime 
import pyinputplus as pyip

# File path Validation
filePath = input("Give me a file path: ")
if not os.path.exists(filePath):
    print("Error: File path does not exist.")
    exit()
elif not filePath.endswith('.xlsx'):
    print("Error: File must be an Excel file (.xlsx).")
    exit()

# Define the function that loads the excel file 
def loadExcelFile(filePath):
    try:
        # Load the workbook
        workBook = openpyxl.load_workbook(filePath)
        print("Workbook loaded successfully.")
        return workBook
    # error handling to check if the file exists or not
    except FileNotFoundError:
        print("Error: File not found.")
        return None
    except Exception as e:
        print("An unexpected error occurred:", e)
        return None

        

# Define the function to extract Data from worksheet
def extractData():
    workBook = loadExcelFile(filePath)
    # Iterate through each sheet in the workbook
    for sheets in workBook.sheetnames:
        activesheet = workBook[sheets]
        print(activesheet)
        print(sheets)





loadExcelFile(filePath)















# Call the function with the file path
loadExcelFile('C:\\xampp\\htdocs\\myProjects\\Web Development Projects\\Georgian_Comp\\Document Automation in Python\\Project\\excelSheet\\Programming Tracker & Requirments 2025-2026.xlsx')

