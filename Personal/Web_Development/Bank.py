import os
import time
import sys
import random
from geopy.geocoders import Nominatim
import geopy.exc
import logging

# Account data lists
account_list = []
password_list = []
name_list = []
age_list = []
zipcode_list = []
balance_list = []
deposit_amount = 0
transaction_history = []

# Geocoding setup
geolocator = Nominatim(user_agent="zipcode_lookup")

# Logging setup
logging.basicConfig(filename='banking_system.log', level=logging.INFO)

# Clear screen function
def clear_screen():
    if os.name == "nt":
        os.system("cls")
    else:
        os.system("clear")

# Save account data to file
def save_data():
    with open("account_data.txt", "w") as file:
        for account, password, name, age, zipcode, balance, history in zip(
                account_list, password_list, name_list, age_list, zipcode_list, balance_list, transaction_history
        ):
            # Use a consistent delimiter (comma) for all fields, including transaction history
            file.write(f"{account},{str(password)},{name},{age},{zipcode},{balance},{','.join(history)}\n")


# Load account data from file
def load_data():
    try:
        with open("account_data.txt", "r") as file:
            for line in file:
                data = line.strip().split(",")
                if len(data) >= 6:
                    account_list.append(data[0])
                    password_list.append(data[1])
                    name_list.append(data[2])
                    age_list.append(data[3])
                    zipcode_list.append(data[4])

                    # Convert transaction history entries to a list of strings
                    history = data[5:]
                    transaction_history.append(history if history else [])

                    # Calculate the account balance based on transaction history
                    balance = 0
                    for transaction in transaction_history[-1]:
                        try:
                            if transaction.startswith("Deposit"):
                                deposit_amount = int(transaction.split(":")[1].strip().replace("$", ""))
                                balance += deposit_amount
                            elif transaction.startswith("Withdrawal"):
                                withdrawal_amount = int(transaction.split(":")[1].strip().replace("$", ""))
                                balance -= withdrawal_amount
                            else:
                                print(f"Unknown transaction type: {transaction}")
                        except ValueError as e:
                            print(f"Error processing transaction: {transaction}\nError: {e}")
                    balance_list.append(balance)
                else:
                    print(f"Invalid account data format: {line}")

    except FileNotFoundError:
        pass


# Account login
def login():
    global current_user_index

    print("\n***** LOGIN *****")
    account_number = input("Account Number: ")
    pin = input("PIN: ")

    print("\nAccessing user database...")
    time.sleep(2)

    if account_number in account_list and pin in password_list:
        current_user_index = account_list.index(account_number)
        print("\nLogin Successful!")
        time.sleep(1)
        return True, current_user_index
    else:
        print("Invalid account number or PIN. Please try again.")
        time.sleep(1)
        return False, -1

# Check if user has an existing account or create a new one
def existing_or_new():
    load_data()
    choice = input('''Do you have an existing account with us or not?
    Y / N : ''').upper()
    if choice == 'Y':
        while True:
            account_number = input("ACCOUNT NUMBER: ")

            if len(account_number) < 10 or not account_number.isdigit():
                print("Invalid account number. Account number must be at least 10 digits long and contain only numbers.")
            else:
                break

        try:
            index = account_list.index(account_number)
        except ValueError:
            print("Invalid account number. Please try again.")
            return existing_or_new()

        while True:
            account_password = input("PIN CODE: ")

            if not account_password.isdigit():
                print("Invalid PIN code. PIN code must contain only numbers.")
            elif account_password != password_list[index]:
                print("Invalid PIN code. Please try again.")
            else:
                break

        return True, index
    elif choice == "N":
        create_account()
        input("\nPress Enter to continue...")  # Wait for user input before going back to the main menu
        return False, -1
    else:
        print("Pick a valid option.")
        return existing_or_new()

# Security functions
def hash_password(password):
    # In a real system, use a secure hashing algorithm like bcrypt.
    return str(hash(password))

