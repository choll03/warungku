
## Cara menjalankan

 Masuk directory
 
- cd /htdocs/warungku

 Untuk yang belum pernah menjalankan aplikasi nya
 install composer lalu jalankan perintah

- composer install

 Lalu jalankan perintah dibawah ini

 buat database baru "nama_database"
 
 edit file .env dengan "nama_database", "username" dan "password"

 kemudian jalankan perintah artisan berikut

- php artisan key:generate
- php artisan migrate

 jika sudah selesai semua jalankan server

- php artisan serve
