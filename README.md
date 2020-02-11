# Currency Rates

www.bank.lv pieejamo valūtu kursu attēlojums.

Soļi lokālai projekta uzstādīšanai:
1. `git clone https://github.com/memele/currency-rates.git`
2. `cd currency-rates`
3. `git checkout development`
4. `docker-compose up -d --build database && docker-compose up -d --build app && docker-compose up -d --build web`
5. `docker exec -it currency_rates sh`
6. `php artisan migrate --seed` - reizē ar migrācijām tiek saglabāti iepriekšējā un tekošā mēneša valūtu kursi.
7. Mājaslapa pieejama `http://localhost:8990/`


<hr>

Pieejamās Artisan komandas:

`php artisan rates:archive {month} {year}`
Saglabā arhivētos valūtu kursus pēc norādītā mēneša un gada.

`php artisan rates:get {day} {month} {year}`
Saglabā valūtu kursus konkrētā datumā, norādot dienu, mēnesi un gadu.

`php artisan rates:update`
Saglabā jaunākos pieejamos valūtu kursus.
