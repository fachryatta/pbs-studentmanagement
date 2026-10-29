<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= esc($title ?? 'Detail Siswa') ?> - Student Management</title>

    <?= $this->include('layouts/header') ?>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f5f7fb;
            color: #1e293b;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px;
        }

        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 30px;
        }

        .page-title {
            font-size: 34px;
            font-weight: 700;
            color: #172554;
            margin-bottom: 8px;
        }

        .page-description {
            color: #64748b;
            font-size: 16px;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;

            padding: 11px 18px;

            background: white;
            color: #334155;

            border: 1px solid #cbd5e1;
            border-radius: 8px;

            text-decoration: none;
            font-size: 14px;
            font-weight: 600;

            transition: 0.2s;
        }

        .btn-back:hover {
            background: #f8fafc;
            border-color: #94a3b8;
        }

        .profile-card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 30px;
            margin-bottom: 20px;

            box-shadow: 0 2px 6px rgba(15, 23, 42, 0.04);
        }

        .student-header {
            display: flex;
            align-items: center;
            gap: 20px;

            padding-bottom: 25px;
            margin-bottom: 25px;

            border-bottom: 1px solid #e2e8f0;
        }

        .student-avatar {
            width: 64px;
            height: 64px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #eff6ff;
            color: #2563eb;

            border-radius: 14px;

            font-size: 28px;
        }

        .student-name {
            font-size: 24px;
            font-weight: 700;
            color: #172554;
            margin-bottom: 5px;
        }

        .student-id {
            color: #64748b;
            font-size: 14px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 700;
            color: #172554;

            margin-bottom: 18px;
        }

        .data-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 18px 30px;
        }

        .data-item {
            padding: 15px 0;
            border-bottom: 1px solid #f1f5f9;
        }

        .data-label {
            display: block;
            color: #64748b;
            font-size: 13px;
            margin-bottom: 6px;
        }

        .data-value {
            color: #1e293b;
            font-size: 15px;
            font-weight: 600;
        }

        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-grade {
            background: #eff6ff;
            color: #2563eb;
        }

        .badge-level {
            background: #f1f5f9;
            color: #475569;
        }

        .badge-year {
            background: #ecfdf5;
            color: #047857;
        }

        /* =========================
   DATA ORANG TUA
========================= */

.parent-card {
    margin-bottom: 30px;
}

.section-heading {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;

    padding-bottom: 20px;
    margin-bottom: 5px;

    border-bottom: 1px solid #e2e8f0;
}

.section-heading .section-title {
    margin-bottom: 5px;
}

.section-description {
    color: #64748b;
    font-size: 13px;
}

.parent-icon {
    width: 48px;
    height: 48px;

    display: flex;
    align-items: center;
    justify-content: center;

    background: #eff6ff;
    border-radius: 12px;

    font-size: 23px;
}

.parent-section {
    padding-top: 22px;
}

.parent-subtitle {
    margin-bottom: 5px;

    font-size: 14px;
    font-weight: 700;

    color: #334155;
}

.parent-section + .parent-section {
    margin-top: 8px;
}

.full-width {
    grid-column: 1 / -1;
}

.empty-parent {
    display: flex;
    align-items: center;
    gap: 15px;

    margin-top: 20px;
    padding: 18px;

    background: #f8fafc;
    border: 1px dashed #cbd5e1;
    border-radius: 10px;

    color: #475569;
}

.empty-parent-icon {
    width: 42px;
    height: 42px;

    display: flex;
    align-items: center;
    justify-content: center;

    background: #e2e8f0;
    border-radius: 10px;

    font-size: 20px;
}

.empty-parent strong {
    display: block;

    color: #334155;
    font-size: 14px;

    margin-bottom: 4px;
}

.empty-parent p {
    margin: 0;

    color: #64748b;
    font-size: 13px;
}

        @media (max-width: 768px) {

            .container {
                padding: 25px 20px;
            }

            .page-header {
                flex-direction: column;
                align-items: stretch;
            }

            .btn-back {
                justify-content: center;
            }

            .data-grid {
                grid-template-columns: 1fr;
            }

            .profile-card {
                padding: 20px;
            }
        }
    </style>
</head>

<body>

