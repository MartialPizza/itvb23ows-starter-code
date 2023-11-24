Feature requests

1. De sprinkhaan is nog niet geïmplementeerd. Implementeer de regels om deze steen
te bewegen.
  a. Een sprinkhaan verplaatst zich door in een rechte lijn een sprong te maken
  naar een veld meteen achter een andere steen in de richting van de sprong.
  b. Een sprinkhaan mag zich niet verplaatsen naar het veld waar hij al staat.
  c. Een sprinkhaan moet over minimaal één steen springen.
  d. Een sprinkhaan mag niet naar een bezet veld springen.
  e. Een sprinkhaan mag niet over lege velden springen. Dit betekent dat alle
  velden tussen de start- en eindpositie bezet moeten zijn.

2. De soldatenmier is nog niet geïmplementeerd. Implementeer de regels om deze steen
te bewegen.
  a. Een soldatenmier verplaatst zich door een onbeperkt aantal keren te
  verschuiven
  b. Een verschuiving is een zet zoals de bijenkoningin die mag maken.
  c. Een soldatenmier mag zich niet verplaatsen naar het veld waar hij al staat.
  d. Een soldatenmier mag alleen verplaatst worden over en naar lege velden.

3. De spin is nog niet geïmplementeerd. Implementeer de regels om deze steen te
bewegen.
  a. Een spin verplaatst zich door precies drie keer te verschuiven.
  b. Een verschuiving is een zet zoals de bijenkoningin die mag maken.
  c. Een spin mag zich niet verplaatsen naar het veld waar hij al staat.
  d. Een spin mag alleen verplaatst worden over en naar lege velden.
  e. Een spin mag tijdens zijn verplaatsing geen stap maken naar een veld waar hij
  tijdens de verplaatsing al is geweest.

4. De regels wanneer je mag passen zijn nog niet geïmplementeerd. Implementeer deze
regels.
  a. Een speler mag alleen passen als hij geen enkele steen kan spelen of
  verplaatsen, dus als hij geen enkele andere geldige zet heeft.

5. Het spel geeft nog niet aan wanneer iemand gewonnen heeft of wanneer er sprake is
van een gelijkspel.
  a. Een speler wint als alle zes velden naast de bijenkoningin van de tegenstander
  bezet zijn.
  b. Als beide spelers tegelijk zouden winnen is het in plaats daarvan een gelijkspel.

6. Voeg de mogelijkheid toe om tegen een AI te spelen. Op de Github-repository hanzehbo-ict/itvb23ows-hive-ai vind je een Python-implementaGe van een AI. Deze AI moet
in een aparte container draaien, en de PHP-applicaGe moet HTTP-requests gebruiken
om de AI aan te spreken. Je kan de documentatie van de API vinden in de README.md
in repository van de API.
Mogelijk zal de AI zetten doen die ongeldig zijn op grond van de interpretatie van de
regels zoals je applicaGe die heeft, maar dit mag je negeren. Je mag gewoon de zet
uitvoeren die de AI voorstelt, ook als deze niet geldig is.
