#include <iostream>
#include <windows.h> //sleep function (unistd.h for linux)
#include <mysql.h>
#include <string>
#include "importation.h"
#include<time.h>

using namespace std;


//this code will be inserted in all ATMs, we need just to change the 'id_ATM' variable to the id of the ATM where it will be inserted.


int main()
{
    /******** Variables *********/


    struct DB_info d = {"localhost","root","","bd_stagiaire",0,NULL,0};
    string id_ATM="2"; // Every ATM has his id, we suppose that we work in ATM with id=2
    string terminl="000001122";
    MYSQL *mysql=0;

   //check the initialization of MySQL client library


    if (mysql_library_init(0, NULL, NULL))
        {
            fprintf(stderr, "could not initialize MySQL client library\n");
            exit(1);
            }
    mysql=mysql_init(NULL);

    //check if the object was generated successfully


    if (!mysql)
        {
            fprintf(stderr, "Could not initialize Mysql connection\n");
            exit(1);
            }
  //SSL
  //mysql_ssl_set(mysql,
              //"client-key.pem",
              //"client-cert.pem",
              //"ca.pem",
               //NULL,
              //NULL);
  //connection

  //check connection

    if (!mysql_real_connect(mysql,d.host,d.user,d.passwd,d.db,d.port,d.unix_socket,d.client_flag))
        {
            fprintf(stderr, "Failed to connect to database: Error: %s\n",mysql_error(mysql));
    }
    else {
        while(1){
        //connection successful
                string query = "SELECT state FROM `list_atm_confirmed` WHERE `id_atm`='"+id_ATM+"' AND state=1";
                mysql_real_query(mysql, query.c_str(), strlen(query.c_str()));
                // query OK
                MYSQL_RES *result=0;
                result = mysql_store_result(mysql);
                unsigned int n = mysql_num_rows(result);
                mysql_free_result(result);

                if (n!=0){ // ATM connected
                       //Transfert Auto
                       cout << "ATM connected" << endl;
                       cout <<"***********Transfert auto*************"<<endl;
                       query ="SELECT * FROM `control_auto` WHERE `activation`='1'";
                                                mysql_real_query(mysql, query.c_str(), strlen(query.c_str()));
                                                result = mysql_store_result(mysql);
                                                unsigned int b = mysql_num_rows(result);
                                                if(b!=0){ // Si le transfert auto est activé
                                                cout <<"automatic transfer activated"<<endl;
                                                MYSQL_ROW row ;
                                                string tab[0] = {};//array with lenght=1 rows to stock time
                                                while ((row = mysql_fetch_row (result))) {
                                                tab[0]=row[1];}
                                                mysql_free_result(result);
                                                string hour=heure_actual();
                                                cout << "actual time "<< hour << endl;
                                                cout<< "time of transfer " <<tab[0] << endl;
                                                 if(tab[0]==hour){
                                                     string lastDay=date_last_jr();
                                                     string query ="SELECT * FROM `import_auto` WHERE `file_date`='"+lastDay+"' AND `id_atm`='"+id_ATM+"'";
                                                     mysql_real_query(mysql, query.c_str(), strlen(query.c_str()));
                                                     result = mysql_store_result(mysql);
                                                     unsigned int r = mysql_num_rows(result);
                                                     mysql_free_result(result);

                                                     if (r==0){ // if not yet
                                                        string lien = generer_chemin(lastDay);
                                                        cout << lien << endl;
                                                        string query = "INSERT INTO `import_auto`(`id_atm`, `file_date`, `file`) VALUES ('"+id_ATM+"','"+lastDay+"','"+lien+"')";
                                                        mysql_real_query(mysql, query.c_str(), strlen(query.c_str()));
                                                        cout <<"importation file JR-1 auto"<<endl;
                                                             }
                                                      else {
                                                         cout <<"File already imported"<<endl;
                                                         }}
                                                  else{
                                                    cout <<"it is not the time of automatic transfer"<<endl;
                                                    }
                                                }
                                                else{
                                                  cout <<"automatic transfer deactivated"<<endl;
                                                }

                      //Transfert Manuel
                      cout << "************move to command*************" << endl;

                       string query ="SELECT `id_cmd` ,`id_atm`,`file_date` FROM `list_cmd` WHERE `id_atm`='"+id_ATM+"' AND `state`='2'";
                       mysql_real_query(mysql, query.c_str(), strlen(query.c_str()));
                       result = mysql_store_result(mysql);
                       unsigned int z = mysql_num_rows(result); //having z rows means having z command to treat

                        //if z=0, no command to treat
                        if (z!=0) { // if there are rows then
                         cout << "there is " << z << " command to treat" << endl;
                        unsigned int j=0;
                        string val1[z] = {};//array with lenght=num_rows (to stock ids)
                        string val2[z] = {};//array with lenght=num_rows (to stock dates=chemin )
                        string val3[z] = {};//array with lenght=num_rows (to stock id_ATM)
                        MYSQL_ROW row ;

                                while ((row = mysql_fetch_row (result))) {
                                val1[j]=row[0];//id
                                val2[j]=row[1];//ATM
                                val3[j]=row[2];//date

                                cout << "command number : " << j << endl;
                                cout << "id cmd : " << val1[j] << " file date : " << val2[j] << " id of ATM concerned : " << val3[j] <<endl;

                                j=j+1;

                                                        }
                                mysql_free_result(result);


                                for(j=0;j<z;j++){
                                        string lien;
                                         cout << "selecting commands where id is  " << id_ATM <<endl;
                                         if (val2[j]==id_ATM) {
                                            cout << "treating commands found of " << id_ATM <<endl;
                                           cout << "command number " << val1[j]<< ":" <<endl;
                                           string query ="SELECT * FROM `import_manuel` WHERE `file_date`='"+val3[j]+"' AND `id_atm`='"+id_ATM+"'";
                                            mysql_real_query(mysql, query.c_str(), strlen(query.c_str()));
                                            result = mysql_store_result(mysql);
                                            unsigned int r = mysql_num_rows(result);
                                            mysql_free_result(result);


                                            if (r==0){ // if not yet
                                                lien = generer_chemin(val3[j]);
                                                cout << "Le lien est : "<<  lien << endl;
                                                string query ="INSERT INTO `import_manuel`(`id_cmd`, `id_atm`, `file_date`, `file`) VALUES ('"+val1[j]+"','"+id_ATM+"','"+val3[j]+"','"+lien+"')";//import EJ to our database
                                                  //structure of importe_par_commande is like fichier_importe_auto
                                                   cout << "transfer in progress" << endl;
                                                    mysql_real_query(mysql, query.c_str(), strlen(query.c_str()));
                                                    query="UPDATE `list_cmd` SET state='1' WHERE `id_cmd`='"+val1[j]+"'"; //update the state of command to imported successfly
                                                    mysql_real_query(mysql, query.c_str(), strlen(query.c_str()));
                                                    cout << "file imported successfully" << endl ;
                                                    }


                                            else // already imported
                                            {
                                                cout << "file already imported" << endl;
                                               string query ="UPDATE `list_cmd` SET state='3' WHERE `id_cmd`='"+val1[j]+"'";//update the state of command to already imported successfly
                                               mysql_real_query(mysql, query.c_str(), strlen(query.c_str())); //update the state of command
                                            }}}




            }
            else {
                cout << "there is no command to treat" << endl;
            }
            }
            else{
            cout << "ATM disconnected" << endl;
            }

            }
mysql_close(mysql);
mysql_library_end();
    }

    return 0;
}
