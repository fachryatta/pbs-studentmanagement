<?php

namespace App\Controllers;

use App\Models\AcademicYearModel;
use App\Models\GradeModel;
use App\Models\StudentAcademicModel;

class AcademicController extends BaseController
{
    protected $studentAcademicModel;
    protected $academicYearModel;
    protected $gradeModel;

    public function __construct()
    {
        $this->studentAcademicModel = new StudentAcademicModel();
        $this->academicYearModel = new AcademicYearModel();
        $this->gradeModel = new GradeModel();
    }

    // ==========================================================
    // DATA AKADEMIK / HISTORI PER TAHUN PELAJARAN
    // ==========================================================

    public function index()
    {
        $academicYears = $this->getAcademicYears();
        $activeYear = $this->academicYearModel
            ->where('is_active', 1)
            ->first();

        $selectedYearId = (int) ($this->request->getGet('academic_year_id') ?: ($activeYear['id'] ?? 0));
        $selectedYear = $this->academicYearModel->find($selectedYearId);

        if (!$selectedYear && $activeYear) {
            $selectedYear = $activeYear;
            $selectedYearId = (int) $activeYear['id'];
        }

        $academics = [];

        if ($selectedYear) {
            $academics = $this->studentAcademicModel
                ->select(''
                    . 'student_academics.*,'
                    . ' students.nis,'
                    . ' students.nisn,'
                    . ' students.name AS student_name,'
                    . ' students.gender,'
                    . ' grades.name AS grade_name,'
                    . ' grades.level AS grade_level,'
                    . ' academic_years.year AS academic_year'
                )
                ->join('students', 'students.id = student_academics.student_id')
                ->join('grades', 'grades.id = student_academics.grade_id')
                ->join('academic_years', 'academic_years.id = student_academics.academic_year_id')
                ->where('student_academics.academic_year_id', $selectedYearId)
                ->orderBy('grades.id', 'ASC')
                ->orderBy('students.name', 'ASC')
                ->findAll();
        }

        $activeCount = 0;
        $outCount = 0;

        foreach ($academics as $academic) {
            if (($academic['status'] ?? '') === 'aktif') {
                $activeCount++;
            } else {
                $outCount++;
            }
        }

        return view('academics/index', [
            'title' => 'Data Akademik',
            'academicYears' => $academicYears,
            'activeYear' => $activeYear,
            'selectedYear' => $selectedYear,
            'selectedYearId' => $selectedYearId,
            'academics' => $academics,
            'activeCount' => $activeCount,
            'outCount' => $outCount,
        ]);
    }

    // ==========================================================
    // RIWAYAT AKADEMIK SATU SISWA
    // ==========================================================

    public function studentHistory($studentId)
    {
        $student = db_connect()
            ->table('students')
            ->select('students.id, students.nis, students.nisn, students.name, students.gender')
            ->where('students.id', $studentId)
            ->get()
            ->getRowArray();

        if (!$student) {
            return redirect()->to('/academics')->with('error', 'Data siswa tidak ditemukan.');
        }

        $history = $this->studentAcademicModel
            ->select(''
                . 'student_academics.*,'
                . ' grades.name AS grade_name,'
                . ' grades.level AS grade_level,'
                . ' academic_years.year AS academic_year'
            )
            ->join('grades', 'grades.id = student_academics.grade_id')
            ->join('academic_years', 'academic_years.id = student_academics.academic_year_id')
            ->where('student_academics.student_id', $studentId)
            ->orderBy('academic_years.year', 'ASC')
            ->findAll();

        return view('academics/student_history', [
            'title' => 'Riwayat Akademik Siswa',
            'student' => $student,
            'history' => $history,
        ]);
    }

    // ==========================================================
    // FORM PROSES TAHUN PELAJARAN BARU
    // ==========================================================

