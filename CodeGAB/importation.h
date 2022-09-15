#ifndef IMPORTATION_H_INCLUDED
#define IMPORTATION_H_INCLUDED
#include <string>

struct DB_info
{
  const char *host=0  ;
  const char *user=0;
  const char *passwd=0;
  const char *db=0 ;
  unsigned int port ;
  const char *unix_socket=0 ;
  unsigned long client_flag ;
};

std::string generer_chemin(std::string date);
std::string date_last_jr(); //prototype of function date_last_jr
std::string heure_actual();

#endif // IMPORTATION_H_INCLUDED
