- ### Lista API 

### Accesso Pubblico:

| Tipo | URL                                 | Controller                  | Funzione   |
| ---- | ----------------------------------- | --------------------------- | ---------- |
| GET  | /v1/calcoloIva/{numero}             | CalcoloIva                  | calcolaIva |
| GET  | /v1/comuniItaliani                  | ComuniItalianiController    | index      |
| GET  | /v1/lingue                          | LingueController            | index      |
| GET  | /v1/lingue/{idLingua}               | LingueController            | show       |
| GET  | /v1/nazioni                         | NazioniController           | index      |
| GET  | /v1/nazioni/{idNazione}             | NazioniController           | show       |
| GET  | /v1/tipo-recapiti                   | TipoRecapitiController      | index      |
| GET  | /v1/tipo-recapiti/{idTipoRecapito}  | TipoRecapitiController      | show       |
| GET  | /v1/tipoIndirizzi                   | TipoIndirizziController     | index      |
| GET  | /v1/tipoIndirizzi/{idTipoIndirizzo} | TipoIndirizziController     | show       |
| GET  | /v1/vista/traduzioni                | VistaTraduzioniController   | index      |
| GET  | /v1/vista/traduzioni/{id}           | VistaTraduzioniController   | show       |
| POST | /v1/registra                        | RegistraController          | registra   |
| GET  | /v1/accedi/{email}/{hash?}          | AccediController            | accedi     |
| GET  | /v1/config                          | ConfigurazioniController    | index      |
| GET  | /v1/config/{idConfigurazione}       | ConfigurazioniController    | show       |
| GET  | /v1/stati                           | StatiController<br>         | index      |
| GET  | /v1/stati/{idStato}                 | StatiController<br>         | show       |
| GET  | /v1/ruoli                           | RuoliController<br>         | index      |
| GET  | /v1/ruoli/{idRuolo}                 | RuoliController<br>         | show       |
| GET  | /v1/abilita                         | AbilitaController<br>       | index      |
| GET  | /v1/abilita/{idAbilita}             | AbilitaController<br>       | show       |
| GET  | /v1/province                        | VistaProvinceController<br> | index      |
| GET  | /v1/province/{provincia}            | VistaProvinceController     | show       |

### Accesso Utente-Admin:

| Tipo | URL                                | Controller          | Funzione       |
| ---- | ---------------------------------- | ------------------- | -------------- |
| GET  | /v1/categorie                      | CategorieController | index          |
| GET  | /v1/categorie/{idCategoria}        | CategorieController | show           |
| GET  | /v1/contatti/{idContatto}          | ContattiController  | show           |
| PUT  | /v1/aggiorna/contatti/{idContatto} | ContattiController  | update         |
| GET  | /v1/crediti/{idCredito}            | CreditiController   | show           |
| POST | /v1/aggiorna/crediti/{idCredito}   | CreditiController   | update         |
| GET  | /v1/episodi/{idEpisodio}           | EpisodiController   | showEpisodio   |
| GET  | /v1/serieTv/{idSerieTv}/episodi    | EpisodiController   | episodiSerieTv |
| GET  | /v1/films                          | FilmController      | index          |
| GET  | /v1/films/genere/{idGenere}        | FilmController      | indexGenere    |
| GET  | /v1/films/regista/{regista}        | FilmController      | indexRegista   |
| GET  | /v1/films/anno/{anno}              | FilmController      | indexAnno      |
| GET  | /v1/films/{film}                   | FilmController      | show           |
| GET  | /v1/serieTv                        | SerieTvController   | index          |
| GET  | /v1/serieTv/genere/{idGenere}      | SerieTvController   | indexGenere    |
| GET  | /v1/serieTv/regista/{regista}      | SerieTvController   | indexRegista   |
| GET  | /v1/serieTv/anno/{anno}            | SerieTvController   | indexAnno      |
| GET  | /v1/serieTv/{idSerieTv}            | SerieTvController   | show           |
| GET  | /v1/files/{idFile}                 | FilesController     | show           |


### Accesso Admin:

