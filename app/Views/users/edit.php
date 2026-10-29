<?= $this->extend('layouts/header') ?>

<?= $this->section('content') ?>

<style>
    .page-container {
        max-width: 900px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .page-header {
        margin-bottom: 25px;
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

    .form-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 7px;
    }

    .form-group.full {
        grid-column: 1 / -1;
    }

    .form-group label {
        font-size: 14px;
        font-weight: 600;
        color: #334155;
    }

    .required {
        color: #dc2626;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 11px 13px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 14px;
        outline: none;
        transition: 0.2s;
        background: #ffffff;
    }

    .form-group input:focus,
    .form-group select:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.10);
    }

    .form-help {
        font-size: 12px;
        color: #94a3b8;
    }

    .alert {
        padding: 12px 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .alert-error {
        background: #fef2f2;
        color: #b91c1c;
        border: 1px solid #fecaca;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #e5e7eb;
    }

    .btn {
        display: inline-block;
        padding: 10px 18px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        border: none;
    }

    .btn-cancel {
        background: #f1f5f9;
        color: #475569;
    }

    .btn-cancel:hover {
        background: #e2e8f0;
    }

    .btn-primary {
        background: #2563eb;
        color: #ffffff;
    }

    .btn-primary:hover {
        background: #1d4ed8;
    }

    @media (max-width: 700px) {
        .form-grid {
            grid-template-columns: 1fr;
        }

        .form-group.full {
            grid-column: auto;
        }

        .form-card {
            padding: 20px;
        }
    }
</style>

<div class="page-container">

    <div class="page-header">

        <h1>Edit User</h1>

        <p>
            Perbarui informasi akun pengguna.
        </p>

    </div>


    <!-- ERROR -->
    <?php if (session()->getFlashdata('errors')): ?>

        <div class="alert alert-error">

            <strong>Terjadi kesalahan:</strong>

            <ul style="margin: 8px 0 0 20px;">

                <?php foreach (session()->getFlashdata('errors') as $error): ?>

                    <li>
                        <?= esc($error) ?>
                    </li>

                <?php endforeach; ?>

            </ul>

        </div>

    <?php endif; ?>


    <div class="form-card">

        <form
            action="<?= base_url('/users/update/' . $user['id']) ?>"
            method="post"
        >

            <?= csrf_field() ?>

            <div class="form-grid">

                <!-- NAMA -->
                <div class="form-group full">

                    <label for="name">
                        Nama Lengkap <span class="required">*</span>
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="<?= old('name', $user['name']) ?>"
                        placeholder="Masukkan nama lengkap"
                        required
                    >

                </div>


                <!-- USERNAME -->
                <div class="form-group">

                    <label for="username">
                        Username <span class="required">*</span>
                    </label>

                    <input
                        type="text"
                        id="username"
                        name="username"
                        value="<?= old('username', $user['username']) ?>"
                        placeholder="Masukkan username"
                        required
                    >

                    <span class="form-help">
                        Username digunakan untuk login.
                    </span>

                </div>


                <!-- ROLE -->
                <div class="form-group">

                    <label for="role">
                        Role <span class="required">*</span>
                    </label>

                    <select
                        id="role"
                        name="role"
                        required
                    >

                        <option value="">
                            -- Pilih Role --
                        </option>

                        <option
                            value="admin"
                            <?= old('role', $user['role']) === 'admin'
                                ? 'selected'
                                : '' ?>
                        >
                            Admin
                        </option>

                        <option
                            value="guru"
                            <?= old('role', $user['role']) === 'guru'
                                ? 'selected'
                                : '' ?>
                        >
                            Guru
                        </option>

                    </select>

                </div>


                <!-- PASSWORD -->
                <div class="form-group full">

                    <label for="password">
                        Password Baru
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Kosongkan jika tidak ingin mengubah password"
                    >

                    <span class="form-help">
                        Isi hanya jika ingin mengganti password.
                        Minimal 6 karakter.
                    </span>

                </div>

            </div>


            <div class="form-actions">

                <a
                    href="<?= base_url('/users') ?>"
                    class="btn btn-cancel"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

</div>

<?= view('layouts/footer') ?>

<?= $this->endSection() ?>