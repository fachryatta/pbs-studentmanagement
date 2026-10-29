<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStudentAcademicsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'BIGINT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            'student_id' => [
                'type'     => 'BIGINT',
                'unsigned' => true,
            ],

            'academic_year_id' => [
                'type'     => 'BIGINT',
                'unsigned' => true,
            ],

            'grade_id' => [
                'type'     => 'BIGINT',
                'unsigned' => true,
            ],

            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'default'    => 'aktif',
            ],

            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],

            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);

        $this->forge->addKey('student_id');
        $this->forge->addKey('academic_year_id');
        $this->forge->addKey('grade_id');

        $this->forge->addForeignKey(
            'student_id',
            'students',
            'id',
            'CASCADE',
            'CASCADE',
            'fk_student_academics_student'
        );

        $this->forge->addForeignKey(
            'academic_year_id',
            'academic_years',
            'id',
            'CASCADE',
            'CASCADE',
            'fk_student_academics_academic_year'
        );

        $this->forge->addForeignKey(
            'grade_id',
            'grades',
            'id',
            'CASCADE',
            'CASCADE',
            'fk_student_academics_grade'
        );

        $this->forge->createTable('student_academics');
    }

    public function down()
    {
        $this->forge->dropTable('student_academics', true);
    }
}