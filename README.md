# Solution-to-Manage-EJ-of-ATM
#The interface and the ATM communicate with the database at the same time (MySQL communication protocol).
User orders are stored on the list_cmd table in our database, if the ATM is in service, it selects new unprocessed orders, it stores them in a dynamic table and then it starts filtering these orders, comparing the ATM id linked to the commands with its id, if they are equal, the ATM sends the requested file, otherwise it sends nothing, otherwise if the ATM is out of service, it does no processing.
