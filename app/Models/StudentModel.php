<?php

namespace App\Models;

use CodeIgniter\Model;

class StudentModel extends Model
{
    protected $table = 'students';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType = 'array';

    protected $useSoftDeletes = false;

    protected $allowedFields = [
    'nis',
    'nisn',
    'nik',
    'no_kk',
    'name',
    'birth_place',
    'birth_date',
    'gender',
    'religion',
    'parent_id',
    'grade_id',
    'academic_year_id'
];

    protected $useTimestamps = true;

    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}