| Tipo   | URL                                             | Controller                 | Funzione |
| ------ | ----------------------------------------------- | -------------------------- | -------- |
| POST   | /v1/salva/categorie                             | CategorieController        | store    |
| PUT    | /v1/aggiorna/categorie/{idCategoria}            | CategorieController        | update   |
| DELETE | /v1/distruggi/categorie/{idCategoria}           | CategorieController        | destroy  |
| POST   | /v1/salva/generi                                | GenereController           | store    |
| PUT    | /v1/aggiorna/generi/{idGenere}                  | GenereController           | update   |
| DELETE | /v1/distruggi/generi/{idGenere}                 | GenereController           | destroy  |
| POST   | /v1/salva/films                                 | FilmController             | store    |
| PUT    | /v1/aggiorna/films/{idFilm}                     | FilmController             | update   |
| DELETE | /v1/distruggi/films/{idFilm}                    | FilmController             | destroy  |
| POST   | /v1/salva/serieTv                               | SerieTvController          | store    |
| PUT    | /v1/aggiorna/serieTv/{idSerieTv}                | SerieTvController          | update   |
| DELETE | /v1/distruggi/serieTv/{idSerieTv}               | SerieTvController          | destroy  |
| POST   | /v1/salva/episodi                               | EpisodiController          | store    |
| PUT    | /v1/aggiorna/episodi/{idEpisodio}               | EpisodiController          | update   |
| DELETE | /v1/distruggi/episodi/{idEpisodio}              | EpisodiController          | destroy  |
| POST   | /v1/salva/config                                | ConfigurazioniController   | store    |
| PUT    | /v1/aggiorna/config/{idConfigurazione}          | ConfigurazioniController   | update   |
| DELETE | /v1/distruggi/config/{idConfigurazione}         | ConfigurazioniController   | destroy  |
| GET    | /v1/ruoli                                       | RuoliController            | index    |
| GET    | /v1/ruoli/{idRuolo}                             | RuoliController            | show     |
| GET    | /v1/abilita                                     | AbilitaController          | index    |
| GET    | /v1/abilita/{idAbilita}                         | AbilitaController          | show     |
| GET    | /v1/stati                                       | StatiController            | index    |
| GET    | /v1/stati/{idStato}                             | StatiController            | show     |
| POST   | /v1/salva/tipoIndirizzi                         | TipoIndirizziController    | store    |
| PUT    | /v1/aggiorna/tipoIndirizzi/{idTipoIndirizzo}    | TipoIndirizziController    | update   |
| DELETE | /v1/distruggi/tipoIndirizzi/{idTipoIndirizzo}   | TipoIndirizziController    | destroy  |
| POST   | /v1/salva/lingue                                | LingueController           | store    |
| PUT    | /v1/aggiorna/lingue/{idLingua}                  | LingueController           | update   |
| DELETE | /v1/distruggi/lingue/{idLingua}                 | LingueController           | destroy  |
| POST   | /v1/salva/traduzioni                            | TraduzioniController       | store    |
| PUT    | /v1/aggiorna/traduzioni/{idTraduzione}          | TraduzioniController       | update   |
| DELETE | /v1/distruggi/traduzioni/{idTraduzione}         | TraduzioniController       | destroy  |
| POST   | /v1/salva/tipo-recapiti                         | TipoRecapitiController     | store    |
| PUT    | /v1/aggiorna/tipo-recapiti/{idTipoRecapito}     | TipoRecapitiController     | update   |
| DELETE | /v1/distruggi/tipo-recapiti/{idTipoRecapito}    | TipoRecapitiController     | destroy  |
| GET    | /v1/crediti                                     | CreditiController          | index    |
| DELETE | /v1/distruggi/traduzioni-customs/{idTraduzione} | TraduzioniCustomController | destroy  |
| PUT    | /v1/aggiorna/traduzioni-customs/{idTraduzione}  | TraduzioniCustomController | update   |
| POST   | /v1/salva/traduzioni-customs                    | TraduzioniCustomController | store    |
| GET    | /v1/contatti                                    | ContattiController         | index    |
| DELETE | /v1/distruggi/contatti/{idContatto}             | ContattiController         | destroy  |
| PUT    | /v1/aggiorna/traduzioni/{idTraduzione}          | TraduzioniController       | update   |
| DELETE | /v1/distruggi/traduzioni/{idTraduzione}         | TraduzioniController       | destroy  |
| GET    | /v1/files                                       | FilesController<br>        | index    |
| PUT    | /v1/aggiorna/files/{idFile}                     | FilesController<br>        | update   |
| DELETE | /v1/distruggi/files/{idFile}                    | FilesController<br>        | destroy  |