    public function promote()
    {
        $academicYears = $this->getAcademicYears();
        $grades = $this->gradeModel->orderBy('id', 'ASC')->findAll();
        $activeYear = $this->academicYearModel->where('is_active', 1)->first();

        $sourceYearId = (int) ($this->request->getGet('source_year_id') ?: ($activeYear['id'] ?? 0));
        $sourceYear = $this->academicYearModel->find($sourceYearId);

        if (!$sourceYear) {
            return redirect()->to('/academics/years')->with('error', 'Belum ada tahun pelajaran yang dapat diproses.');
        }

        $targetYears = [];
        foreach ($academicYears as $year) {
            if ((int) $year['id'] === $sourceYearId) {
                continue;
            }

            if ($this->yearStart($year['year']) > $this->yearStart($sourceYear['year'])) {
                $targetYears[] = $year;
            }
        }

        usort($targetYears, fn ($a, $b) => $this->yearStart($a['year']) <=> $this->yearStart($b['year']));

        $targetYearId = (int) ($this->request->getGet('target_year_id') ?: ($targetYears[0]['id'] ?? 0));

        $students = $this->getStudentsForYear($sourceYearId);

        foreach ($students as &$student) {
    $suggestion = $this->suggestNextGrade($student, $grades);

    $student['suggested_grade_id'] = $suggestion['grade_id'];
    $student['suggested_status'] = $suggestion['status'];
}
unset($student);

        return view('academics/promote', [
            'title' => 'Proses Tahun Pelajaran Baru',
            'academicYears' => $academicYears,
            'sourceYear' => $sourceYear,
            'sourceYearId' => $sourceYearId,
            'targetYears' => $targetYears,
            'targetYearId' => $targetYearId,
            'grades' => $grades,
            'students' => $students,
        ]);
    }

    // ==========================================================
    // SIMPAN PROSES KENAIKAN / STATUS SISWA
    // ==========================================================

    public function processPromotion()
    {
        $sourceYearId = (int) $this->request->getPost('source_year_id');
        $targetYearId = (int) $this->request->getPost('target_year_id');
        $studentIds = $this->request->getPost('student_id') ?? [];
        $gradeIds = $this->request->getPost('grade_id') ?? [];
        $statuses = $this->request->getPost('status') ?? [];

        if (!$sourceYearId || !$targetYearId || empty($studentIds)) {
            return redirect()->back()->withInput()->with('error', 'Data proses tahun pelajaran belum lengkap.');
        }

        if ($sourceYearId === $targetYearId) {
            return redirect()->back()->withInput()->with('error', 'Tahun pelajaran asal dan tujuan tidak boleh sama.');
        }

        $sourceYear = $this->academicYearModel->find($sourceYearId);
        $targetYear = $this->academicYearModel->find($targetYearId);

        if (!$sourceYear || !$targetYear) {
            return redirect()->back()->withInput()->with('error', 'Tahun pelajaran asal atau tujuan tidak ditemukan.');
        }

        if ($this->yearStart($targetYear['year']) <= $this->yearStart($sourceYear['year'])) {
            return redirect()->back()->withInput()->with('error', 'Tahun pelajaran tujuan harus lebih baru dari tahun asal.');
        }

        $validGrades = array_map('intval', array_column($this->gradeModel->findAll(), 'id'));
        $db = db_connect();
        $db->transStart();

        
foreach ($studentIds as $index => $studentId) {
    $studentId = (int) $studentId;

    if (!$studentId) {
        continue;
    }

    // Ambil kelas siswa pada tahun pelajaran asal.
    $sourceAcademic = $this->studentAcademicModel
        ->where('student_id', $studentId)
        ->where('academic_year_id', $sourceYearId)
        ->first();

    if (!$sourceAcademic) {
        continue;
    }

    $sourceGrade = $this->gradeModel->find(
        (int) $sourceAcademic['grade_id']
    );

    $gradeId = (int) ($gradeIds[$index] ?? 0);
    $status = strtolower(trim((string) ($statuses[$index] ?? 'aktif')));

    // Siswa yang berasal dari Grade 12 wajib berstatus lulus.
    if (
        $sourceGrade &&
        $this->isGradeTwelve((string) ($sourceGrade['name'] ?? ''))
    ) {
        $gradeId = (int) $sourceAcademic['grade_id'];
        $status = 'lulus';
    }

    $validGrades = array_map(
        'intval',
        array_column($this->gradeModel->findAll(), 'id')
    );

    if (!$gradeId || !in_array($gradeId, $validGrades, true)) {
        continue;
    }

    if (!in_array($status, ['aktif', 'keluar', 'lulus'], true)) {
        $status = 'aktif';
    }

    // Lanjutkan kode lama mulai dari:
    // $existing = $this->studentAcademicModel ...


            $existing = $this->studentAcademicModel
                ->where('student_id', $studentId)
                ->where('academic_year_id', $targetYearId)
                ->first();

            $academicData = [
                'student_id' => $studentId,
                'academic_year_id' => $targetYearId,
                'grade_id' => $gradeId,
                'status' => $status,
            ];

            if ($existing) {
                $this->studentAcademicModel->update($existing['id'], $academicData);
            } else {
                $this->studentAcademicModel->insert($academicData);
            }

            // Kolom pada tabel students tetap menunjukkan posisi/data akademik terbaru.
            db_connect()->table('students')->where('id', $studentId)->update([
                'grade_id' => $gradeId,
                'academic_year_id' => $targetYearId,
            ]);
        }

        // Tahun tujuan menjadi tahun pelajaran aktif setelah proses berhasil.
        $this->academicYearModel->where('id !=', $targetYearId)->set(['is_active' => 0])->update();
        $this->academicYearModel->update($targetYearId, ['is_active' => 1]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->withInput()->with('error', 'Proses tahun pelajaran gagal. Tidak ada perubahan yang disimpan.');
        }

        return redirect()
            ->to('/academics?academic_year_id=' . $targetYearId)
            ->with('success', 'Tahun pelajaran ' . $targetYear['year'] . ' berhasil diproses dan sekarang menjadi tahun aktif.');
    }