# Create a new account
def create_account():
    new_name = input("NAME: ")
    new_age = input("AGE: ")
    new_zipcode = input("ZIP CODE: ")

    # Perform geocoding lookup to retrieve location based on ZIP code
    while True:
        try:
            location = geolocator.geocode(new_zipcode)
            break
        except geopy.exc.GeocoderTimedOut:
            print("Geocoding service timed out. Retrying...")
            continue
        except geopy.exc.GeocoderUnavailable:
            print("Geocoding service is currently unavailable. Please try again later.")
            return

    while not location:
        print("Invalid ZIP code. Please enter a valid ZIP code.")
        new_zipcode = input("ZIP CODE: ")
        location = geolocator.geocode(new_zipcode)

    while True:
        new_pin = input("NEW PIN: ")

        if len(new_pin) != 4 or not new_pin.isdigit():
            print("Invalid PIN code. PIN code must be 4 digits long and contain only numbers.")
        else:
            hashed_pin = str(hash_password(new_pin))
            break

    print("Creating your account...")
    time.sleep(3)

    while True:
        new_account = str(random.randint(1000000000, 9999999999))

        if new_account in account_list:
            print("Account number already exists. Please choose a different account number.")
        else:
            break

    time.sleep(1)
    print("\nAccount created successfully!")
    print("Name:", new_name)
    print("Age:", new_age)
    print("Account Number:", new_account)
    print("Location based on ZIP code:", location.address)
    time.sleep(2)

    account_list.append(new_account)
    password_list.append(hashed_pin)  # Save hashed PIN instead of plaintext
    name_list.append(new_name)
    age_list.append(new_age)
    zipcode_list.append(new_zipcode)
    balance_list.append(0)  # Initialize balance as 0 for the new account
    transaction_history.append([])  # Initialize empty transaction history for the new account
    save_data()  # Save the data after creating the account

    # Log account creation
    logging.info(f"Account created: {new_account}, {new_name}, {new_age}, {new_zipcode}")

# Deposit funds into the account
def deposit():
    global deposit_amount

    while True:
        deposit_input = input("\nHow much do you want to deposit into your account: ")

        # Check if the input contains an abbreviation (e.g., 500k)
        if deposit_input[-1] in ('k', 'K', 'm', 'M'):
            try:
                abbreviation = deposit_input[-1]
                amount = int(deposit_input[:-1])

                if abbreviation in ('k', 'K'):
                    deposit_amount = amount * 1000
                elif abbreviation in ('m', 'M'):
                    deposit_amount = amount * 1000000
                else:
                    print("Invalid input. Please enter a valid number.")
                    continue

                break

            except ValueError:
                print("Invalid input. Please enter a valid number.")
                continue
        else:
            try:
                deposit_amount = int(deposit_input)
                if deposit_amount < 0:
                    print("Invalid input. Please enter a positive number.")
                else:
                    break
            except ValueError:
                print("Invalid input. Please enter a valid number.")

    print("Processing your deposit...")
    time.sleep(2)

    balance_list[current_user_index] += deposit_amount  # Update the account balance
    transaction_history[current_user_index].append(f"Deposit: +{deposit_amount}$")  # Add deposit transaction to history
    save_data()  # Save the updated transaction history
    time.sleep(1)
    print("You have successfully deposited", deposit_amount, "$")
    time.sleep(2)


# Withdraw funds from the account
def withdraw():
    while True:
        withdrawal_input = input("\nHow much do you want to withdraw from your account: ")

        # Check if the input contains an abbreviation (e.g., 500k)
        if withdrawal_input[-1] in ('k', 'K', 'm', 'M'):
            try:
                abbreviation = withdrawal_input[-1]
                amount = int(withdrawal_input[:-1])

                if abbreviation in ('k', 'K'):
                    withdrawal_amount = amount * 1000
                elif abbreviation in ('m', 'M'):
                    withdrawal_amount = amount * 1000000
                else:
                    print("Invalid input. Please enter a valid number.")
                    continue

                break

            except ValueError:
                print("Invalid input. Please enter a valid number.")
                continue
        else:
            try:
                withdrawal_amount = int(withdrawal_input)
                if withdrawal_amount < 0:
                    print("Invalid input. Please enter a positive number.")
                else:
                    break
            except ValueError:
                print("Invalid input. Please enter a valid number.")

    print("Processing your withdrawal...")
    time.sleep(2)

    if withdrawal_amount > balance_list[current_user_index]:
        print("INSUFFICIENT FUNDS: You do not have enough balance to withdraw", withdrawal_amount, "$")
    else:
        balance_list[current_user_index] -= withdrawal_amount  # Update the account balance
        transaction_history[current_user_index].append(f"Withdrawal: -{withdrawal_amount}$")  # Add withdrawal transaction to history
        save_data()  # Save the updated transaction history
        time.sleep(1)
        print("You have successfully withdrawn", withdrawal_amount, "$")
        print("Your Remaining Balance is", balance_list[current_user_index], "$")
    time.sleep(2)


