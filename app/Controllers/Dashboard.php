<?php

namespace App\Controllers;

use App\Models\AcademicYearModel;
use App\Models\StudentAcademicModel;
use App\Models\StudentModel;

class Dashboard extends BaseController
{
    protected $studentModel;
    protected $academicYearModel;
    protected $studentAcademicModel;

    public function __construct()
    {
        $this->studentModel = new StudentModel();
        $this->academicYearModel = new AcademicYearModel();
        $this->studentAcademicModel = new StudentAcademicModel();
    }

    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $activeYear = $this->academicYearModel
            ->where('is_active', 1)
            ->first();

        $totalStudents = $this->studentModel->countAllResults();
        $activeAcademicStudents = 0;
        $playgroupPreschool = 0;
        $elementary = 0;
        $juniorHigh = 0;
        $seniorHigh = 0;

        if ($activeYear) {
            $base = $this->studentAcademicModel
                ->select('student_academics.id')
                ->join('grades', 'grades.id = student_academics.grade_id')
                ->where('student_academics.academic_year_id', $activeYear['id'])
                ->where('student_academics.status', 'aktif');

            $activeRows = $base->findAll();
            $activeAcademicStudents = count($activeRows);

            $countByLevel = function (array $levels) use ($activeYear): int {
                return $this->studentAcademicModel
                    ->join('grades', 'grades.id = student_academics.grade_id')
                    ->where('student_academics.academic_year_id', $activeYear['id'])
                    ->where('student_academics.status', 'aktif')
                    ->whereIn('grades.level', $levels)
                    ->countAllResults();
            };

            $playgroupPreschool = $countByLevel(['Playgroup', 'Preschool']);
            $elementary = $countByLevel(['Elementary']);
            $juniorHigh = $countByLevel(['Junior High']);
            $seniorHigh = $countByLevel(['Senior High']);
        } else {
            // Fallback untuk instalasi lama yang belum memiliki tahun aktif.
            $playgroupPreschool = $this->studentModel->join('grades', 'grades.id = students.grade_id')->whereIn('grades.level', ['Playgroup', 'Preschool'])->countAllResults();
            $elementary = $this->studentModel->join('grades', 'grades.id = students.grade_id')->where('grades.level', 'Elementary')->countAllResults();
            $juniorHigh = $this->studentModel->join('grades', 'grades.id = students.grade_id')->where('grades.level', 'Junior High')->countAllResults();
            $seniorHigh = $this->studentModel->join('grades', 'grades.id = students.grade_id')->where('grades.level', 'Senior High')->countAllResults();
        }

        return view('dashboard', [
            'totalStudents' => $totalStudents,
            'activeAcademicStudents' => $activeAcademicStudents,
            'activeYear' => $activeYear,
            'playgroupPreschool' => $playgroupPreschool,
            'elementary' => $elementary,
            'juniorHigh' => $juniorHigh,
            'seniorHigh' => $seniorHigh,
        ]);
    }
}