<main class="container">

    <div class="page-header">

        <div>
            <h1 class="page-title">
                Detail Siswa
            </h1>

            <p class="page-description">
                Informasi lengkap data siswa
            </p>
        </div>

        <a href="<?= base_url('/students') ?>" class="btn-back">
            ← Kembali
        </a>

    </div>


    <!-- IDENTITAS SISWA -->

    <div class="profile-card">

        <div class="student-header">

            <div class="student-avatar">
                👨‍🎓
            </div>

            <div>

                <div class="student-name">
                    <?= esc($student['name']) ?>
                </div>

                <div class="student-id">
                    NIS: <?= esc($student['nis']) ?>
                </div>

            </div>

        </div>


        <!-- DATA AKADEMIK -->

        <h2 class="section-title">
            Data Akademik
        </h2>

        <div class="data-grid">

            <div class="data-item">
                <span class="data-label">NIS</span>
                <span class="data-value">
                    <?= esc($student['nis']) ?>
                </span>
            </div>

            <div class="data-item">
                <span class="data-label">NISN</span>
                <span class="data-value">
                    <?= esc($student['nisn'] ?: '-') ?>
                </span>
            </div>

            <div class="data-item">
                <span class="data-label">Kelas</span>
                <span class="data-value">
                    <span class="badge badge-grade">
                        <?= esc($student['grade_name']) ?>
                    </span>
                </span>
            </div>

            <div class="data-item">
                <span class="data-label">Jenjang</span>
                <span class="data-value">
                    <span class="badge badge-level">
                        <?= esc($student['grade_level']) ?>
                    </span>
                </span>
            </div>

            <div class="data-item">
                <span class="data-label">Tahun Ajaran</span>
                <span class="data-value">
                    <span class="badge badge-year">
                        <?= esc($student['academic_year']) ?>
                    </span>
                </span>
            </div>

        </div>

    </div>


    <!-- DATA PRIBADI -->

    <div class="profile-card">

        <h2 class="section-title">
            Data Pribadi
        </h2>

        <div class="data-grid">

            <div class="data-item">
                <span class="data-label">Nama Lengkap</span>
                <span class="data-value">
                    <?= esc($student['name']) ?>
                </span>
            </div>

            <div class="data-item">
                <span class="data-label">NIK</span>
                <span class="data-value">
                    <?= esc($student['nik'] ?: '-') ?>
                </span>
            </div>

            <div class="data-item">
                <span class="data-label">Nomor KK</span>
                <span class="data-value">
                    <?= esc($student['no_kk'] ?: '-') ?>
                </span>
            </div>

            <div class="data-item">
                <span class="data-label">Jenis Kelamin</span>
                <span class="data-value">
                    <?= esc($student['gender'] ?: '-') ?>
                </span>
            </div>

            <div class="data-item">
                <span class="data-label">Tempat Lahir</span>
                <span class="data-value">
                    <?= esc($student['birth_place'] ?: '-') ?>
                </span>
            </div>

            <div class="data-item">
                <span class="data-label">Tanggal Lahir</span>
                <span class="data-value">
                    <?= esc($student['birth_date'] ?: '-') ?>
                </span>
            </div>

            <div class="data-item">
                <span class="data-label">Agama</span>
                <span class="data-value">
                    <?= esc($student['religion'] ?: '-') ?>
                </span>
            </div>

        </div>

    </div>


    <!-- DATA ORANG TUA -->

<div class="profile-card parent-card">

    <div class="section-heading">

        <div>
            <h2 class="section-title">
                Data Orang Tua
            </h2>

            <p class="section-description">
                Informasi wali dan kontak orang tua siswa
            </p>
        </div>

        <div class="parent-icon">
            👨‍👩‍👧
        </div>

    </div>


    <?php if (!empty($student['guardian_1']) || !empty($student['guardian_2'])): ?>

        <!-- WALI -->

        <div class="parent-section">

            <h3 class="parent-subtitle">
                Wali
            </h3>

            <div class="data-grid">

                <div class="data-item">
                    <span class="data-label">
                        Wali 1
                    </span>

                    <span class="data-value">
                        <?= esc($student['guardian_1'] ?: '-') ?>
                    </span>
                </div>


                <div class="data-item">
                    <span class="data-label">
                        Wali 2
                    </span>

                    <span class="data-value">
                        <?= esc($student['guardian_2'] ?: '-') ?>
                    </span>
                </div>

            </div>

        </div>


        <!-- ALAMAT -->

        <div class="parent-section">

            <h3 class="parent-subtitle">
                Alamat
            </h3>

            <div class="data-grid">

                <div class="data-item full-width">
                    <span class="data-label">
                        Alamat
                    </span>

                    <span class="data-value">
                        <?= nl2br(esc($student['parent_address'] ?: '-')) ?>
                    </span>
                </div>

            </div>

        </div>


        <!-- EMAIL -->

        <div class="parent-section">

            <h3 class="parent-subtitle">
                Email
            </h3>

            <div class="data-grid">

                <div class="data-item">
                    <span class="data-label">
                        Email 1
                    </span>

                    <span class="data-value">
                        <?= esc($student['email_1'] ?: '-') ?>
                    </span>
                </div>


                <div class="data-item">
                    <span class="data-label">
                        Email 2
                    </span>

                    <span class="data-value">
                        <?= esc($student['email_2'] ?: '-') ?>
                    </span>
                </div>


                <div class="data-item">
                    <span class="data-label">
                        Email 3
                    </span>

                    <span class="data-value">
                        <?= esc($student['email_3'] ?: '-') ?>
                    </span>
                </div>

            </div>

        </div>


        <!-- NOMOR TELEPON -->

        <div class="parent-section">

            <h3 class="parent-subtitle">
                Nomor Telepon
            </h3>

            <div class="data-grid">

                <div class="data-item">
                    <span class="data-label">
                        No. HP Rumah
                    </span>

                    <span class="data-value">
                        <?= esc($student['home_phone'] ?: '-') ?>
                    </span>
                </div>


                <div class="data-item">
                    <span class="data-label">
                        No. HP Ayah
                    </span>

                    <span class="data-value">
                        <?= esc($student['father_phone'] ?: '-') ?>
                    </span>
                </div>


                <div class="data-item">
                    <span class="data-label">
                        No. HP Ibu
                    </span>

                    <span class="data-value">
                        <?= esc($student['mother_phone'] ?: '-') ?>
                    </span>
                </div>

            </div>

        </div>


    <?php else: ?>

        <!-- BELUM ADA DATA PARENT -->

        <div class="empty-parent">

            <div class="empty-parent-icon">
                👨‍👩‍👧
            </div>

            <div>

                <strong>
                    Belum ada data orang tua
                </strong>

                <p>
                    Siswa ini belum terhubung dengan data orang tua.
                </p>

            </div>

        </div>

    <?php endif; ?>

</div>

</main>

<?= view('layouts/footer') ?>

</body>
</html>