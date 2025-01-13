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
   Fungsi Volt untuk merender komponen.

#### Aturan Validasi:
```php
$validated = $this->validate([ 
    'nama_produk' => 'required|string|max:255',
    'harga' => 'required|integer|gte:0',
    'kategori_id' => 'required|exists:kategori,id_kategori',
    'status_id' => 'required|exists:status,id_status',
]);
```

---

## Tangkapan Layar
### Proses CRUD
![Screenshot Proses CRUD](path-to-crud-screenshot.png)

### Tabel Produk
![Screenshot Tabel Produk](path-to-table-screenshot.png)

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

