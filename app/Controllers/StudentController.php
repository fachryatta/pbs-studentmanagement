<?php

namespace App\Controllers;

use App\Models\StudentModel;
use App\Models\GradeModel;
use App\Models\AcademicYearModel;
use App\Models\ParentModel;
use App\Models\StudentAcademicModel;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class StudentController extends BaseController
{
    protected $studentModel;
    protected $gradeModel;
    protected $academicYearModel;
    protected $parentModel;
    protected $studentAcademicModel;

    public function __construct()
    {
        $this->studentModel = new StudentModel();
        $this->gradeModel = new GradeModel();
        $this->academicYearModel = new AcademicYearModel();
        $this->parentModel = new ParentModel();
        $this->studentAcademicModel = new StudentAcademicModel();
    }

    // ==========================================
    // DATA SISWA
    // ==========================================

    public function index()
{
    // Ambil tahun pelajaran yang sedang aktif
    $activeAcademicYear = $this->academicYearModel
        ->where('is_active', 1)
        ->first();

    $students = [];

    if ($activeAcademicYear) {
        $students = $this->studentAcademicModel
            ->select('
                students.*,

                student_academics.id AS student_academic_id,
                student_academics.academic_year_id,
                student_academics.grade_id,
                student_academics.status AS academic_status,

                grades.name AS grade_name,
                grades.level AS grade_level,

                academic_years.year AS academic_year,

                parents.guardian_1,
                parents.guardian_2,
                parents.address AS parent_address,
                parents.email_1,
                parents.email_2,
                parents.email_3,
                parents.home_phone,
                parents.father_phone,
                parents.mother_phone
            ')
            ->join(
                'students',
                'students.id = student_academics.student_id',
                'inner'
            )
            ->join(
                'grades',
                'grades.id = student_academics.grade_id',
                'left'
            )
            ->join(
                'academic_years',
                'academic_years.id = student_academics.academic_year_id',
                'left'
            )
            ->join(
                'parents',
                'parents.id = students.parent_id',
                'left'
            )
            ->where(
                'student_academics.academic_year_id',
                $activeAcademicYear['id']
            )
            ->where(
                'student_academics.status',
                'aktif'
            )
            ->orderBy('students.name', 'ASC')
            ->findAll();
    }

    $data = [
        'title' => 'Data Siswa',
        'students' => $students,
        'activeAcademicYear' => $activeAcademicYear
    ];

    return view('students/index', $data);
}


    // ==========================================
    // FORM TAMBAH SISWA
    // ==========================================

    public function create()
{
    $data = [
        'title' => 'Tambah Siswa',

        'parents' => $this->parentModel
            ->orderBy('guardian_1', 'ASC')
            ->findAll(),

        'grades' => $this->gradeModel
            ->orderBy('id', 'ASC')
            ->findAll(),

        'academicYears' => $this->academicYearModel
            ->orderBy('id', 'DESC')
            ->findAll()
    ];

    return view('students/create', $data);
}


    // ==========================================
    // SIMPAN SISWA
    // ==========================================

    public function store()
{
    $emailInput = trim($this->request->getPost('email'));

    $rules = [
        'nis' => 'permit_empty|max_length[30]|is_unique[students.nis]',
        'nisn' => 'permit_empty|max_length[20]|is_unique[students.nisn]',
        'nik' => 'permit_empty|max_length[20]',
        'no_kk' => 'permit_empty|max_length[20]',
        'name' => 'required|max_length[150]',
        'birth_place' => 'permit_empty|max_length[100]',
        'birth_date' => 'permit_empty|valid_date[Y-m-d]',
        'gender' => 'permit_empty|in_list[Laki-laki,Perempuan]',
        'religion' => 'permit_empty|max_length[30]',
        'parent_id' => 'permit_empty|is_natural_no_zero',
        'grade_id' => 'required|is_natural_no_zero',
        'academic_year_id' => 'required|is_natural_no_zero'
    ];

    // ==========================================
    // VALIDASI MULTIPLE EMAIL
    // ==========================================

    if ($emailInput !== '') {

        $emails = array_map('trim', explode(',', $emailInput));

        foreach ($emails as $email) {

            if (!filter_var(trim($email), FILTER_VALIDATE_EMAIL)) {

                return redirect()
                    ->back()
                    ->withInput()
                    ->with(
                        'errors',
                        [
                            'email' => 'Format email tidak valid. Jika lebih dari satu email, pisahkan dengan koma (,).'
                        ]
                    );
            }
        }
    }

    // ==========================================
    // VALIDASI FORM
    // ==========================================

    if (!$this->validate($rules)) {
        return redirect()
            ->back()
            ->withInput()
            ->with('errors', $this->validator->getErrors());
    }

    $data = [
        'nis' => trim($this->request->getPost('nis')) ?: null,
        'nisn' => $this->request->getPost('nisn') ?: null,
        'nik' => $this->request->getPost('nik') ?: null,
        'no_kk' => $this->request->getPost('no_kk') ?: null,
        'name' => trim($this->request->getPost('name')),
        'birth_place' => $this->request->getPost('birth_place') ?: null,
        'birth_date' => $this->request->getPost('birth_date') ?: null,
        'gender' => $this->request->getPost('gender') ?: null,
        'religion' => $this->request->getPost('religion') ?: null,
        'parent_id' => $this->request->getPost('parent_id') ?: null,
        'grade_id' => $this->request->getPost('grade_id'),
        'academic_year_id' => $this->request->getPost('academic_year_id')
    ];

    $this->studentModel->insert($data);

    $studentId = $this->studentModel->getInsertID();

    if ($studentId && !empty($data['academic_year_id']) && !empty($data['grade_id'])) {
        $this->studentAcademicModel->insert([
            'student_id' => $studentId,
            'academic_year_id' => $data['academic_year_id'],
            'grade_id' => $data['grade_id'],
            'status' => 'aktif',
        ]);
    }

    return redirect()
        ->to('/students')
        ->with('success', 'Data siswa berhasil ditambahkan.');
}

    // ==========================================
// DETAIL SISWA
// ==========================================

public function detail($id)
{
    $student = $this->studentModel
        ->select('
            students.*,

            grades.name AS grade_name,
            grades.level AS grade_level,

            academic_years.year AS academic_year,

            parents.guardian_1,
            parents.guardian_2,
            parents.address AS parent_address,
            parents.email_1,
            parents.email_2,
            parents.email_3,
            parents.home_phone,
            parents.father_phone,
            parents.mother_phone
        ')
        ->join(
            'grades',
            'grades.id = students.grade_id',
            'left'
        )
        ->join(
            'academic_years',
            'academic_years.id = students.academic_year_id',
            'left'
        )
        ->join(
            'parents',
            'parents.id = students.parent_id',
            'left'
        )
        ->where('students.id', $id)
        ->first();

    if (!$student) {
        return redirect()
            ->to('/students')
            ->with('error', 'Data siswa tidak ditemukan.');
    }

    $data = [
        'title'   => 'Detail Siswa',
        'student' => $student
    ];

    return view('students/detail', $data);
}

    // ==========================================
// FORM EDIT
// ==========================================

public function edit($id)
{
    // ==========================================
    // AMBIL DATA SISWA
    // ==========================================

    $student = $this->studentModel->find($id);

    if (!$student) {
        return redirect()
            ->to('/students')
            ->with('error', 'Data siswa tidak ditemukan.');
    }


    // ==========================================
    // AMBIL TAHUN PELAJARAN AKTIF
    // ==========================================

    $activeAcademicYear = $this->academicYearModel
        ->where('is_active', 1)
        ->first();


    // ==========================================
    // AMBIL DATA AKADEMIK SISWA
    //
    // Prioritas:
    // 1. Data pada tahun pelajaran aktif
    // 2. Jika belum ada, ambil data akademik
    //    terbaru milik siswa
    // ==========================================

    $studentAcademic = null;

    if ($activeAcademicYear) {

        $studentAcademic = $this->studentAcademicModel
            ->where('student_id', $id)
            ->where(
                'academic_year_id',
                $activeAcademicYear['id']
            )
            ->where('status', 'aktif')
            ->first();
    }


    // ==========================================
    // FALLBACK
    //
    // Jika siswa belum memiliki data akademik
    // pada tahun aktif, ambil data akademik
    // terakhir miliknya.
    // ==========================================

    if (!$studentAcademic) {

        $studentAcademic = $this->studentAcademicModel
            ->where('student_id', $id)
            ->orderBy('academic_year_id', 'DESC')
            ->first();
    }


    // ==========================================
    // DATA UNTUK FORM
    // ==========================================

    $data = [
        'title' => 'Edit Siswa',

        // --------------------------------------
        // DATA ORANG TUA
        // --------------------------------------

        'parents' => $this->parentModel
            ->orderBy('guardian_1', 'ASC')
            ->findAll(),


        // --------------------------------------
        // DATA SISWA
        // --------------------------------------

        'student' => $student,


        // --------------------------------------
        // DATA KELAS
        // --------------------------------------

        'grades' => $this->gradeModel
            ->orderBy('id', 'ASC')
            ->findAll(),


        // --------------------------------------
        // DATA TAHUN PELAJARAN
        // --------------------------------------

        'academicYears' => $this->academicYearModel
            ->orderBy('id', 'DESC')
            ->findAll(),


        // --------------------------------------
        // DATA AKADEMIK SISWA
        // --------------------------------------

        'studentAcademic' => $studentAcademic,


        // --------------------------------------
        // TAHUN PELAJARAN AKTIF
        // --------------------------------------

        'activeAcademicYear' => $activeAcademicYear
    ];


    return view('students/edit', $data);
}


    // ==========================================
    // UPDATE SISWA
    // ==========================================

    public function update($id)
    {
        $emailInput = trim($this->request->getPost('email'));

        $student = $this->studentModel->find($id);

        if (!$student) {
            return redirect()
                ->to('/students')
                ->with('error', 'Data siswa tidak ditemukan.');
        }

        $nis = trim($this->request->getPost('nis')) ?: null;
        $nisn = $this->request->getPost('nisn') ?: null;

        $rules = [
            'nis' => "permit_empty|max_length[30]|is_unique[students.nis,id,$id]",
            'nisn' => "permit_empty|max_length[20]|is_unique[students.nisn,id,$id]",
            'nik' => 'permit_empty|max_length[20]',
            'no_kk' => 'permit_empty|max_length[20]',
            'name' => 'required|max_length[150]',
            'birth_place' => 'permit_empty|max_length[100]',
            'birth_date' => 'permit_empty|valid_date[Y-m-d]',
            'gender' => 'permit_empty|in_list[Laki-laki,Perempuan]',
            'religion' => 'permit_empty|max_length[30]',
            'email' => 'permit_empty|max_length[500]',
            'grade_id' => 'required|is_natural_no_zero',
            'academic_year_id' => 'required|is_natural_no_zero'
        ];

        if ($emailInput !== '') {

    $emails = array_map('trim', explode(',', $emailInput));

    foreach ($emails as $email) {

        if (!filter_var(trim($email), FILTER_VALIDATE_EMAIL)) {

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'errors',
                    [
                        'email' => 'Format email tidak valid. Jika lebih dari satu email, pisahkan dengan koma (,).'
                    ]
                );
        }
    }
}

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = [
    'nis' => $nis,
    'nisn' => $nisn,
    'nik' => $this->request->getPost('nik') ?: null,
    'no_kk' => $this->request->getPost('no_kk') ?: null,

    'name' => trim(
        $this->request->getPost('name')
    ),

    'birth_place' => $this->request->getPost('birth_place') ?: null,

    'birth_date' => $this->request->getPost('birth_date') ?: null,

    'gender' => $this->request->getPost('gender') ?: null,

    'religion' => $this->request->getPost('religion') ?: null,

    // ==========================================
    // ORANG TUA
    // ==========================================

    'parent_id' => $this->request->getPost('parent_id') ?: null,

    // ==========================================
    // DATA AKADEMIK
    // ==========================================

    'grade_id' => $this->request->getPost('grade_id'),

    'academic_year_id' => $this->request->getPost('academic_year_id')
];

        $this->studentModel->update($id, $data);

        // Sinkronkan data akademik tahun yang dipilih pada data siswa.
        if (!empty($data['academic_year_id']) && !empty($data['grade_id'])) {
            $academic = $this->studentAcademicModel
                ->where('student_id', $id)
                ->where('academic_year_id', $data['academic_year_id'])
                ->first();

            $academicData = [
                'student_id' => $id,
                'academic_year_id' => $data['academic_year_id'],
                'grade_id' => $data['grade_id'],
                'status' => $academic['status'] ?? 'aktif',
            ];

            if ($academic) {
                $this->studentAcademicModel->update($academic['id'], $academicData);
            } else {
                $this->studentAcademicModel->insert($academicData);
            }
        }

        return redirect()
            ->to('/students')
            ->with('success', 'Data siswa berhasil diperbarui.');
    }


    // ==========================================
    // HAPUS SISWA
    // ==========================================

    public function delete($id)
    {
        $student = $this->studentModel->find($id);

        if (!$student) {
            return redirect()
                ->to('/students')
                ->with('error', 'Data siswa tidak ditemukan.');
        }

        $this->studentModel->delete($id);

        return redirect()
            ->to('/students')
            ->with('success', 'Data siswa berhasil dihapus.');
    }

    // ==========================================
    // HAPUS SEMUA DATA SISWA
    // ==========================================

    public function deleteAll()
    {
        // Fitur ini hanya boleh dipanggil oleh admin melalui route filter 'admin'.
        $total = $this->studentModel->countAllResults();

        if ($total === 0) {
            return redirect()
                ->to('/students')
                ->with('error', 'Tidak ada data siswa yang dapat dihapus.');
        }

        $this->studentModel
            ->where('id >', 0)
            ->delete();

        return redirect()
            ->to('/students')
            ->with('success', 'Semua data siswa berhasil dihapus.');
    }

    // ==========================================
    // EXPORT EXCEL
    // ==========================================

    public function export()
{
    if (!in_array(session()->get('role'), ['admin', 'guru'], true)) {
    return redirect()->to('/dashboard')
        ->with('error', 'Anda tidak memiliki akses ke fitur export data siswa.');
}
    $data = [
        'title' => 'Export Data Siswa',

        'academicYears' => $this->academicYearModel
            ->orderBy('id', 'DESC')
            ->findAll(),

        'grades' => $this->gradeModel
            ->orderBy('id', 'ASC')
            ->findAll()
    ];

    return view('students/export', $data);
}

    public function exportExcel()
{
    if (!in_array(session()->get('role'), ['admin', 'guru'], true)) {
    return redirect()->to('/dashboard')
        ->with('error', 'Anda tidak memiliki akses ke fitur export data siswa.');
}
    // =========================================================
    // AMBIL TAHUN PELAJARAN
    // =========================================================

    $academicYearId = (int) $this->request->getGet('academic_year_id');


    // =========================================================
    // AMBIL KELAS
    //
    // Form menggunakan:
    // name="grade_id[]"
    //
    // Contoh:
    // grade_id[]=3
    // grade_id[]=8
    //
    // Berarti:
    // - Grade 3
    // - Grade 8
    //
    // Jika kosong = semua kelas
    // =========================================================

    $gradeIds = $this->request->getGet('grade_id');

    if (!is_array($gradeIds)) {
        $gradeIds = [];
    }


    // Pastikan hanya ID angka yang valid
    $gradeIds = array_values(
        array_filter(
            array_map('intval', $gradeIds),
            static function ($id) {
                return $id > 0;
            }
        )
    );


    // =========================================================
    // AMBIL KOLOM YANG DIPILIH
    // =========================================================

    $requestedColumns = $this->request->getGet('columns');

    if (!is_array($requestedColumns)) {
        $requestedColumns = [];
    }


    // =========================================================
    // DAFTAR KOLOM YANG BOLEH DIEKSPORT
    // =========================================================

    $availableColumns = [

        'nis' => [
            'header' => 'NIS',
            'field'  => 'nis'
        ],

        'nisn' => [
            'header' => 'NISN',
            'field'  => 'nisn'
        ],

        'nik' => [
            'header' => 'NIK',
            'field'  => 'nik'
        ],

        'no_kk' => [
            'header' => 'No. KK',
            'field'  => 'no_kk'
        ],

        'name' => [
            'header' => 'Nama Siswa',
            'field'  => 'name'
        ],

        'birth_place' => [
            'header' => 'Tempat Lahir',
            'field'  => 'birth_place'
        ],

        'birth_date' => [
            'header' => 'Tanggal Lahir',
            'field'  => 'birth_date'
        ],

        'gender' => [
            'header' => 'Jenis Kelamin',
            'field'  => 'gender'
        ],

        'religion' => [
            'header' => 'Agama',
            'field'  => 'religion'
        ],

        'guardian_1' => [
            'header' => 'Orang Tua / Wali 1',
            'field'  => 'guardian_1'
        ],

        'guardian_2' => [
            'header' => 'Orang Tua / Wali 2',
            'field'  => 'guardian_2'
        ],

        'parent_address' => [
            'header' => 'Alamat',
            'field'  => 'parent_address'
        ],

        'email_1' => [
            'header' => 'Email 1',
            'field'  => 'email_1'
        ],

        'email_2' => [
            'header' => 'Email 2',
            'field'  => 'email_2'
        ],

        'email_3' => [
            'header' => 'Email 3',
            'field'  => 'email_3'
        ],

        'home_phone' => [
            'header' => 'Telepon Rumah',
            'field'  => 'home_phone'
        ],

        'father_phone' => [
            'header' => 'No. HP Ayah',
            'field'  => 'father_phone'
        ],

        'mother_phone' => [
            'header' => 'No. HP Ibu',
            'field'  => 'mother_phone'
        ],

        'grade_name' => [
            'header' => 'Kelas',
            'field'  => 'grade_name'
        ],

        'grade_level' => [
            'header' => 'Jenjang',
            'field'  => 'grade_level'
        ],

        'academic_year' => [
            'header' => 'Tahun Pelajaran',
            'field'  => 'academic_year'
        ]

    ];


    // =========================================================
    // FILTER KOLOM AGAR HANYA KOLOM YANG DIIZINKAN
    // =========================================================

    $columns = [];

    foreach ($requestedColumns as $column) {

        if (isset($availableColumns[$column])) {

            $columns[$column] = $availableColumns[$column];

        }

    }


    // =========================================================
    // VALIDASI TAHUN PELAJARAN
    // =========================================================

    if ($academicYearId <= 0) {

        return redirect()
            ->back()
            ->with(
                'error',
                'Tahun pelajaran harus dipilih.'
            );

    }


    // =========================================================
    // VALIDASI KOLOM
    // =========================================================

    if (empty($columns)) {

        return redirect()
            ->back()
            ->with(
                'error',
                'Minimal satu kolom harus dipilih.'
            );

    }


    // =========================================================
    // CEK TAHUN PELAJARAN
    // =========================================================

    $academicYear = $this->academicYearModel
        ->find($academicYearId);


    if (!$academicYear) {

        return redirect()
            ->back()
            ->with(
                'error',
                'Tahun pelajaran tidak ditemukan.'
            );

    }


    // =========================================================
    // QUERY DATA SISWA
    //
    // DATA KELAS DAN TAHUN PELAJARAN DIAMBIL DARI
    // student_academics
    //
    // Ini penting karena kelas siswa dapat berubah
    // berdasarkan tahun pelajaran.
    // =========================================================

    $query = $this->studentAcademicModel
        ->select('
            students.*,

            student_academics.id AS student_academic_id,
            student_academics.academic_year_id,
            student_academics.grade_id,
            student_academics.status AS academic_status,

            grades.name AS grade_name,
            grades.level AS grade_level,

            academic_years.year AS academic_year,

            parents.guardian_1,
            parents.guardian_2,
            parents.address AS parent_address,
            parents.email_1,
            parents.email_2,
            parents.email_3,
            parents.home_phone,
            parents.father_phone,
            parents.mother_phone
        ')
        ->join(
            'students',
            'students.id = student_academics.student_id',
            'inner'
        )
        ->join(
            'grades',
            'grades.id = student_academics.grade_id',
            'left'
        )
        ->join(
            'academic_years',
            'academic_years.id = student_academics.academic_year_id',
            'left'
        )
        ->join(
            'parents',
            'parents.id = students.parent_id',
            'left'
        )
        ->where(
            'student_academics.academic_year_id',
            $academicYearId
        )
        ->where(
            'student_academics.status',
            'aktif'
        );


    // =========================================================
    // FILTER KELAS
    //
    // JIKA ADA KELAS YANG DIPILIH
    // maka hanya kelas tersebut yang diambil.
    //
    // JIKA gradeIds kosong
    // maka TIDAK ADA FILTER KELAS
    // sehingga semua kelas akan diambil.
    // =========================================================

    if (!empty($gradeIds)) {

        $query->whereIn(
            'student_academics.grade_id',
            $gradeIds
        );

    }


    // =========================================================
    // URUTKAN DATA
    //
    // Kelas terlebih dahulu,
    // kemudian nama siswa.
    // =========================================================

    $students = $query
        ->orderBy(
            'student_academics.grade_id',
            'ASC'
        )
        ->orderBy(
            'students.name',
            'ASC'
        )
        ->findAll();


    // =========================================================
    // CEK DATA
    // =========================================================

    if (empty($students)) {

        return redirect()
            ->back()
            ->with(
                'error',
                'Tidak ada data siswa untuk filter yang dipilih.'
            );

    }


    // =========================================================
    // KELOMPOKKAN SISWA BERDASARKAN KELAS
    //
    // Contoh:
    //
    // Grade 3
    //     Andi
    //     Budi
    //
    // Grade 8
    //     Citra
    //     Deni
    //
    // Nantinya:
    // Sheet 1 = Grade 3
    // Sheet 2 = Grade 8
    // =========================================================

    $studentsByGrade = [];

    foreach ($students as $student) {

        $gradeKey = (string) (
            $student['grade_id'] ?? '0'
        );


        if (!isset($studentsByGrade[$gradeKey])) {

            $studentsByGrade[$gradeKey] = [];

        }


        $studentsByGrade[$gradeKey][] = $student;

    }


    // =========================================================
    // BUAT SPREADSHEET
    // =========================================================

    $spreadsheet = new Spreadsheet();


    // Hapus sheet default
    $spreadsheet->removeSheetByIndex(0);


    // =========================================================
    // BUAT SHEET UNTUK SETIAP KELAS
    // =========================================================

    foreach (
        $studentsByGrade
        as $gradeKey => $gradeStudents
    ) {

        $firstStudent = $gradeStudents[0];


        // =====================================================
        // NAMA KELAS
        // =====================================================

        $gradeName = trim(
            (string) (
                $firstStudent['grade_name']
                ?? 'Kelas'
            )
        );


        if ($gradeName === '') {

            $gradeName = 'Kelas';

        }


        // =====================================================
        // BERSIHKAN NAMA SHEET
        //
        // Excel maksimal 31 karakter.
        // =====================================================

        $sheetTitle = mb_substr(
            $gradeName,
            0,
            31
        );


        // Karakter yang tidak boleh digunakan Excel
        $sheetTitle = preg_replace(
            '/[\\\\\\/\\?\\*\\[\\]:]/',
            '-',
            $sheetTitle
        );


        if ($sheetTitle === '') {

            $sheetTitle = 'Kelas';

        }


        // =====================================================
        // CEGAH NAMA SHEET DUPLIKAT
        //
        // Misalnya ada nama kelas yang sama.
        // =====================================================

        $originalSheetTitle = $sheetTitle;
        $counter = 1;


        while (
            $spreadsheet
                ->getSheetByName($sheetTitle) !== null
        ) {

            $suffix = ' (' . $counter . ')';

            $maxLength =
                31 - mb_strlen($suffix);


            $sheetTitle =
                mb_substr(
                    $originalSheetTitle,
                    0,
                    $maxLength
                ) .
                $suffix;


            $counter++;

        }


        // =====================================================
        // BUAT SHEET
        // =====================================================

        $sheet = $spreadsheet->createSheet();


        $sheet->setTitle(
            $sheetTitle
        );


        // =====================================================
        // HEADER
        // =====================================================

        $headers = [
            'No' => 'No'
        ];


        foreach ($columns as $column) {

            $headers[
                $column['field']
            ] = $column['header'];

        }


        // =====================================================
        // TULIS HEADER
        // =====================================================

        $columnIndex = 1;

foreach ($headers as $header) {
    $columnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($columnIndex);

    $sheet->setCellValue(
        $columnLetter . '1',
        $header
    );

    $columnIndex++;
}


        // =====================================================
        // STYLE HEADER
        // =====================================================

        $lastColumnIndex = count($headers);


        $lastColumnLetter =
            \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(
                $lastColumnIndex
            );


        $headerRange =
            'A1:' .
            $lastColumnLetter .
            '1';


        $sheet
            ->getStyle($headerRange)
            ->applyFromArray([

                'font' => [

                    'bold' => true,

                    'color' => [
                        'rgb' => 'FFFFFF'
                    ]

                ],

                'fill' => [

                    'fillType' =>
                        Fill::FILL_SOLID,

                    'startColor' => [
                        'rgb' => '2563EB'
                    ]

                ],

                'alignment' => [

                    'horizontal' =>
                        Alignment::HORIZONTAL_CENTER,

                    'vertical' =>
                        Alignment::VERTICAL_CENTER,

                    'wrapText' => true

                ],

                'borders' => [

                    'allBorders' => [

                        'borderStyle' =>
                            Border::BORDER_THIN

                    ]

                ]

            ]);


        // =====================================================
        // TULIS DATA SISWA
        // =====================================================

        $row = 2;
        $no = 1;


        foreach ($gradeStudents as $student) {

            // -------------------------------------------------
            // NOMOR
            // -------------------------------------------------
            $columnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($columnIndex);

            $sheet->setCellValue(
                'A' . $row,
                $no
            );


            // -------------------------------------------------
            // KOLOM YANG DIPILIH
            // -------------------------------------------------

            $columnIndex = 2;


            foreach ($columns as $column) {

                $field = $column['field'];


                $value =
                    $student[$field]
                    ?? '';


                // -------------------------------------------------
                // FORMAT TANGGAL LAHIR
                // -------------------------------------------------

                if (
                    $field === 'birth_date'
                    &&
                    $value !== ''
                ) {

                    $timestamp = strtotime($value);


                    if ($timestamp !== false) {

                        $value = date(
                            'd/m/Y',
                            $timestamp
                        );

                    }

                }

                $columnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(
    $columnIndex
);

// =====================================================
// NIK, NO. KK, NISN, DAN NIS HARUS DISIMPAN SEBAGAI TEXT
// Agar Excel tidak mengubah menjadi angka / scientific notation
// dan angka 0 di depan tetap terjaga.
// =====================================================
if (in_array($field, ['nik', 'no_kk', 'nisn', 'nis'], true)) {

    $sheet->setCellValueExplicit(
        $columnLetter . $row,
        (string) $value,
        DataType::TYPE_STRING
    );

    // Format sebagai Text di Excel
    $sheet
        ->getStyle($columnLetter . $row)
        ->getNumberFormat()
        ->setFormatCode('@');

} else {

    $sheet->setCellValue(
        $columnLetter . $row,
        $value
    );
}

$columnIndex++;

            }


            $row++;
            $no++;

        }


        // =====================================================
        // BORDER DATA
        // =====================================================

        $lastDataRow = max(
            2,
            $row - 1
        );


        $dataRange =
            'A1:' .
            $lastColumnLetter .
            $lastDataRow;


        $sheet
            ->getStyle($dataRange)
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(
                Border::BORDER_THIN
            );


        // =====================================================
        // TINGGI HEADER
        // =====================================================

        $sheet
            ->getRowDimension(1)
            ->setRowHeight(28);


        // =====================================================
        // FREEZE HEADER
        // =====================================================

        $sheet->freezePane('A2');


        // =====================================================
        // AUTO SIZE
        // =====================================================

        for (
            $i = 1;
            $i <= $lastColumnIndex;
            $i++
        ) {

            $letter =
                \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(
                    $i
                );


            $sheet
                ->getColumnDimension($letter)
                ->setAutoSize(true);

        }


        // =====================================================
        // LEBAR KHUSUS KOLOM
        // =====================================================

        foreach (
            $headers
            as $field => $header
        ) {

            $position = array_search(
                $field,
                array_keys($headers)
            );


            if ($position === false) {
                continue;
            }


            $columnNumber =
                $position + 1;


            $letter =
                \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(
                    $columnNumber
                );


            // Nama siswa
            if ($field === 'name') {

                $sheet
                    ->getColumnDimension($letter)
                    ->setWidth(28);

            }

            // NIK
if ($field === 'nik') {
    $sheet
        ->getColumnDimension($letter)
        ->setWidth(22);
}

// No. KK
if ($field === 'no_kk') {
    $sheet
        ->getColumnDimension($letter)
        ->setWidth(22);
}

// NISN
if ($field === 'nisn') {
    $sheet
        ->getColumnDimension($letter)
        ->setWidth(18);
}

// NIS
if ($field === 'nis') {
    $sheet
        ->getColumnDimension($letter)
        ->setWidth(18);
}


            // Alamat
            if ($field === 'parent_address') {

                $sheet
                    ->getColumnDimension($letter)
                    ->setWidth(35);

            }


            // Nama wali
            if (
                $field === 'guardian_1'
                ||
                $field === 'guardian_2'
            ) {

                $sheet
                    ->getColumnDimension($letter)
                    ->setWidth(25);

            }

        }


        // =====================================================
        // ALIGNMENT DATA
        // =====================================================

        $sheet
            ->getStyle($dataRange)
            ->getAlignment()
            ->setVertical(
                Alignment::VERTICAL_CENTER
            );

    }


    // =========================================================
    // AKTIFKAN SHEET PERTAMA
    // =========================================================

    $spreadsheet->setActiveSheetIndex(0);


    // =========================================================
    // NAMA FILE
    // =========================================================

    $safeAcademicYear = preg_replace(
        '/[^A-Za-z0-9_\-]/',
        '_',
        $academicYear['year']
    );


    $filename =
        'Data_Siswa_' .
        $safeAcademicYear .
        '_' .
        date('Ymd_His') .
        '.xlsx';


    // =========================================================
    // BUAT WRITER EXCEL
    // =========================================================

    $writer = new Xlsx(
        $spreadsheet
    );


    // =========================================================
    // KIRIM FILE KE BROWSER
    // =========================================================

    return $this->response

        ->setHeader(
            'Content-Type',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        )

        ->setHeader(
            'Content-Disposition',
            'attachment; filename="' .
            $filename .
            '"'
        )

        ->setHeader(
            'Cache-Control',
            'max-age=0'
        )

        ->setBody(
            $this->generateExcel($writer)
        );
}

private function generateExcel($writer)
{
    ob_start();

    $writer->save('php://output');

    return ob_get_clean();
}
}