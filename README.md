# Codex - Backend API per una Piattaforma di Streaming Video Online

## Documentazione

Per una documentazione dettagliata sulla lista delle API, consulta nella directory del repository il file: `ListaApi.md`
- [Lista API di Codex](lista-api.md).

## Descrizione del Progetto

Codex è un'applicazione backend Laravel che fornisce API RESTfull per la gestione di un ipotetico sito di streaming video online.
Il codice gestisce tutte le chiamate alle API necessarie per gestire le seguenti tabelle:
- tipo_indirizzi,
- indirizzi,
- recapiti,
- tipo_reacpiti,
- contatti,
- crediti,
- password,
- contatti_auths,
- sessioni,
- accessi,
- film,
- serie TV,
- episodi
- files,
- comuni_italiani,
- nazioni,
- configurazioni,
- ruoli,
- stati,
- abilita,
- abilita_ruoli,
- contatti_ruoli,
- categorie,
- generi,
Tutte le tabelle, le relazioni e i controller sono implementati utilizzando Laravel. L'applicazione include un sistema di autenticazione JWT a due fasi.
Le API sono suddivise in accesso pubblico, accesso admin e accesso utente-admin, in base all'ID del ruolo consultabile dal token JWT.

## Funzionalità

- **Gestione Utenti**: Creazione, aggiornamento ed eliminazione di utenti con le loro informazioni.
- **Autenticazione**: Autenticazione basata su JWT con autenticazione a due fattori per una maggiore sicurezza.
- **Controllo Accessi**: Differenziazione tra accesso pubblico, accesso amministratore e accesso utente-amministratore in base all'ID del ruolo incorporato nel JWT.
- **Gestione Contenuti**: Operazioni CRUD per film, serie TV, file, ecc.
- **Localizzazione**: Supporto per comuni italiani e nazioni.
- **Permessi Basati sui Ruoli**: Definizione di ruoli e delle relative abilità per controllare l'accesso.
- **Visualizzazione Cataloghi**: Gli utenti possono consultare i filme e serie tv disponibili divisi anceh in categorie e generi


