<?php

namespace App\Controllers;

use App\Models\ParentModel;

class ParentController extends BaseController
{
    protected $parentModel;

    public function __construct()
    {
        $this->parentModel = new ParentModel();
    }


    // ==========================================
    // DATA ORANG TUA
    // ==========================================

    public function index()
    {
        $parents = $this->parentModel
            ->select('
                parents.*,
                COUNT(students.id) AS student_count
            ')
            ->join(
                'students',
                'students.parent_id = parents.id',
                'left'
            )
            ->groupBy('parents.id')
            ->orderBy('parents.guardian_1', 'ASC')
            ->findAll();

        return view('parents/index', [
            'title'   => 'Data Orang Tua',
            'parents' => $parents
        ]);
    }


    // ==========================================
    // FORM TAMBAH
    // ==========================================

    public function create()
    {
        return view('parents/create', [
            'title' => 'Tambah Data Orang Tua'
        ]);
    }


    // ==========================================
    // SIMPAN
    // ==========================================

    public function store()
    {
        $rules = [
            'guardian_1'   => 'permit_empty|max_length[150]',
            'guardian_2'   => 'permit_empty|max_length[150]',
            'address'      => 'permit_empty',
            'email_1'      => 'permit_empty|valid_email|max_length[255]',
            'email_2'      => 'permit_empty|valid_email|max_length[255]',
            'email_3'      => 'permit_empty|valid_email|max_length[255]',
            'home_phone'   => 'permit_empty|max_length[30]',
            'father_phone' => 'permit_empty|max_length[30]',
            'mother_phone' => 'permit_empty|max_length[30]',
        ];


        if (!$this->validate($rules)) {

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'errors',
                    $this->validator->getErrors()
                );

        }


        $this->parentModel->insert([

            'guardian_1' =>
                trim(
                    $this->request->getPost(
                        'guardian_1'
                    )
                ) ?: null,

            'guardian_2' =>
                trim(
                    $this->request->getPost(
                        'guardian_2'
                    )
                ) ?: null,

            'address' =>
                trim(
                    $this->request->getPost(
                        'address'
                    )
                ) ?: null,

            'email_1' =>
                trim(
                    $this->request->getPost(
                        'email_1'
                    )
                ) ?: null,

            'email_2' =>
                trim(
                    $this->request->getPost(
                        'email_2'
                    )
                ) ?: null,

            'email_3' =>
                trim(
                    $this->request->getPost(
                        'email_3'
                    )
                ) ?: null,

            'home_phone' =>
                trim(
                    $this->request->getPost(
                        'home_phone'
                    )
                ) ?: null,

            'father_phone' =>
                trim(
                    $this->request->getPost(
                        'father_phone'
                    )
                ) ?: null,

            'mother_phone' =>
                trim(
                    $this->request->getPost(
                        'mother_phone'
                    )
                ) ?: null,

        ]);


        return redirect()
            ->to('/parents')
            ->with(
                'success',
                'Data orang tua berhasil ditambahkan.'
            );
    }


    // ==========================================
    // FORM EDIT
    // ==========================================

    public function edit($id)
    {
        $parent =
            $this->parentModel->find($id);


        if (!$parent) {

            return redirect()
                ->to('/parents')
                ->with(
                    'error',
                    'Data orang tua tidak ditemukan.'
                );

        }


        return view('parents/edit', [
            'title'  => 'Edit Data Orang Tua',
            'parent' => $parent
        ]);
    }


    // ==========================================
    // UPDATE
    // ==========================================

    public function update($id)
    {
        $parent =
            $this->parentModel->find($id);


        if (!$parent) {

            return redirect()
                ->to('/parents')
                ->with(
                    'error',
                    'Data orang tua tidak ditemukan.'
                );

        }


        $rules = [
            'guardian_1'   => 'permit_empty|max_length[150]',
            'guardian_2'   => 'permit_empty|max_length[150]',
            'address'      => 'permit_empty',
            'email_1'      => 'permit_empty|valid_email|max_length[255]',
            'email_2'      => 'permit_empty|valid_email|max_length[255]',
            'email_3'      => 'permit_empty|valid_email|max_length[255]',
            'home_phone'   => 'permit_empty|max_length[30]',
            'father_phone' => 'permit_empty|max_length[30]',
            'mother_phone' => 'permit_empty|max_length[30]',
        ];


        if (!$this->validate($rules)) {

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'errors',
                    $this->validator->getErrors()
                );

        }


        $this->parentModel->update($id, [

            'guardian_1' =>
                trim(
                    $this->request->getPost(
                        'guardian_1'
                    )
                ) ?: null,

            'guardian_2' =>
                trim(
                    $this->request->getPost(
                        'guardian_2'
                    )
                ) ?: null,

            'address' =>
                trim(
                    $this->request->getPost(
                        'address'
                    )
                ) ?: null,

            'email_1' =>
                trim(
                    $this->request->getPost(
                        'email_1'
                    )
                ) ?: null,

            'email_2' =>
                trim(
                    $this->request->getPost(
                        'email_2'
                    )
                ) ?: null,

            'email_3' =>
                trim(
                    $this->request->getPost(
                        'email_3'
                    )
                ) ?: null,

            'home_phone' =>
                trim(
                    $this->request->getPost(
                        'home_phone'
                    )
                ) ?: null,

            'father_phone' =>
                trim(
                    $this->request->getPost(
                        'father_phone'
                    )
                ) ?: null,

            'mother_phone' =>
                trim(
                    $this->request->getPost(
                        'mother_phone'
                    )
                ) ?: null,

        ]);


        return redirect()
            ->to('/parents')
            ->with(
                'success',
                'Data orang tua berhasil diperbarui.'
            );
    }


    // ==========================================
    // HAPUS
    // ==========================================

    public function delete($id)
    {
        $parent =
            $this->parentModel->find($id);


        if (!$parent) {

            return redirect()
                ->to('/parents')
                ->with(
                    'error',
                    'Data orang tua tidak ditemukan.'
                );

        }


        $this->parentModel->delete($id);


        return redirect()
            ->to('/parents')
            ->with(
                'success',
                'Data orang tua berhasil dihapus.'
            );
    }

    // ==========================================
// HAPUS SEMUA DATA ORANG TUA
// ==========================================

public function deleteAll()
{
    // Cek apakah ada data orang tua
    $total = $this->parentModel->countAllResults();

    if ($total === 0) {
        return redirect()
            ->to('/parents')
            ->with(
                'error',
                'Tidak ada data orang tua yang dapat dihapus.'
            );
    }

    // Hapus seluruh data orang tua
    // parent_id pada students akan otomatis menjadi NULL
    // karena foreign key menggunakan ON DELETE SET NULL.
    $this->parentModel
        ->where('id >', 0)
        ->delete();

    return redirect()
        ->to('/parents')
        ->with(
            'success',
            'Semua data orang tua berhasil dihapus.'
        );
}
}