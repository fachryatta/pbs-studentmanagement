<?= $this->extend('layouts/header') ?>

<?= $this->section('content') ?>

<style>
    .page-container {
        max-width: 1100px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        gap: 20px;
    }

    .page-header h1 {
        font-size: 28px;
        margin-bottom: 6px;
        color: #1e293b;
    }

    .page-header p {
        color: #64748b;
        font-size: 14px;
    }

    .btn {
        display: inline-block;
        padding: 9px 15px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        border: none;
    }

    .btn-primary {
        background: #2563eb;
        color: #ffffff;
    }

    .btn-primary:hover {
        background: #1d4ed8;
    }

    .btn-edit {
        background: #eff6ff;
        color: #2563eb;
    }

    .btn-edit:hover {
        background: #dbeafe;
    }

    .btn-delete {
        background: #fef2f2;
        color: #dc2626;
    }

    .btn-delete:hover {
        background: #fee2e2;
    }

    .table-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }

    .table-wrapper {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    thead {
        background: #f8fafc;
    }

    th {
        padding: 15px 18px;
        text-align: left;
        font-size: 13px;
        font-weight: 700;
        color: #475569;
        border-bottom: 1px solid #e5e7eb;
    }

    td {
        padding: 15px 18px;
        font-size: 14px;
        color: #334155;
        border-bottom: 1px solid #f1f5f9;
    }

    tbody tr:hover {
        background: #f8fafc;
    }

    tbody tr:last-child td {
        border-bottom: none;
    }

    .user-name {
        font-weight: 600;
        color: #1e293b;
    }

    .username {
        color: #64748b;
    }

    .role-badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .role-admin {
        background: #e8f0ff;
        color: #2563eb;
    }

    .role-guru {
        background: #ecfdf5;
        color: #059669;
    }

    .actions {
        display: flex;
        align-items: center;
        gap: 7px;
    }

    .actions form {
        margin: 0;
    }

    .empty-state {
        text-align: center;
        padding: 50px 20px;
        color: #64748b;
    }

    .empty-state strong {
        display: block;
        margin-bottom: 5px;
        color: #334155;
    }

    .alert {
        padding: 12px 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .alert-success {
        background: #ecfdf5;
        color: #047857;
        border: 1px solid #a7f3d0;
    }

    .alert-error {
        background: #fef2f2;
        color: #b91c1c;
        border: 1px solid #fecaca;
    }

    @media (max-width: 700px) {
        .page-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .page-header .btn {
            width: 100%;
            text-align: center;
        }

        th,
        td {
            padding: 12px;
        }
    }
</style>

<div class="page-container">

    <!-- HEADER -->
    <div class="page-header">

        <div>
            <h1>Kelola User</h1>
            <p>Kelola akun pengguna yang dapat mengakses sistem.</p>
        </div>

        <a
            href="<?= base_url('/users/create') ?>"
            class="btn btn-primary"
        >
            + Tambah User
        </a>

    </div>


    <!-- FLASH MESSAGE -->
    <?php if (session()->getFlashdata('success')): ?>

        <div class="alert alert-success">
            <?= esc(session()->getFlashdata('success')) ?>
        </div>

    <?php endif; ?>


    <?php if (session()->getFlashdata('error')): ?>

        <div class="alert alert-error">
            <?= esc(session()->getFlashdata('error')) ?>
        </div>

    <?php endif; ?>


    <!-- TABLE -->
    <div class="table-card">

        <?php if (!empty($users)): ?>

            <div class="table-wrapper">

                <table>

                    <thead>
                        <tr>
                            <th width="60">No</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th width="180">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php $no = 1; ?>

                        <?php foreach ($users as $user): ?>

                            <tr>

                                <td>
                                    <?= $no++ ?>
                                </td>

                                <td>
                                    <span class="user-name">
                                        <?= esc($user['name']) ?>
                                    </span>
                                </td>

                                <td>
                                    <span class="username">
                                        @<?= esc($user['username']) ?>
                                    </span>
                                </td>

                                <td>

                                    <span class="role-badge
                                        <?= $user['role'] === 'admin'
                                            ? 'role-admin'
                                            : 'role-guru'
                                        ?>"
                                    >
                                        <?= ucfirst(esc($user['role'])) ?>
                                    </span>

                                </td>

                                <td>

                                    <div class="actions">

                                        <!-- EDIT -->
                                        <a
                                            href="<?= base_url('/users/edit/' . $user['id']) ?>"
                                            class="btn btn-edit"
                                        >
                                            Edit
                                        </a>


                                        <!-- DELETE -->
                                        <form
                                            action="<?= base_url('/users/delete/' . $user['id']) ?>"
                                            method="post"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');"
                                        >

                                            <?= csrf_field() ?>

                                            <button
                                                type="submit"
                                                class="btn btn-delete"
                                            >
                                                Hapus
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        <?php else: ?>

            <div class="empty-state">

                <strong>Belum ada user</strong>

                <span>
                    Silakan tambahkan user baru untuk mulai menggunakan sistem.
                </span>

            </div>

        <?php endif; ?>

    </div>

</div>

<?= view('layouts/footer') ?>

<?= $this->endSection() ?>