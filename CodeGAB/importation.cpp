
#include <iostream>
#include <ctime>
#include <string>
#include <mysql.h>
#include "importation.h"
using namespace std;


string generer_chemin(string date)
{
int i;
string newdate="";
string nomfichier;
for (i=0;i<date.length(); i++)
    {
        if (date[i]!='/')
            {
                newdate= newdate + date[i];
                }
        }
nomfichier="C:\\xampp\\htdocs\\interface\\CodeGAB\\jrn\\"+newdate+".jrn";
return nomfichier;
}

string date_last_jr() {
    time_t actuel = time(0);
    tm *ltm  = localtime(&actuel);
    int day = ltm->tm_mday-1;
    string x(to_string(day));
    int month = 1 + ltm->tm_mon;
    string y(to_string(month));
    int year = 1900 + ltm->tm_year;
    string z(to_string(year));

    if (x.length()==1){
            x='0'+ x;
    }
    if (y.length()==1){
            y='0'+ y;
    }

    string date=x+y+z;

    return date;
    }


string heure_actual() {
time_t actuel = time(0);
tm *ltm  = localtime(&actuel);
int heure=ltm->tm_hour;
string x(to_string(heure));
int minute=ltm->tm_min;
string y(to_string(minute));
if (x.length()==1){
            x='0'+ x;
    }
    if (y.length()==1){
            y='0'+ y;
    }
string newheure=x+":"+y+":00";
return newheure;
}






