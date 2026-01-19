<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Curriculum;
use App\Models\Faculty;
use App\Models\Lecturer;
use App\Models\Schedule;
use App\Models\StudyProgram;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AcademicDataSeeder extends Seeder
{
    public function run(): void
    {
        $fakultasTeknik = Faculty::firstOrCreate(
            ['code' => 'FT'],
            ['name' => 'Fakultas Teknik']
        );

        $prodiTI = StudyProgram::firstOrCreate(
            ['code' => 'TI'],
            [
                'faculty_id' => $fakultasTeknik->id,
                'name' => 'Teknik Informatika',
                'degree' => 'S1',
            ]
        );

        $kurikulum2026 = Curriculum::firstOrCreate(
            ['study_program_id' => $prodiTI->id, 'year' => 2026],
            ['is_active' => true]
        );

        // Dosen
        $lecturers = $this->createLecturers($prodiTI);

        // Mata Kuliah Semester 1-8
        $courses = $this->createCourses($kurikulum2026);

        // Jadwal Kuliah
        $this->createSchedules($courses, $lecturers);
    }

    private function createLecturers(StudyProgram $prodi): array
    {
        $dosenData = [
            ['name' => 'Dr. Ahmad Fauzi, M.Kom.', 'nidn' => '0101018001', 'email' => 'ahmad.fauzi@siakad.test'],
            ['name' => 'Dr. Budi Santoso, M.T.', 'nidn' => '0102018002', 'email' => 'budi.santoso@siakad.test'],
            ['name' => 'Ir. Citra Dewi, M.Sc.', 'nidn' => '0103018003', 'email' => 'citra.dewi@siakad.test'],
            ['name' => 'Dr. Dian Permata, M.Kom.', 'nidn' => '0104018004', 'email' => 'dian.permata@siakad.test'],
            ['name' => 'Eko Prasetyo, S.Kom., M.T.', 'nidn' => '0105018005', 'email' => 'eko.prasetyo@siakad.test'],
            ['name' => 'Dr. Fitri Handayani, M.Kom.', 'nidn' => '0106018006', 'email' => 'fitri.handayani@siakad.test'],
            ['name' => 'Gunawan Wibowo, S.T., M.Kom.', 'nidn' => '0107018007', 'email' => 'gunawan.wibowo@siakad.test'],
            ['name' => 'Dr. Hendra Kusuma, M.T.', 'nidn' => '0108018008', 'email' => 'hendra.kusuma@siakad.test'],
        ];

        $lecturers = [];
        foreach ($dosenData as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make('password'),
                    'role' => 'dosen',
                    'is_active' => true,
                ]
            );

            $lecturers[] = Lecturer::firstOrCreate(
                ['nidn' => $data['nidn']],
                [
                    'user_id' => $user->id,
                    'study_program_id' => $prodi->id,
                ]
            );
        }

        return $lecturers;
    }

    private function createCourses(Curriculum $kurikulum): array
    {
        $mataKuliah = [
            // Semester 1
            ['code' => 'TI101', 'name' => 'Algoritma dan Pemrograman', 'sks' => 4, 'semester' => 1, 'prerequisite' => null],
            ['code' => 'TI102', 'name' => 'Matematika Diskrit', 'sks' => 3, 'semester' => 1, 'prerequisite' => null],
            ['code' => 'TI103', 'name' => 'Pengantar Teknologi Informasi', 'sks' => 2, 'semester' => 1, 'prerequisite' => null],
            ['code' => 'TI104', 'name' => 'Kalkulus I', 'sks' => 3, 'semester' => 1, 'prerequisite' => null],
            ['code' => 'TI105', 'name' => 'Bahasa Inggris I', 'sks' => 2, 'semester' => 1, 'prerequisite' => null],
            ['code' => 'TI106', 'name' => 'Pendidikan Pancasila', 'sks' => 2, 'semester' => 1, 'prerequisite' => null],

            // Semester 2
            ['code' => 'TI201', 'name' => 'Struktur Data', 'sks' => 4, 'semester' => 2, 'prerequisite' => 'TI101'],
            ['code' => 'TI202', 'name' => 'Basis Data', 'sks' => 4, 'semester' => 2, 'prerequisite' => 'TI101'],
            ['code' => 'TI203', 'name' => 'Kalkulus II', 'sks' => 3, 'semester' => 2, 'prerequisite' => 'TI104'],
            ['code' => 'TI204', 'name' => 'Sistem Operasi', 'sks' => 3, 'semester' => 2, 'prerequisite' => null],
            ['code' => 'TI205', 'name' => 'Bahasa Inggris II', 'sks' => 2, 'semester' => 2, 'prerequisite' => 'TI105'],
            ['code' => 'TI206', 'name' => 'Pendidikan Kewarganegaraan', 'sks' => 2, 'semester' => 2, 'prerequisite' => null],

            // Semester 3
            ['code' => 'TI301', 'name' => 'Pemrograman Berorientasi Objek', 'sks' => 4, 'semester' => 3, 'prerequisite' => 'TI201'],
            ['code' => 'TI302', 'name' => 'Jaringan Komputer', 'sks' => 3, 'semester' => 3, 'prerequisite' => 'TI204'],
            ['code' => 'TI303', 'name' => 'Statistika dan Probabilitas', 'sks' => 3, 'semester' => 3, 'prerequisite' => 'TI203'],
            ['code' => 'TI304', 'name' => 'Interaksi Manusia dan Komputer', 'sks' => 3, 'semester' => 3, 'prerequisite' => null],
            ['code' => 'TI305', 'name' => 'Aljabar Linear', 'sks' => 3, 'semester' => 3, 'prerequisite' => null],

            // Semester 4
            ['code' => 'TI401', 'name' => 'Pemrograman Web', 'sks' => 4, 'semester' => 4, 'prerequisite' => 'TI301'],
            ['code' => 'TI402', 'name' => 'Rekayasa Perangkat Lunak', 'sks' => 3, 'semester' => 4, 'prerequisite' => 'TI301'],
            ['code' => 'TI403', 'name' => 'Sistem Basis Data Lanjut', 'sks' => 3, 'semester' => 4, 'prerequisite' => 'TI202'],
            ['code' => 'TI404', 'name' => 'Keamanan Sistem Informasi', 'sks' => 3, 'semester' => 4, 'prerequisite' => 'TI302'],
            ['code' => 'TI405', 'name' => 'Analisis dan Desain Sistem', 'sks' => 3, 'semester' => 4, 'prerequisite' => 'TI202'],

            // Semester 5
            ['code' => 'TI501', 'name' => 'Pemrograman Mobile', 'sks' => 4, 'semester' => 5, 'prerequisite' => 'TI401'],
            ['code' => 'TI502', 'name' => 'Kecerdasan Buatan', 'sks' => 3, 'semester' => 5, 'prerequisite' => 'TI301'],
            ['code' => 'TI503', 'name' => 'Manajemen Proyek TI', 'sks' => 3, 'semester' => 5, 'prerequisite' => 'TI402'],
            ['code' => 'TI504', 'name' => 'Data Mining', 'sks' => 3, 'semester' => 5, 'prerequisite' => 'TI303'],
            ['code' => 'TI505', 'name' => 'Cloud Computing', 'sks' => 3, 'semester' => 5, 'prerequisite' => 'TI302'],

            // Semester 6
            ['code' => 'TI601', 'name' => 'Machine Learning', 'sks' => 3, 'semester' => 6, 'prerequisite' => 'TI502'],
            ['code' => 'TI602', 'name' => 'Pengembangan Aplikasi Enterprise', 'sks' => 4, 'semester' => 6, 'prerequisite' => 'TI401'],
            ['code' => 'TI603', 'name' => 'Internet of Things', 'sks' => 3, 'semester' => 6, 'prerequisite' => 'TI302'],
            ['code' => 'TI604', 'name' => 'Etika Profesi', 'sks' => 2, 'semester' => 6, 'prerequisite' => null],
            ['code' => 'TI605', 'name' => 'Kerja Praktek', 'sks' => 2, 'semester' => 6, 'prerequisite' => null],

            // Semester 7
            ['code' => 'TI701', 'name' => 'Big Data Analytics', 'sks' => 3, 'semester' => 7, 'prerequisite' => 'TI504'],
            ['code' => 'TI702', 'name' => 'DevOps', 'sks' => 3, 'semester' => 7, 'prerequisite' => 'TI505'],
            ['code' => 'TI703', 'name' => 'Metodologi Penelitian', 'sks' => 2, 'semester' => 7, 'prerequisite' => null],
            ['code' => 'TI704', 'name' => 'Kewirausahaan', 'sks' => 2, 'semester' => 7, 'prerequisite' => null],
            ['code' => 'TI705', 'name' => 'Seminar', 'sks' => 2, 'semester' => 7, 'prerequisite' => 'TI703'],

            // Semester 8
            ['code' => 'TI801', 'name' => 'Skripsi', 'sks' => 6, 'semester' => 8, 'prerequisite' => 'TI705'],
        ];

        $courses = [];
        $courseMap = [];

        foreach ($mataKuliah as $mk) {
            $course = Course::firstOrCreate(
                ['curriculum_id' => $kurikulum->id, 'code' => $mk['code']],
                [
                    'name' => $mk['name'],
                    'sks' => $mk['sks'],
                    'semester' => $mk['semester'],
                    'prerequisite_course_id' => null,
                ]
            );
            $courses[] = $course;
            $courseMap[$mk['code']] = $course;
        }

        foreach ($mataKuliah as $mk) {
            if ($mk['prerequisite'] && isset($courseMap[$mk['prerequisite']])) {
                $courseMap[$mk['code']]->update([
                    'prerequisite_course_id' => $courseMap[$mk['prerequisite']]->id,
                ]);
            }
        }

        return $courses;
    }

    private function createSchedules(array $courses, array $lecturers): void
    {
        $days = ['senin', 'selasa', 'rabu', 'kamis', 'jumat'];
        $timeSlots = [
            ['start' => '07:30', 'end' => '09:10'],
            ['start' => '09:20', 'end' => '11:00'],
            ['start' => '11:10', 'end' => '12:50'],
            ['start' => '13:30', 'end' => '15:10'],
            ['start' => '15:20', 'end' => '17:00'],
        ];
        $rooms = ['R.101', 'R.102', 'R.103', 'R.201', 'R.202', 'R.203', 'Lab.1', 'Lab.2', 'Lab.3'];

        $academicYear = '2024/2025';
        $semesterType = 'ganjil';

        $oddSemesterCourses = array_filter($courses, fn($c) => $c->semester % 2 === 1);

        $dayIndex = 0;
        $timeIndex = 0;
        $lecturerIndex = 0;

        foreach ($oddSemesterCourses as $course) {
            Schedule::firstOrCreate(
                [
                    'course_id' => $course->id,
                    'academic_year' => $academicYear,
                    'semester_type' => $semesterType,
                ],
                [
                    'lecturer_id' => $lecturers[$lecturerIndex % count($lecturers)]->id,
                    'day' => $days[$dayIndex % count($days)],
                    'start_time' => $timeSlots[$timeIndex]['start'],
                    'end_time' => $timeSlots[$timeIndex]['end'],
                    'room' => $rooms[array_rand($rooms)],
                ]
            );

            $timeIndex++;
            if ($timeIndex >= count($timeSlots)) {
                $timeIndex = 0;
                $dayIndex++;
            }
            $lecturerIndex++;
        }

        $semesterType = 'genap';
        $evenSemesterCourses = array_filter($courses, fn($c) => $c->semester % 2 === 0);

        $dayIndex = 0;
        $timeIndex = 0;

        foreach ($evenSemesterCourses as $course) {
            Schedule::firstOrCreate(
                [
                    'course_id' => $course->id,
                    'academic_year' => $academicYear,
                    'semester_type' => $semesterType,
                ],
                [
                    'lecturer_id' => $lecturers[$lecturerIndex % count($lecturers)]->id,
                    'day' => $days[$dayIndex % count($days)],
                    'start_time' => $timeSlots[$timeIndex]['start'],
                    'end_time' => $timeSlots[$timeIndex]['end'],
                    'room' => $rooms[array_rand($rooms)],
                ]
            );

            $timeIndex++;
            if ($timeIndex >= count($timeSlots)) {
                $timeIndex = 0;
                $dayIndex++;
            }
            $lecturerIndex++;
        }
    }
}
