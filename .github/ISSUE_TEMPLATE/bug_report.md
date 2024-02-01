Bugs

1. De dropdown die aangeeft welke stenen een speler kan plaatsen bevat ook stenen die
de speler niet meer heeft. Bovendien bevat de dropdown die aangeeft waar een speler
stenen kan plaatsen ook velden waar dat niet mogelijk is, en bevat de dropdown die
aangeeft vanaf welke posiGe een speler een steen wil verplaatsen ook velden die
stenen van de tegenstander bevatten.

2. Als wit een bijenkoningin speelt op (0, 0), en zwart op (1, 0), dan zou het een legale zet
moeten zijn dat wit zijn koningin verplaatst naar (0, 1), maar dat wordt niet toegestaan.

3. Als wit drie stenen plaatst die geen bijenkoningin zijn, mag hij als vierde zet helemaal
geen steen spelen. Het spel loopt dan dus vast. 

4. Als je een steen verplaatst, kan je daarna geen nieuwe steen spelen op het oude veld,
ook als dat volgens de regels wel zou mogen.

5. De undo-functionaliteit werkt nog niet goed. De oude zetten worden nog niet
verwijderd, en de toestand van het bord wordt niet altijd goed hersteld. Bovendien
kan je ook undo’en als er nog geen zeAen gedaan zijn, en dan lijkt het erop dat je een
toestand uit een ander spel ziet.
