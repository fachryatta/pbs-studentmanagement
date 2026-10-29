<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        <?= esc($title ?? 'Edit Data Orang Tua') ?>
        - Student Management
    </title>

    <?= $this->include('layouts/header') ?>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f5f7fb;
            color: #1f2937;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 40px 30px;
        }

        .page-header {
            margin-bottom: 25px;
        }

        .page-header h1 {
            margin: 0 0 7px;
            font-size: 30px;
            color: #172554;
        }

        .page-header p {
            margin: 0;
            color: #64748b;
        }

        .error-box {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
            padding: 15px 18px;
            border-radius: 9px;
            margin-bottom: 20px;
            font-size: 14px;
            line-height: 1.7;
        }

        .form-card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 30px;
        }

        .section {
            margin-bottom: 30px;
        }

        .section:last-child {
            margin-bottom: 0;
        }

        .section-title {
            font-size: 18px;
            font-weight: 700;
            color: #172554;
            margin-bottom: 18px;
            padding-bottom: 11px;
            border-bottom: 1px solid #e5e7eb;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px 25px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group.full {
            grid-column: 1 / -1;
        }

        label {
            font-size: 14px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 8px;
        }

        input,
        textarea {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-family: inherit;
            font-size: 14px;
            color: #1e293b;
            outline: none;
        }

        input:focus,
        textarea:focus {
            border-color: #2563eb;

            box-shadow:
                0 0 0 3px rgba(37, 99, 235, 0.08);
        }

        textarea {
            min-height: 120px;
            resize: vertical;
        }

        .actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 11px 18px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
        }

        .btn-primary:hover {
            background: #1d4ed8;
        }

        .btn-secondary {
            background: #e5e7eb;
            color: #374151;
        }

        .btn-secondary:hover {
            background: #d1d5db;
        }

        @media (max-width: 700px) {

            .container {
                padding: 25px 20px;
            }

            .form-card {
                padding: 20px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-group.full {
                grid-column: auto;
            }

            .actions {
                flex-direction: column-reverse;
            }

            .btn {
                width: 100%;
            }

        }

    </style>

</head>

<body>

<main class="container">

    <div class="page-header">

        <h1>
            Edit Data Orang Tua
        </h1>

        <p>
            Perbarui informasi orang tua atau wali siswa.
        </p>

    </div>


    <?php if (session()->get('errors')): ?>

        <div class="error-box">

            <strong>
                Terdapat kesalahan:
            </strong>

            <?php foreach (
                session()->get('errors')
                as $error
            ): ?>

                <div>
                    • <?= esc($error) ?>
                </div>

            <?php endforeach; ?>

        </div>

    <?php endif; ?>


    <div class="form-card">

        <form
            action="<?= base_url('parents/update/' . $parent['id']) ?>"
            method="post"
        >

            <?= csrf_field() ?>


            <!-- DATA WALI -->

            <div class="section">

                <div class="section-title">
                    Data Wali
                </div>

                <div class="form-grid">

                    <div class="form-group">

                        <label for="guardian_1">
                            Wali 1
                        </label>

                        <input
                            type="text"
                            id="guardian_1"
                            name="guardian_1"
                            value="<?= old(
                                'guardian_1',
                                $parent['guardian_1'] ?? ''
                            ) ?>"
                            placeholder="Nama wali 1"
                        >

                    </div>


                    <div class="form-group">

                        <label for="guardian_2">
                            Wali 2
                        </label>

                        <input
                            type="text"
                            id="guardian_2"
                            name="guardian_2"
                            value="<?= old(
                                'guardian_2',
                                $parent['guardian_2'] ?? ''
                            ) ?>"
                            placeholder="Nama wali 2"
                        >

                    </div>


                    <div class="form-group full">

                        <label for="address">
                            Alamat
                        </label>

                        <textarea
                            id="address"
                            name="address"
                            placeholder="Alamat lengkap"
                        ><?= old(
                            'address',
                            $parent['address'] ?? ''
                        ) ?></textarea>

                    </div>

                </div>

            </div>


            <!-- EMAIL -->

            <div class="section">

                <div class="section-title">
                    Data Email
                </div>

                <div class="form-grid">

                    <div class="form-group">

                        <label for="email_1">
                            Email 1
                        </label>

                        <input
                            type="email"
                            id="email_1"
                            name="email_1"
                            value="<?= old(
                                'email_1',
                                $parent['email_1'] ?? ''
                            ) ?>"
                            placeholder="Email utama"
                        >

                    </div>


                    <div class="form-group">

                        <label for="email_2">
                            Email 2
                        </label>

                        <input
                            type="email"
                            id="email_2"
                            name="email_2"
                            value="<?= old(
                                'email_2',
                                $parent['email_2'] ?? ''
                            ) ?>"
                            placeholder="Email kedua"
                        >

                    </div>


                    <div class="form-group">

                        <label for="email_3">
                            Email 3
                        </label>

                        <input
                            type="email"
                            id="email_3"
                            name="email_3"
                            value="<?= old(
                                'email_3',
                                $parent['email_3'] ?? ''
                            ) ?>"
                            placeholder="Email ketiga"
                        >

                    </div>

                </div>

            </div>


            <!-- TELEPON -->

            <div class="section">

                <div class="section-title">
                    Nomor Telepon
                </div>

                <div class="form-grid">

                    <div class="form-group">

                        <label for="home_phone">
                            No. HP Rumah
                        </label>

                        <input
                            type="text"
                            id="home_phone"
                            name="home_phone"
                            value="<?= old(
                                'home_phone',
                                $parent['home_phone'] ?? ''
                            ) ?>"
                            placeholder="Nomor telepon rumah"
                        >

                    </div>


                    <div class="form-group">

                        <label for="father_phone">
                            No. HP Ayah
                        </label>

                        <input
                            type="text"
                            id="father_phone"
                            name="father_phone"
                            value="<?= old(
                                'father_phone',
                                $parent['father_phone'] ?? ''
                            ) ?>"
                            placeholder="Nomor HP ayah"
                        >

                    </div>


                    <div class="form-group">

                        <label for="mother_phone">
                            No. HP Ibu
                        </label>

                        <input
                            type="text"
                            id="mother_phone"
                            name="mother_phone"
                            value="<?= old(
                                'mother_phone',
                                $parent['mother_phone'] ?? ''
                            ) ?>"
                            placeholder="Nomor HP ibu"
                        >

                    </div>

                </div>

            </div>


            <!-- ACTION -->

            <div class="actions">

                <a
                    href="<?= base_url('parents') ?>"
                    class="btn btn-secondary"
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

</main>

<?= view('layouts/footer') ?>

</body>

</html>