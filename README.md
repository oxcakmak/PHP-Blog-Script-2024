# PHP Blog Script 2024
 PHP Blog Script 2024 - Released

## Support Me

This software is developed during my free time and I will be glad if somebody will support me.

Everyone's time should be valuable, so please consider donating.

[https://buymeacoffee.com/oxcakmak](https://buymeacoffee.com/oxcakmak)

### Installation
* Extract the files from the zip to the directory where they are located.
* Create a database and user from the cPanel and grant all permissions.
* Don't forget to change the mail address in the users table in the database file for password reset.

Carry out the arrangements. For Cron operations, make it add according to the values specified below.
```0 23 * * * / usr/local/bin/php /path_to/cron.php
0,30 * * * * / usr/local/bin/php /path_to/feed.php
0 23 * * * / usr/local/bin/php /path_to/sitemap.xml
```

* Change your site address in the robots.txt file.
* The FIRST description line in the config.php file is located at 7, 8 and 45. edit the lines.
* For database connection, open the "core/database.php" file and Decode the lines between 8 and 11 according to yourself.
* For Google reCAPTCHA, open the "admin/login.php" file and replace it with your own "Site Key". If you can't find it, search for the "data-sitekey" value.
* Your blog site is ready for use, and cron job automatically sends sitemap requests at 11 a.m. every day.

Username - Password: **admin**
