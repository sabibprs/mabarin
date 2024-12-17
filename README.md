# Mabar.in - Cari Tim Mabar

## Instalasi
Pilih salah satu dari langkah berikut, antara [Clone Repo](#clone-repo) atau [Download sebagai Zip file](#download-sebagai-zip).
#### Clone Repo
> Sebelum mengkloning, pastikan [git](https://git-scm.com/downloads) telah di install di komputer masing-masing. 
>
> Jika belum, kamu dapat mengikuti [tutorial ini untuk windows](https://youtu.be/RK_6D18AyIs?t=83) atau [artikel ini untuk linux](https://fiki.tech/how-to-install-linux-on-windows-11#heading-install-oh-my-zsh)

Jalankan Kode berikut di terminal
```bash
git clone git@github.com:biteteam/mabar.in.git
```
#### Download Sebagai ZIP
[Klik disini untuk Download](https://github.com/biteteam/mabar.in/archive/refs/heads/master.zip)


## Development
Sebelum menjalankannya di local, pastikan [php](https://www.php.net/downloads.php), [composer](https://getcomposer.org/download/) dan [nodejs](https://nodejs.org/en/download/current) beserta package manager [npm](https://docs.npmjs.com/downloading-and-installing-node-js-and-npm) atau [yarn](https://classic.yarnpkg.com/lang/en/docs/install/#windows-stable) telah di install.

Atau kamu bisa mengikuti beberapa tutorial berikut untuk menginstallnya:
- [Install PHP](https://youtu.be/-hQu4IpdIDw?t=137)
- [Install Composer](https://www.youtube.com/watch?v=UhpzEne6omo&list=PLFIM0718LjIUkkIq1Ub6B5dYNb6IlMvtc&t=264s)
- [Install NodeJs](https://youtu.be/VfN1_pEdQAA?t=35)


### Install Dependencies
Setelah Semua Tools Siap, Install Dependencies terlebih dahulu, Jalankan kode berikut di terminal:
-  Install PHP Dependencies
   ```bash
   composer install
   ```
-  Install NodeJs Dependencies (Opsional Jika Ingin Recompile [TailwindCSS](https://tailwindcss.com/docs/installation)).
   
   Jika menggunakan npm
   ```bash
   npm install
   ```
   Jika menggunakan yarn
   ```bash
   yarn install
   ```


### Konfigurasi Environment Variables

Copy file `env` di root project ke file `.env`.

Atau lakukan melalui perintah di terminal 
```bash
php spark env development
```

Hapus komentar(`#`) pada bagian `app.name` dan `app.baseURL` di file [.env](https://github.com/biteteam/mabar.in/blob/0c6d86663e7f1d3504a88725ce301417e6010d6a/env#L23-L24) dan edit seperti berikut:
```env
app.name = 'MabarIn'
app.baseURL = 'http://localhost:8080/'
```

Konfigurasikan juga untuk databasenya di file [.env](https://github.com/biteteam/mabar.in/blob/0c6d86663e7f1d3504a88725ce301417e6010d6a/env#L34-L40), Lakukan sesuai dengan konfigurasi database kamu:
> Pastikan databasenya (dalam konteks contoh berikut adalah `mabar_in`) sudah dibuat.
>  
> Atau Jalankan perintah sql berikut ini untuk membuatnya.
> ```sql
> CREATE DATABASE mabar_in;
> ```
>

```env
database.default.hostname = localhost
database.default.database = mabar_in
database.default.username = USERNAME_DATABASE_KAMU
database.default.password = PASSWORD_DATABASE_KAMU
database.default.DBDriver = MySQLi
database.default.DBPrefix =
database.default.port = 3306
```

Konfigurasikan juga untuk `encryption.key` di file [.env](https://github.com/biteteam/mabar.in/blob/0c6d86663e7f1d3504a88725ce301417e6010d6a/env#L93).
Atau lakukan secara langsung dan otomatis di terminal: 
```bash
php spark key:generate
```


### Migrasi Data
Jalankan perintah migrasi berikut ini di terminal untuk membuat [table-table yang telah dikonfigurasikan](https://github.com/biteteam/mabar.in/tree/master/app/Database/Migrations):
```bash
php spark migrate:refresh
```


### Seeding Data
Jalankan perintah seeder berikut ini di terminal untuk memasukan data dummy dari [table-table yang telah dikonfigurasikan](https://github.com/biteteam/mabar.in/tree/master/app/Database/Seeds):
```bash
php spark db:seed AllSeeder
```


### Jalankan Server
Gunakan perintah berikut untuk menjalankannya:
```bash
php spark serve
```
Kemudian buka link yang muncul di browser, biasanya http://localhost:8080.

Lalu jika ingin recompile tailwindcss dan melakukan perubahan/penambahan pada attribute class di beberapa file [views](https://github.com/biteteam/mabar.in/tree/master/app/Views) atau [components](https://github.com/biteteam/mabar.in/tree/master/app/Cells/components) maka harus menjalankan perintah berikut agar tailwindss dapat merecompile class yang baru.
- Jika Menggunakan Npm
  ```bash
  npm run dev
  ```
- Jika Menggunakan Yarn
  ```bash
  yarn dev
  ```

### Build TailwindCSS Opsi
Jika ingin build yang di minify untuk production dapt menggunakan perintah:
```bash
yarn build:minify
```

Atau jika hanya ingin build yang tidak di minify, dapat menggunakan:
```bash
yarn build
```

Jika ingin recompile pada saat development, dapat menggunakan:
```bash
yarn dev
```


#### Publish
Semua source kode repository ini akan dibuka dan bisa diakses untuk publik setelah Feb/02/23 dibawah akun [biteteam](https://github.com/biteteam) ataupun [bitecore](https://github.com/bitecore) 
