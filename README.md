# SIAKAD - Sistem Informasi Akademik

## Tech Stack
- Laravel 12
- MySQL
- Blade + Tailwind CSS
- Laravel Breeze (Authentication)

---

## Fitur yang Sudah Diimplementasikan

### 1. Autentikasi & Otorisasi

| Fitur | Status | Keterangan |
|-------|--------|------------|
| Login | ✅ | Email & password |
| Logout | ✅ | |
| Registrasi Mahasiswa Baru | ✅ | Self-registration dengan status pending |
| Role-based Access | ✅ | 4 role: admin_fakultas, admin_prodi, dosen, mahasiswa |
| Middleware Role | ✅ | Proteksi route berdasarkan role |
| Middleware Active User | ✅ | Cek user aktif |
| Middleware Student Approved | ✅ | Cek mahasiswa sudah diverifikasi |
| Update Profile | ✅ | Nama & email |
| Update Password | ✅ | |
| Update Info Pribadi Mahasiswa | ✅ | Phone, gender, alamat, TTL |
| Hapus Akun | ✅ | |

---

### 2. Admin Fakultas

| Fitur | Status | Keterangan |
|-------|--------|------------|
| CRUD Fakultas | ✅ | Kode & nama fakultas |
| CRUD Program Studi | ✅ | Kode, nama, jenjang (S1/S2/D3) |
| CRUD Dosen | ✅ | NIDN, user account, prodi |

---

### 3. Admin Prodi

| Fitur | Status | Keterangan |
|-------|--------|------------|
| CRUD Kurikulum | ✅ | Tahun, status aktif |
| CRUD Mata Kuliah | ✅ | Kode, nama, SKS, semester, prasyarat |
| CRUD Jadwal Kuliah | ✅ | Hari, jam, ruang, dosen, tahun akademik |
| CRUD Mahasiswa | ✅ | Data mahasiswa manual |
| Verifikasi Calon Mahasiswa | ✅ | Approve/reject pendaftaran |
| Generate NIM Otomatis | ✅ | Saat approve mahasiswa baru |
| Approval DKBS | ✅ | Setujui/tolak DKBS mahasiswa |

---

### 4. Dosen

| Fitur | Status | Keterangan |
|-------|--------|------------|
| Lihat Jadwal Mengajar | ✅ | Daftar kelas yang diampu |
| Input Nilai | ✅ | Tugas, UTS, UAS |
| Hitung Nilai Akhir Otomatis | ✅ | Formula: (Tugas×30% + UTS×30% + UAS×40%) |
| Konversi Nilai Huruf | ✅ | A (≥85), B (≥70), C (≥55), D (≥40), E (<40) |
| Kunci Nilai | ✅ | Nilai tidak bisa diubah setelah dikunci |
| Indikator Nilai Terkunci | ✅ | Banner & status per mahasiswa |

---

### 5. Mahasiswa

| Fitur | Status | Keterangan |
|-------|--------|------------|
| Registrasi Akun | ✅ | Self-registration |
| Status Pending | ✅ | Menunggu verifikasi admin |
| DKBS (Kartu Rencana Studi) | ✅ | Pilih mata kuliah per semester |
| Semester Otomatis | ✅ | Dihitung dari tahun masuk |
| Validasi Max SKS | ✅ | Maksimal 24 SKS per semester |
| Validasi Jadwal Bentrok | ✅ | Cek overlap waktu |
| Status DKBS | ✅ | Draft → Submitted → Approved |
| Lihat Jadwal Kuliah | ✅ | Jadwal dari DKBS yang approved |
| Lihat Nilai | ✅ | Per mata kuliah |
| Lihat Transkrip | ✅ | Rekap nilai per semester |
| Update Info Pribadi | ✅ | Phone, gender, alamat, TTL |

---

## Struktur Database

### users
| Field | Tipe | Keterangan |
|-------|------|------------|
| id | bigint | PK |
| name | string | |
| email | string | unique |
| email_verified_at | timestamp | nullable |
| password | string | |
| role | enum | admin_fakultas, admin_prodi, dosen, mahasiswa (default: mahasiswa) |
| is_active | boolean | default: true |
| remember_token | string | nullable |
| created_at | timestamp | |
| updated_at | timestamp | |

Index: `email` (unique), `role`, `is_active`

---

### faculties
| Field | Tipe | Keterangan |
|-------|------|------------|
| id | bigint | PK |
| code | string | unique |
| name | string | |
| created_at | timestamp | |
| updated_at | timestamp | |

