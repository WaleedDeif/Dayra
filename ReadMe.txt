1- Make new Database called dayra
2- go to dayra-task folder
3- go to .env file and add you smtp credentials
4- rung the following
	composer dump-auto
	php artisan config:cache
	php artisan migrate:fresh --seed
	php artisan passport:install
	php artisan serve
5- the admin credentails to be used at the login endpoint 
email: w.hamdydeif@gmail.com
password: secret
6- ypu can find 3 endpoints at the attached postman collection