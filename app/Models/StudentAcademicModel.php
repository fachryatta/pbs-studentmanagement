<?php

namespace App\Models;

use CodeIgniter\Model;

class StudentAcademicModel extends Model
{
    protected $table = 'student_academics';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;
    protected $returnType = 'array';

    protected $allowedFields = [
        'student_id',
        'academic_year_id',
        'grade_id',
        'status'
    ];

    protected $useTimestamps = true;

    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}