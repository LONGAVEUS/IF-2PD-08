# Proyek Sistem Informasi Pengelolaan KRS dan KHS (IF-2PD-08)

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white)

---

## 📌 Mengenal Sistem KRS & KHS

Sistem Informasi Pengelolaan Rencana Studi (KRS) dan Kartu Hasil Studi (KHS) merupakan platform berbasis web yang dirancang untuk mendigitalisasi, mempercepat, dan mengamankan siklus akademik mahasiswa setiap semesternya. 

Aplikasi ini dibangun menggunakan framework **Laravel** dengan arsitektur **MVC (Model-View-Controller)** serta menerapkan pilar-pilar penting **Object-Oriented Programming (OOP)** seperti *Abstraction*, *Inheritance*, dan *Encapsulation* untuk memisahkan logika bisnis database dari lapisan antarmuka. Sistem ini memastikan pengelolaan kuota SKS, pembagian kelas dosen pengampu, hingga otomatisasi konversi nilai huruf berjalan secara *real-time* tanpa perlu manipulasi data manual di database server.

---

## 👥 Pengguna Aplikasi (User Roles)

Sistem ini membagi hak akses ke dalam 3 jenis pengguna dengan batas fungsionalitas yang terenkapsulasi secara ketat:

* [cite_start]**Administrator (Admin):** Bertindak sebagai pengelola data master pengguna (Mahasiswa, Dosen, Admin) serta konfigurasi kurikulum mata kuliah[cite: 2].
* [cite_start]**Mahasiswa (Student):** Bertindak sebagai pengguna yang menyusun mata kuliah pilihan, mengunci KRS, dan memantau lembar perkembangan nilai akademik (KHS)[cite: 4].
* [cite_start]**Dosen (Lecturer):** Bertindak sebagai evaluator akademik yang memantau daftar mahasiswa terdaftar dan menginputkan evaluasi nilai akhir mata kuliah[cite: 6].

---

## 📋 Kebutuhan Fungsional Sistem (Functional Requirements)

[cite_start]Berdasarkan matriks skenario pengujian aplikasi, berikut adalah daftar kebutuhan fungsional yang diimplementasikan ke dalam sistem[cite: 2, 4, 6]:

### 1. Hak Akses Global & Autentikasi
| ID | Komponen | Deskripsi Fitur / Skenario Pengujian |
| :--- | :--- | :--- |
| **FR-01** | **Autentikasi Multi-User** | [cite_start]Sistem mendukung proses masuk log (Login) bagi Admin, Dosen, dan Mahasiswa[cite: 2]. [cite_start]Menyediakan penolakan eror jika password salah atau status akun tidak aktif[cite: 2]. |

### 2. Manajemen Data Master (Sisi Administrator)
| ID | Komponen | Deskripsi Fitur / Skenario Pengujian |
| :--- | :--- | :--- |
| **FR-02** | **Kelola Data Mata Kuliah** | [cite_start]Admin dapat menambah mata kuliah baru (Kode MK, SKS, Nama, Semester, Dosen Pengampu)[cite: 2]. [cite_start]Sistem menolak kode MK duplikat, serta mendukung fitur edit dan hapus data[cite: 2]. |
| **FR-03** | **Kelola Data Mahasiswa** | [cite_start]Admin dapat mendaftarkan mahasiswa baru (NIM, Nama, Prodi, Semester, Status)[cite: 2]. [cite_start]Sistem menolak NIM duplikat, serta mendukung manipulasi update data dan hapus dari sistem[cite: 2]. |
| **FR-04** | **Kelola Data Dosen** | [cite_start]Admin dapat mendaftarkan dosen baru (NIDN/NIP, Nama, Prodi, Status)[cite: 2]. [cite_start]Sistem menolak NIDN duplikat, serta mendukung perubahan profil data dan hapus data dosen[cite: 2]. |
| **FR-05** | **Kelola Data Admin** | [cite_start]Admin dapat menambah akun admin operasional baru (NIP, Nama, Status)[cite: 2]. [cite_start]Sistem mendeteksi NIP duplikat, mendukung edit nama/password, serta penghapusan akun admin[cite: 2]. |

### 3. Modul Pengisian Rencana Studi (Sisi Mahasiswa)
| ID | Komponen | Deskripsi Fitur / Skenario Pengujian |
| :--- | :--- | :--- |
| **FR-06** | **Dashboard Mahasiswa** | [cite_start]Sistem menampilkan halaman Dashboard Mahasiswa setelah proses autentikasi berhasil[cite: 4]. |
| **FR-07** | **Isi KRS (Course Registration)** | [cite_start]Mahasiswa dapat menambah mata kuliah pilihan ke rencana studi[cite: 4]. [cite_start]Sistem memberikan peringatan jika melebihi batas 24 SKS atau KRS kosong[cite: 4]. [cite_start]Mendukung hapus pilihan (pembatalan) serta konfirmasi simpan KRS[cite: 4]. |
| **FR-08** | **Lihat KHS (View Transcript)** | [cite_start]Mahasiswa dapat mengakses lembar KHS untuk melihat hasil studi akhir yang telah diterbitkan setelah KRS disimpan[cite: 4]. |

### 4. Modul Evaluasi Akademik (Sisi Dosen)
| ID | Komponen | Deskripsi Fitur / Skenario Pengujian |
| :--- | :--- | :--- |
| **FR-09** | **Dashboard Dosen** | [cite_start]Dosen dapat masuk ke halaman utama yang menyajikan daftar kelas mahasiswa terdaftar[cite: 6]. |
| **FR-10** | **Input & Update Nilai** | [cite_start]Dosen memilih mata kuliah untuk melihat list mahasiswa, serta dapat memfilter berdasarkan semester[cite: 6]. [cite_start]Dosen menginput `nilai_angka` (skala 0-100) yang otomatis mengonversi `nilai_huruf` dan `bobot` secara instan pada KHS mahasiswa[cite: 6]. [cite_start]Sistem otomatis membatasi input di luar jangkauan 0-100[cite: 6]. |

---

## 🛠️ Prasyarat Instalasi (Tech Stack)

Untuk menjalankan proyek ini di komputer lokal Anda, pastikan telah memasang dependensi berikut:
* PHP >= 8.2 (Disarankan lokasi folder murni lokal/bukan di bawah sinkronisasi service cloud)
* Composer >= 2.x
* MySQL / MariaDB Server
* Web Browser (Chrome / Edge / Firefox)
