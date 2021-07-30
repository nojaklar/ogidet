# ogidet
========

Formål
------
Formålet med denne web appen er å gjøre jobbing med høyfrekvente ordlister morsomt og effektivt.
For å gjøre arbeidet morsomt er det implementer elementer av spillifisering/gamification. Dette er gjort gjennom forskjellige stjerner og merker.
For å gjøre arbeidet effektivt er det implementer algoritmer som identifiserer ord som er lært så fort som mulig slik at man ikke trenger bruke tid på ord man kan lese.


Teknologi
---------
Web appen utvikles i php og mysql.

Status
------
Web appen virker men er ikke ferdig utviklet. Det er mulig å teste appen på denne siden link.


Installasjon
------------
For å kjøre/installere appen trenger man php 7.x og mysql 8.x. samt en webserver. Det finnes mange installasjonsveildeninger for dette på internett.
Filene i git repositoret kopieres til aktuell mappe på webserveren.
Database objekter lages basert på informasjonen i \database\lage_database_objekter.sql


Konfigurasjon 
-------------
Filen dp.php oppdateres til å passe den installerte mysql serveren.


Hvordan spiller man
-------------------
Web appen krever 2 personer, en elev og en lærer. Kravet til læreren er at personen kan lese normalt fort.
Eleven leser ordet på skjermen, når ordet er lest riktig trykker læreren på "neste" knappen. Da kommer det ett nytt ord opp. Dette repiteres så lenge man ønsker.


