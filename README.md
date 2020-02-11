# Currency Rates

www.bank.lv pieejamo valūtu kursu attēlojums.


Soļi lokālai projekta uzstādīšanai:
1. `git clone https://github.com/memele/currency-rates.git`
2. `git checkout development`
3. `docker-compose up -d --build database && docker-compose up -d --build app && docker-compose up -d --build web`
4. `docker exec -it currency_rates sh`
5. `php artisan migrate --seed` - reizē ar migrācijām tiek saglabāti iepriekšējā un tekošā mēneša valūtu kursi.
6. Mājaslapa pieejama `http://localhost:8990/`


<hr>

Pieejamās Artisan komandas:

`php artisan rates:archive {month} {year}`
Saglabā arhivētos valūtu kursus pēc norādītā mēneša un gada.

`php artisan rates:get {day} {month} {year}`
Saglabā valūtu kursus konkrētā datumā, norādot dienu, mēnesi un gadu.

`php artisan rates:update`
Saglabā jaunākos pieejamos valūtu kursus.
