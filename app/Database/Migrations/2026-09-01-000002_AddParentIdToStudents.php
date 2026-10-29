<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddParentIdToStudents extends Migration
{
    public function up()
    {
        $this->forge->addColumn('students', [
            'parent_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'academic_year_id',
            ],
        ]);

        $this->db->query(
            'ALTER TABLE students
             ADD CONSTRAINT fk_students_parent
             FOREIGN KEY (parent_id)
             REFERENCES parents(id)
             ON DELETE SET NULL
             ON UPDATE CASCADE'
        );
    }

    public function down()
    {
        $this->db->query(
            'ALTER TABLE students
             DROP FOREIGN KEY fk_students_parent'
        );

        $this->forge->dropColumn('students', 'parent_id');
    }
}