# Laravel 11 CRUD dengan Livewire, Volt, dan MaryUI

Proyek ini merupakan aplikasi sederhana untuk melakukan operasi CRUD (Create, Read, Update, Delete) yang dibangun menggunakan **Laravel 11**, **Livewire 3**, **Volt**, **Alpine.js**, **DaisyUI**, dan **Mary UI**. Aplikasi ini menggunakan **MySQL** sebagai basis data dan dirancang untuk manajemen produk dengan kategori dan status.

## Fitur
- **Operasi CRUD**: Mengelola produk dengan validasi.
- **Integrasi Frontend**: Memanfaatkan Livewire 3 dengan Volt, Alpine.js, DaisyUI, dan Mary UI.
- **UI Dinamis**: Termasuk modal, toast, dan tabel dinamis.

---

## Instalasi

1. Klon repositori:
   ```bash
   git clone <repository-url>
   cd <repository-folder>
   ```

2. Instal dependensi:
   ```bash
   composer install
   npm install
   ```

3. Atur file lingkungan:
   ```bash
   cp .env.example .env
   ```
   Konfigurasikan file `.env` untuk MySQL:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=<nama_database_anda>
   DB_USERNAME=<user_database_anda>
   DB_PASSWORD=<password_database_anda>
   ```

4. Jalankan migrasi:
   ```bash
   php artisan migrate
   ```

5. Jalankan aplikasi:
   ```bash
   php artisan serve
   npm run dev
   ```

---

## Skema Basis Data
Aplikasi ini menggunakan tiga tabel utama:

### 1. `kategori`
| Kolom          | Tipe       | Deskripsi             |
|----------------|------------|-----------------------|
| id_kategori    | BIGINT     | Primary Key           |
| nama_kategori  | STRING     | Nama kategori         |
| timestamps     | TIMESTAMP  | Waktu pembuatan/pembaruan |

### 2. `status`
| Kolom       | Tipe       | Deskripsi          |
|-------------|------------|--------------------|
| id_status   | BIGINT     | Primary Key        |
| nama_status | STRING     | Nama status        |
| timestamps  | TIMESTAMP  | Waktu pembuatan/pembaruan |

### 3. `produk`
| Kolom        | Tipe       | Deskripsi                    |
|--------------|------------|------------------------------|
| id_produk    | BIGINT     | Primary Key                  |
| nama_produk  | STRING     | Nama produk                  |
| harga        | INTEGER    | Harga produk                 |
| kategori_id  | BIGINT     | Foreign Key ke `kategori`    |
| status_id    | BIGINT     | Foreign Key ke `status`      |
| timestamps   | TIMESTAMP  | Waktu pembuatan/pembaruan    |

---

## Rute
- **`/`**: Menampilkan halaman utama yang berisi tabel produk.

---

## Komponen dan Fungsi
### `produk-table`
Komponen Volt Livewire ini mengelola semua operasi CRUD untuk tabel produk.

#### Fungsi:
1. **`status_id_change(value)`**:
   Mengubah variabel `status_id_default` berdasarkan nilai yang diberikan.

2. **`delete(id)`**:
   Menghapus produk berdasarkan `id` dan menampilkan notifikasi toast.

3. **`edit(id)`**:
   Menampilkan modal dengan detail produk untuk `id` tertentu. Jika `id` tidak valid, akan muncul notifikasi gagal.

4. **`edit_cancel()`**:
   Membatalkan pengeditan dan menutup modal.

5. **`update()`**:
   Memperbarui produk dengan validasi dan menampilkan notifikasi berhasil jika sukses.

6. **`insert()`**:
   Menambahkan produk baru dengan validasi dan menampilkan notifikasi toast.

7. **`with`**:
   Fungsi Volt untuk merender komponen. Data tabel produk yang diambil pertama adalah status produk dengan "bisa dijual" namun pengguna dapat memilih kembali di bagian filter.

#### Aturan Validasi:
```php
$validated = $this->validate([ 
    'nama_produk' => 'required|string|max:255',
    'harga' => 'required|integer|gte:0',
    'kategori_id' => 'required|exists:kategori,id_kategori',
    'status_id' => 'required|exists:status,id_status',
]);
```
##### Tampilan Error di Menambahkan dan Mengubah Produk
![image](https://github.com/user-attachments/assets/ce31fd1d-3715-41d5-8c7f-e77edcdd71df)

---

## Tata Cara Menggunakan Dengan Tangkapan Layar
### Tampilan Tabel
![image](https://github.com/user-attachments/assets/b4002e82-b8bf-4faa-b4ac-a23db597b812)

### Filter
1. Klik tombol **filter** diatas tabel
2. Pilih data yang ingin ditampilkan
![image](https://github.com/user-attachments/assets/01eab937-399c-4be3-9e89-55047933b106)

### Tampilan Menambahkan Produk
1. Klik tombol **tambah** diatas tabel
2. Kemudian isi semua input yang tersedia
3. Jika sudah dirasa benar, klik simpan
4. Jika berhasil akan muncul pemberitahuan **Berhasil menambahkan**
![image](https://github.com/user-attachments/assets/87a31cc0-9963-4736-a3d1-d9525faa1f13)
![image](https://github.com/user-attachments/assets/335f5bec-72bd-427b-8b47-cd1bd2ca8c74)

### Tampilan Mengubah Produk
1. Klik tombol **pensil** disalah satu data atau baris
2. Kemudian ubah bagian yang ingin diubah
3. Jika sudah dirasa benar, klik simpan perubahan
4. Jika berhasil akan muncul pemberitahuan **Berhasil mengubah**
![image](https://github.com/user-attachments/assets/d211a4ce-7e8e-42b4-bcb6-f943d7639bad)
![image](https://github.com/user-attachments/assets/050fd524-7a1e-428e-b684-d23a58dc9162)

## Tampilan Menghapus Produk
1. Klik tombol **sampah** disalah satu data atau baris
2. Akan muncul peringatan
3. Jika **oke** maka data akan dihapus dan **cancel** untuk membatalkan
4. Jika berhasil akan muncul pemberitahuan **Berhasil menghapus**
![image](https://github.com/user-attachments/assets/dc9f7608-2f05-4ae8-b228-cec62630a693)
![image](https://github.com/user-attachments/assets/fb07a009-5473-479d-94c1-416baa935a64)

---

## Teknologi yang Digunakan
- **Laravel 11**: Framework backend.
- **Livewire 3**: Frontend reaktif untuk Laravel.
- **Volt**: Komponen dan utilitas Blade.
- **DaisyUI**: Komponen berbasis Tailwind CSS.
- **Mary UI**: UI tambahan untuk Tailwind CSS.
- **Alpine.js**: Framework JavaScript untuk interaktivitas.
- **MySQL**: Basis data relasional.

---

## Perintah Pengembangan
- Menjalankan server pengembangan:
  ```bash
  php artisan serve
  npm run dev
  ```

- Menjalankan migrasi:
  ```bash
  php artisan migrate
  ```

---

## Lisensi
Proyek ini bersifat open-source dan tersedia di bawah [MIT License](LICENSE).

---

Untuk pertanyaan atau kontribusi, silakan buat issue atau pull request.

