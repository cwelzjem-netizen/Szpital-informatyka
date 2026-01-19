:
Technologia SPA: Aplikacja musi działać jako jednostronicowa strona (Single Page Application) wykorzystująca biblioteki React, React Router oraz Tailwind CSS ładowane z CDN.
Trwałość danych: Stan gry (lista wyleczonych pacjentów i wynik punktowy) musi być zapisywany i odczytywany z localStorage przeglądarki.
Dashboard statystyk: Strona główna musi wyświetlać liczbę pacjentów wyleczonych, oczekujących oraz pasek postępu procentowego.
Lista pacjentów: System musi prezentować listę pacjentów z rozróżnieniem wizualnym i funkcjonalnym na osoby oczekujące (aktywne) i wyleczone (zablokowane).
Dynamiczne filtrowanie lekarzy: Lista wyboru lekarza w formularzu diagnozy musi automatycznie ograniczać się tylko do specjalistów z wybranego wcześniej oddziału.
Formularz diagnostyczny: Użytkownik musi mieć możliwość wyboru oddziału, lekarza, wielu badań, wielu leków oraz wpisania tekstowej diagnozy.
Algorytm punktacji: System musi oceniać diagnozę w skali 0-100 pkt, przyznając po 20 pkt za każdy poprawny element (oddział, lekarz, badania, leki, tekst diagnozy).
Walidacja sukcesu: Pacjent zostaje uznany za wyleczonego tylko wtedy, gdy diagnoza uzyska minimum 60 punktów.
Informacja zwrotna: Po zatwierdzeniu formularza musi wyświetlić się ekran z wynikiem punktowym oraz listą popełnionych błędów (np. "Zły oddział", "Błędy w lekach").
Reset postępów: Aplikacja musi posiadać przycisk umożliwiający wyczyszczenie danych z pamięci przeglądarki i rozpoczęcie gry od nowa.
