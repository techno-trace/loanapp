## About LoanApp

LoanApp is a REST API based app to access loans and request a loan and repay weekly:

- Loans can have multiple loan requests
- Loan requests can have multiple loan repayments (until the full amount is paid)

# Feature Tests

- Provide checks for validation in registration, login and authentication API
- Loans, Request and Repayment functionality checks are also performed

# Todo for Booting the app

- http://loanapp.net is a proxy defined in hosts file on windows/system32/etc/drivers and

  on httpd-vhosts file in xampp/apache/conf/extra

    '<VirtualHost *:80>
        DocumentRoot "C:/xampp/htdocs/loanapp/public"
        ServerName loanapp.net
        </VirtualHost>
        <VirtualHost *:443>
         DocumentRoot "C:/xampp/htdocs/loanapp/public"
         ServerName loanapp.net
         SSLEngine on
         SSLCertificateFile "crt/loanapp.net/server.crt"
         SSLCertificateKeyFile "crt/loanapp.net/server.key"
     </VirtualHost>'

- git clone app in a folder loanapp
- Define a DB connection, set username, password in .env
- Please run below commands in sequence
- run "composer update"
- run "php artisan migrate"
- run "php artisan key:generate"
- run "php artisan db:seed" if you want seeded data after running migrate
- run "./vendor/bin/phpunit" to run all tests and to check for any issues
- run "php artisan serve" only if you're not using the proxy setup otherwise 
  you can visit loanapp.net on your browser

# App Info

- For User Authentication Laravel Sanctum has been used
- All the loans seeded are approved by default
- Postman API collection has also been shared along with this project for API documentation 