    // ==========================================================
    // DATA TAHUN PELAJARAN
    // ==========================================================

    public function years()
    {
        return view('academics/years', [
            'title' => 'Tahun Pelajaran',
            'academicYears' => $this->getAcademicYears(),
        ]);
    }

    public function storeYear()
    {
        $year = trim((string) $this->request->getPost('year'));

        if (!preg_match('/^\d{4}\/\d{4}$/', $year)) {
            return redirect()->back()->withInput()->with('error', 'Format tahun pelajaran harus seperti 2027/2028.');
        }

        [$startYear, $endYear] = array_map('intval', explode('/', $year));

        if ($endYear !== $startYear + 1) {
            return redirect()->back()->withInput()->with('error', 'Tahun pelajaran harus berurutan, contoh 2027/2028.');
        }

        if ($this->academicYearModel->where('year', $year)->first()) {
            return redirect()->back()->withInput()->with('error', 'Tahun pelajaran ' . $year . ' sudah tersedia.');
        }

        $this->academicYearModel->insert([
            'year' => $year,
            'is_active' => 0,
        ]);

        return redirect()->to('/academics/years')->with('success', 'Tahun pelajaran ' . $year . ' berhasil ditambahkan.');
    }

    public function activateYear($id)
    {
        $year = $this->academicYearModel->find((int) $id);

        if (!$year) {
            return redirect()->to('/academics/years')->with('error', 'Tahun pelajaran tidak ditemukan.');
        }

        $db = db_connect();
        $db->transStart();

        $this->academicYearModel->where('id !=', $year['id'])->set(['is_active' => 0])->update();
        $this->academicYearModel->update($year['id'], ['is_active' => 1]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->to('/academics/years')->with('error', 'Tahun pelajaran gagal diaktifkan.');
        }

        return redirect()->to('/academics/years')->with('success', 'Tahun pelajaran ' . $year['year'] . ' sekarang menjadi tahun aktif.');
    }

    


public function deleteYear($id)
{
    $yearId = (int) $id;

    // Pastikan tahun pelajaran tersedia.
    $year = $this->academicYearModel->find($yearId);

    if (!$year) {
        return redirect()->to('/academics/years')
            ->with('error', 'Tahun pelajaran tidak ditemukan.');
    }

    // Tahun yang sedang aktif tidak boleh dihapus.
    if ((int) $year['is_active'] === 1) {
        return redirect()->to('/academics/years')
            ->with(
                'error',
                'Tahun pelajaran aktif tidak dapat dihapus. Aktifkan tahun lain terlebih dahulu.'
            );
    }

    // Cari tahun pelajaran aktif sebagai tujuan referensi lama siswa.
    $activeYear = $this->academicYearModel
        ->where('is_active', 1)
        ->first();

    if (!$activeYear) {
        return redirect()->to('/academics/years')
            ->with(
                'error',
                'Tidak ditemukan tahun pelajaran aktif. Aktifkan tahun lain terlebih dahulu.'
            );
    }

    $activeYearId = (int) $activeYear['id'];

    $db = db_connect();
    $db->transBegin();

    try {
        /*
         * Perbaiki referensi lama di tabel students.
         * Kolom students.academic_year_id memiliki foreign key
         * ke academic_years, sehingga referensi ini harus
         * dipindahkan sebelum tahun pelajaran dihapus.
         *
         * Data siswa tidak dihapus.
         */
        $db->table('students')
            ->where('academic_year_id', $yearId)
            ->update([
                'academic_year_id' => $activeYearId,
            ]);

        if ($db->transStatus() === false) {
            throw new \RuntimeException(
                'Gagal memperbarui referensi tahun pelajaran pada data siswa.'
            );
        }

        // Hapus riwayat akademik pada tahun yang dipilih.
        $this->studentAcademicModel
            ->where('academic_year_id', $yearId)
            ->delete();

        if ($db->transStatus() === false) {
            throw new \RuntimeException(
                'Gagal menghapus riwayat akademik tahun pelajaran.'
            );
        }

        // Hapus tahun pelajaran setelah referensinya ditangani.
        $this->academicYearModel->delete($yearId);

        if ($db->transStatus() === false) {
            $dbError = $db->error();

            throw new \RuntimeException(
                'Gagal menghapus tahun pelajaran: '
                . ($dbError['message'] ?? 'Kesalahan database.')
            );
        }

        $db->transCommit();

        return redirect()->to('/academics/years')
            ->with(
                'success',
                'Tahun pelajaran ' . $year['year'] . ' berhasil dihapus.'
            );

    } catch (\Throwable $e) {
        $db->transRollback();

        log_message(
            'error',
            'Gagal menghapus tahun pelajaran ID '
            . $yearId . ': ' . $e->getMessage()
        );

        return redirect()->to('/academics/years')
            ->with(
                'error',
                'Tahun pelajaran gagal dihapus. Periksa log aplikasi untuk detailnya.'
            );
    }
}