Index: `code` (unique), `name`

---

### study_programs
| Field | Tipe | Keterangan |
|-------|------|------------|
| id | bigint | PK |
| faculty_id | bigint | FK → faculties (cascade delete) |
| code | string | unique |
| name | string | |
| degree | string | S1, S2, D3 |
| created_at | timestamp | |
| updated_at | timestamp | |

Index: `faculty_id` (auto), `code` (unique), `degree`

---

### students
| Field | Tipe | Keterangan |
|-------|------|------------|
| id | bigint | PK |
| user_id | bigint | FK → users (cascade delete) |
| nim | string | unique, nullable (sebelum approve) |
| study_program_id | bigint | FK → study_programs (cascade delete) |
| year_of_entry | year | Tahun masuk |
| status | enum | aktif, cuti, lulus (default: aktif) |
| registration_status | enum | pending, approved, rejected (default: pending) |
| phone | string | nullable |
| address | text | nullable |
| birth_date | date | nullable |
| birth_place | string | nullable |
| gender | enum | L, P (nullable) |
| created_at | timestamp | |
| updated_at | timestamp | |

Index: `nim` (unique), `user_id` (auto), `study_program_id` (auto), `status`, `year_of_entry`

---

### lecturers
| Field | Tipe | Keterangan |
|-------|------|------------|
| id | bigint | PK |
| user_id | bigint | FK → users (cascade delete) |
| nidn | string | unique |
| study_program_id | bigint | FK → study_programs (cascade delete) |
| created_at | timestamp | |
| updated_at | timestamp | |

Index: `nidn` (unique), `user_id` (auto), `study_program_id` (auto)

---

### curriculums
| Field | Tipe | Keterangan |
|-------|------|------------|
| id | bigint | PK |
| study_program_id | bigint | FK → study_programs (cascade delete) |
| year | year | Tahun kurikulum |
| is_active | boolean | default: true |
| created_at | timestamp | |
| updated_at | timestamp | |

Index: `study_program_id` (auto), `year`, `is_active`

---

### courses
| Field | Tipe | Keterangan |
|-------|------|------------|
| id | bigint | PK |
| curriculum_id | bigint | FK → curriculums (cascade delete) |
| code | string | |
| name | string | |
| sks | integer | |
| semester | integer | 1-8 |
| prerequisite_course_id | bigint | FK → courses (null on delete), nullable |
| created_at | timestamp | |
| updated_at | timestamp | |

Index: `curriculum_id` (auto), `code`, `semester`, `prerequisite_course_id` (auto)

---

### schedules - SOFT DELETE
| Field | Tipe | Keterangan |
|-------|------|------------|
| id | bigint | PK |
| course_id | bigint | FK → courses (cascade delete) |
| lecturer_id | bigint | FK → lecturers (cascade delete) |
| day | enum | senin, selasa, rabu, kamis, jumat, sabtu |
| start_time | time | |
| end_time | time | |
| room | string | |
| academic_year | string | contoh: 2025/2026 |
| semester_type | enum | ganjil, genap |
| created_at | timestamp | |
| updated_at | timestamp | |
| deleted_at | timestamp | Soft delete |

Index: `course_id` (auto), `lecturer_id` (auto), `academic_year`, `semester_type`
Composite Index: `(day, start_time, end_time)`

---

### dkbs
| Field | Tipe | Keterangan |
|-------|------|------------|
| id | bigint | PK |
| student_id | bigint | FK → students (cascade delete) |
| academic_year | string | contoh: 2025/2026 |
| semester | integer | Semester mahasiswa |
| status | enum | draft, submitted, approved (default: draft) |
| created_at | timestamp | |
| updated_at | timestamp | |

Index: `student_id` (auto), `status`
Unique: `(student_id, academic_year, semester)`

---

### dkbs_details
| Field | Tipe | Keterangan |
|-------|------|------------|
| id | bigint | PK |
| dkbs_id | bigint | FK → dkbs (cascade delete) |
| schedule_id | bigint | FK → schedules (cascade delete) |
| created_at | timestamp | |
| updated_at | timestamp | |

Index: `dkbs_id` (auto), `schedule_id` (auto)
Unique: `(dkbs_id, schedule_id)`

---

