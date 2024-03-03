### TURKISH ###

Dosyaları zip içerisinden bulunduğu dizine çıkarın.

cPanel içerisinden veritabanı ve kullanıcı oluşturup tüm izinleri verin.

Şifre sıfırlaması için veritabanı dosyası içerisinde kullanıcılar tablosunda yer alan mail adresini değiştirmeyi unutmayın.

Düzenlemeleri gerçekleştirin:
Cron işlemleri için aşağıda belirtilen değerlere göre eklemesini yapın.
0 23 * * * /usr/local/bin/php /path_to/cron.php
0,30 * * * * /usr/local/bin/php /path_to/feed.php
0 23 * * * /usr/local/bin/php /path_to/sitemap.xml

robots.txt dosyasındaki site adresinizi değiştirin.

config.php dosyası içerisinde yer alan FIRST açıklama satırı, 7, 8 ve 45. satırları düzenleyin.

Veritabanı bağlantısı için "core/database.php" dosyasını açıp 8 ile 11 arasındaki satırları kendinize göre düzenleyin.

Google reCaptcha için ise "admin/login.php" dosyasını açın ve kendi "Site Key"iniz ile değiştirin. Eğer bulamıyorsanız "data-sitekey" değerini aratın.

Blog siteniz kullanıma hazır, cron job ile her gün saat 11 de otomatik olarak sitemap isteği göndermektedir.

Kullanıcı adı - Şifre
admin

### ENGLISH ###

Extract the files from the zip to the directory where they are located.

Create a database and user from the cPanel and grant all permissions.

Don't forget to change the mail address in the users table in the database file for password reset.

Carry out the arrangements:
For Cron operations, make it add according to the values specified below.
0 23 * * * / usr/local/bin/php /path_to/cron.php
0,30 * * * * / usr/local/bin/php /path_to/feed.php
0 23 * * * / usr/local/bin/php /path_to/sitemap.xml

Change your site address in the robots.txt file.

the FIRST description line in the config.php file is located at 7, 8 and 45. edit the lines.

For database connection, open the "core/database.php" file and Decode the lines between 8 and 11 according to yourself.

For Google reCAPTCHA, open the "admin/login.php" file and replace it with your own "Site Key". If you can't find it, search for the "data-sitekey" value.

Your blog site is ready for use, and cron job automatically sends sitemap requests at 11 a.m. every day.