    // ==========================================================
    // HELPER
    // ==========================================================

    private function getAcademicYears(): array
    {
        $years = $this->academicYearModel->findAll();

        usort($years, fn ($a, $b) => $this->yearStart($b['year']) <=> $this->yearStart($a['year']));

        return $years;
    }

    private function yearStart(string $year): int
    {
        return (int) substr($year, 0, 4);
    }

    private function getStudentsForYear(int $yearId): array
    {
        return $this->studentAcademicModel
            ->select(''
                . 'student_academics.*,'
                . ' students.nis,'
                . ' students.nisn,'
                . ' students.name AS student_name,'
                . ' students.gender,'
                . ' grades.name AS grade_name,'
                . ' grades.level AS grade_level,'
                . ' academic_years.year AS academic_year'
            )
            ->join('students', 'students.id = student_academics.student_id')
            ->join('grades', 'grades.id = student_academics.grade_id')
            ->join('academic_years', 'academic_years.id = student_academics.academic_year_id')
            ->where('student_academics.academic_year_id', $yearId)
            ->orderBy('grades.id', 'ASC')
            ->orderBy('students.name', 'ASC')
            ->findAll();
    }

    
private function suggestNextGrade(array $student, array $grades): array
{
    $currentName = (string) ($student['grade_name'] ?? '');
    $currentKey = $this->gradeKey($currentName);
    $currentGradeId = (int) ($student['grade_id'] ?? 0);

    // Grade 12 otomatis lulus dan tetap pada Grade 12.
    if (preg_match('/GRADE12/', $currentKey)) {
        return [
            'grade_id' => $currentGradeId,
            'status'   => 'lulus',
        ];
    }

    $targetKeys = [];

    // PG -> PSA
    if (in_array($currentKey, ['PG', 'PLAYGROUP'], true)) {
        $targetKeys = ['PSA', 'PRESCHOOLA'];
    }

    // PSA -> PSB
    elseif (in_array($currentKey, ['PSA', 'PRESCHOOLA'], true)) {
        $targetKeys = ['PSB', 'PRESCHOOLB'];
    }

    // PSB -> Grade 1
    elseif (in_array($currentKey, ['PSB', 'PRESCHOOLB'], true)) {
        $targetKeys = ['GRADE1'];
    }

    // Grade 1 -> Grade 2, dan seterusnya sampai Grade 11 -> Grade 12.
    elseif (preg_match('/GRADE(\d+)/', $currentKey, $matches)) {
        $currentNumber = (int) $matches[1];

        if ($currentNumber >= 1 && $currentNumber < 12) {
            $targetKeys = ['GRADE' . ($currentNumber + 1)];
        }
    }

    // Cari kelas tujuan berdasarkan nama kelas di database.
    foreach ($grades as $grade) {
        $gradeKey = $this->gradeKey((string) ($grade['name'] ?? ''));

        if (in_array($gradeKey, $targetKeys, true)) {
            return [
                'grade_id' => (int) $grade['id'],
                'status'   => 'aktif',
            ];
        }
    }

    // Jika kelas tujuan tidak ditemukan, jangan mengarang ID kelas.
    return [
        'grade_id' => $currentGradeId,
        'status'   => 'aktif',
    ];
}

private function gradeKey(string $name): string
{
    return strtoupper(
        (string) preg_replace('/[^a-zA-Z0-9]/', '', trim($name))
    );
}

private function isGradeTwelve(string $gradeName): bool
{
    return preg_match('/GRADE12/', $this->gradeKey($gradeName)) === 1;
}

}