# View account balance
def view_balance():
    global deposit_amount
    balance = balance_list[current_user_index]

    print("Fetching your account balance...")
    time.sleep(2)

    # Abbreviate balance if necessary
    abbreviated_balance = abbreviate_amount(balance)

    print("\nAccount Holder:", name_list[current_user_index])
    print("Account Balance:", abbreviated_balance)
    time.sleep(2)

# View transaction history
def view_transaction_history():
    global deposit_amount

    print("Fetching your transaction history...")
    time.sleep(2)

    history = transaction_history[current_user_index]
    if history:
        print("\nTransaction History:")
        for transaction in history:
            # Abbreviate transaction amounts if necessary
            abbreviated_transaction = abbreviate_transaction(transaction)
            print("-", abbreviated_transaction)
    else:
        print("\nNo transaction history found.")

    input("\nPress Enter to continue...")  # Wait for user input before going back to the main menu

    time.sleep(2)

# Abbreviate amount
def abbreviate_amount(amount):
    if amount >= 1000000:
        return str(amount // 1000000) + "M"
    elif amount >= 1000:
        return str(amount // 1000) + "k"
    else:
        return str(amount)

# Abbreviate transaction amount
def abbreviate_transaction(transaction):
    parts = transaction.split(":")
    if len(parts) == 2:
        amount = int(parts[1].strip().replace("$", ""))
        abbreviated_amount = abbreviate_amount(amount)
        return parts[0] + ": " + abbreviated_amount + "$"
    else:
        return transaction

# Exit the program
def exit_program():
    print("\nThank you for using our banking system!")
    sys.exit()


# Main program
def banking_system():
    global account_list, password_list, name_list, age_list, zipcode_list
    global balance_list, deposit_amount, transaction_history, current_user_index

    account_list = []
    password_list = []
    name_list = []
    age_list = []
    zipcode_list = []
    balance_list = []
    deposit_amount = 0
    transaction_history = []
    current_user_index = -1

    load_data()

    while True:
        clear_screen()
        print("\n***** WELCOME TO OUR BANK *****")
        print("1. LOGIN")
        print("2. CREATE NEW ACCOUNT")
        print("3. EXIT")

        choice = input("\nEnter your choice (1-3): ")

        if choice == "1":
            is_valid_login, current_user_index = login()

            if is_valid_login:
                while True:
                    clear_screen()
                    print("\n***** BANKING MENU *****")
                    print("1. DEPOSIT")
                    print("2. WITHDRAW")
                    print("3. VIEW BALANCE")
                    print("4. VIEW TRANSACTION HISTORY")
                    print("5. LOGOUT")

                    user_choice = input("\nEnter your choice (1-5): ")

                    if user_choice == "1":
                        deposit()
                    elif user_choice == "2":
                        withdraw()
                    elif user_choice == "3":
                        view_balance()
                    elif user_choice == "4":
                        view_transaction_history()
                    elif user_choice == "5":
                        current_user_index = -1
                        break
                    else:
                        print("Invalid choice. Please enter a valid option.")
            else:
                continue


        elif choice == "2":
            create_account()
            input("\nPress Enter to continue...")  # Wait for user input before going back to the main menu


        elif choice == "3":
            exit_program()

        else:
            print("Invalid choice. Please enter a valid option.")

if __name__ == "__main__":
    banking_system()
