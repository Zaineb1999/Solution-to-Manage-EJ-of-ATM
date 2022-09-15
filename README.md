# Solution-to-Manage-EJ-of-ATM
#The interface and the ATM communicate with the database at the same time (MySQL communication protocol).
User orders are stored on the list_cmd table in our database, if the ATM is in service, it selects new unprocessed orders, it stores them in a dynamic table and then it starts filtering these orders, comparing the ATM id linked to the commands with its id, if they are equal, the ATM sends the requested file, otherwise it sends nothing, otherwise if the ATM is out of service, it does no processing.
#The application is specially for the banking sector, so you must read about PCI DSS to secure this code.
#To respect the PSI DSS, you can add the SSL key to secure the tranfer, also you can use mysqli-real-escap-string to secure your inputs against SQL injesction.