### grades
| Field | Tipe | Keterangan |
|-------|------|------------|
| id | bigint | PK |
| dkbs_detail_id | bigint | FK → dkbs_details (cascade delete) |
| tugas | decimal(5,2) | nullable |
| uts | decimal(5,2) | nullable |
| uas | decimal(5,2) | nullable |
| final_score | decimal(5,2) | nullable |
| grade_letter | char(1) | A-E, nullable |
| is_locked | boolean | default: false |
| created_at | timestamp | |
| updated_at | timestamp | |

Index: `dkbs_detail_id` (auto), `grade_letter`

---

### transcripts
| Field | Tipe | Keterangan |
|-------|------|------------|
| id | bigint | PK |
| student_id | bigint | FK → students (cascade delete) |
| semester | integer | |
| gpa | decimal(4,2) | IP semester |
| cgpa | decimal(4,2) | IPK kumulatif, nullable |
| created_at | timestamp | |
| updated_at | timestamp | |

Index: `student_id` (auto)
Unique: `(student_id, semester)`

---

## Batasan & Keterbatasan

### Autentikasi
- Tidak ada fitur lupa password (reset via email)
- Tidak ada email verification
- Tidak ada 2FA (Two-Factor Authentication)

### Akademik
- Prasyarat mata kuliah belum divalidasi saat DKBS (hanya disimpan di database)
- Tidak ada validasi nilai minimum untuk lulus mata kuliah prasyarat
- Tidak ada fitur cuti akademik (hanya status di database)
- Tidak ada pembatasan periode DKBS (kapan boleh buat/edit)
- Tidak ada fitur pembatalan DKBS oleh admin

### Jadwal
- Tidak ada fitur jadwal ujian terpisah
- Tidak ada tampilan kalender (hanya tabel)
- Tidak ada notifikasi jadwal

### Nilai
- Tidak ada fitur banding nilai
- Tidak ada histori perubahan nilai (audit log)
- Bobot nilai fixed (30% tugas, 30% UTS, 40% UAS)

### Transkrip
- IP/IPK belum dihitung otomatis dari nilai
- Tidak ada grafik progres nilai

### Umum
- Tidak ada audit log (created_by, updated_by)
- Tidak ada notifikasi (email/push)
- Tidak ada fitur upload dokumen
- Tidak ada multi-bahasa
- Tidak ada dark mode

---

## Akun Default (Seeder)

| Role | Email | Password |
|------|-------|----------|
| Admin Fakultas | admin.fakultas@siakad.test | password |
| Admin Prodi | admin.prodi@siakad.test | password |
| Dosen | dosen@siakad.test | password |
| Mahasiswa | mahasiswa@siakad.test | password |
---

## Perhitungan Semester Otomatis

```
semester = (tahun_akademik - tahun_masuk) × 2 + (1 jika ganjil, 2 jika genap)
```

**Contoh:** Mahasiswa masuk 2025, tahun akademik 2027/2028 semester ganjil:
- (2027 - 2025) × 2 + 1 = 5 (Semester 5)

**Tahun Akademik:**
- Ganjil: Agustus - Januari
- Genap: Februari - Juli

---

## Generate NIM Otomatis

Format NIM: `[PRODI][TAHUN][URUTAN]`

```
NIM = [2 digit ID Prodi] + [2 digit tahun] + [4 digit urutan]
```

**Komponen:**
| Bagian | Panjang | Keterangan |
|--------|---------|------------|
| Prodi | 2 digit | ID program studi (padding 0 di depan) |
| Tahun | 2 digit | 2 digit terakhir tahun masuk |
| Urutan | 4 digit | Nomor urut mahasiswa di prodi & tahun tersebut |

**Contoh:**
- Prodi ID: 1 (Teknik Informatika)
- Tahun masuk: 2025
- Mahasiswa ke-5 di prodi tersebut tahun 2025

```
NIM = 01 + 25 + 0005 = 01250005
```

**Cara Kerja:**
1. Ambil ID prodi, padding jadi 2 digit → `01`
2. Ambil 2 digit terakhir tahun masuk → `25`
3. Cari NIM terakhir di prodi & tahun yang sama
4. Increment nomor urut → `0005`
5. Gabungkan semua → `01250005`

---

## Validasi DKBS

1. ✅ Status mahasiswa harus "aktif"
2. ✅ Registration status harus "approved"
3. ✅ Belum ada DKBS untuk semester yang sama
4. ✅ Total SKS maksimal 24
5. ✅ Tidak ada jadwal yang bentrok