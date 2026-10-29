<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <link rel="icon" type="image/gif" href="<?= base_url('assets/logo110.gif') ?>">
    <title>Dashboard - Student Management</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;

            font-family:
                Arial,
                Helvetica,
                sans-serif;

            background: #f5f7fb;

            color: #1f2937;
        }

        /* =========================
           NAVBAR
        ========================= */

        .navbar {
            height: 65px;

            display: flex;

            align-items: center;

            justify-content: space-between;

            padding: 0 35px;

            background: white;

            border-bottom: 1px solid #e5e7eb;
        }

        .brand {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 20px;
    font-weight: bold;
    color: #2563eb;
}

.brand img {
    width: 42px;
    height: 42px;
    object-fit: contain;
    display: block;
}

        /* =========================
   USER AREA
========================= */

.user-area {
    display: flex;
    align-items: center;
    gap: 14px;
}

/* USER PROFILE */

.user-profile {
    display: flex;
    align-items: center;
    gap: 10px;

    padding: 5px 11px 5px 6px;

    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 12px;

    transition: all 0.2s ease;
}

.user-profile:hover {
    background: #f1f5f9;
    border-color: #cbd5e1;
}

/* AVATAR */

.user-avatar {
    width: 34px;
    height: 34px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 50%;

    background: #2563eb;
    color: white;

    font-size: 14px;
    font-weight: 700;
}

/* USER INFO */

.user-info {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.username {
    color: #1e293b;
    font-size: 14px;
    font-weight: 600;
}

.user-role {
    color: #64748b;
    font-size: 11px;
}

/* ROLE BADGE */

.role {
    padding: 6px 11px;

    border-radius: 8px;

    background: #eff6ff;
    color: #2563eb;

    border: 1px solid #dbeafe;

    font-size: 12px;
    font-weight: 700;
}

/* LOGOUT */

.logout {
    display: inline-flex;
    align-items: center;
    gap: 6px;

    padding: 9px 13px;

    color: #dc2626;
    background: white;

    border: 1px solid #fee2e2;
    border-radius: 9px;

    text-decoration: none;

    font-size: 13px;
    font-weight: 600;

    transition: all 0.2s ease;
}

.logout:hover {
    background: #fef2f2;
    border-color: #fecaca;
    color: #b91c1c;
}

        /* =========================
           CONTAINER
        ========================= */

        .container {
            max-width: 1200px;

            margin: auto;

            padding: 35px;
        }

        .welcome {
            margin-bottom: 30px;
        }

        .welcome h1 {
            margin: 0 0 8px;

            font-size: 28px;
        }

        .welcome p {
            margin: 0;

            color: #6b7280;
        }

        /* =========================
           STAT CARDS
        ========================= */

        .stats {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 28px;
}

        .stat-card {
            background: white;

            padding: 22px;

            border-radius: 10px;

            border: 1px solid #e5e7eb;
        }

        .stat-title {
            color: #6b7280;

            font-size: 14px;

            margin-bottom: 10px;
        }

        .stat-value {
            font-size: 25px;

            font-weight: bold;

            color: #111827;
        }

        /* =========================
           MENU
        ========================= */

        .section-title {
            margin-bottom: 15px;

            font-size: 20px;
        }

        .menu-grid {
            display: grid;

            grid-template-columns:
                repeat(2, 1fr);

            gap: 20px;
        }

        .menu-card {
            display: block;

            padding: 25px;

            background: white;

            border: 1px solid #e5e7eb;

            border-radius: 10px;

            text-decoration: none;

            color: inherit;

            transition: 0.2s;
        }

        .menu-card:hover {
            border-color: #2563eb;

            transform: translateY(-2px);

            box-shadow:
                0 5px 15px rgba(0, 0, 0, 0.06);
        }

        .menu-icon {
            font-size: 28px;

            margin-bottom: 12px;
        }

        .menu-card h3 {
            margin: 0 0 7px;

            color: #111827;
        }

        .menu-card p {
            margin: 0;

            color: #6b7280;

            font-size: 14px;
        }

        /* =========================
           ALERT
        ========================= */

        .alert {
            padding: 12px 15px;

            margin-bottom: 20px;

            border-radius: 7px;

            font-size: 14px;
        }

        .alert-error {
            background: #fee2e2;

            color: #991b1b;
        }

        .alert-success {
            background: #dcfce7;

            color: #166534;
        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 768px) {

            .navbar {
                padding: 0 20px;
            }

            .container {
                padding: 25px 20px;
            }

            .stats {
                grid-template-columns: 1fr;
            }

            .menu-grid {
                grid-template-columns: 1fr;
            }

            .user-area {
                gap: 8px;
            }

        }

        .section-title {
    font-size: 24px;
    font-weight: 600;
    margin-top: 45px;
    margin-bottom: 20px;
    color: #172b4d;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
}

.stat-card {
    background: white;
    border: 1px solid #e1e5eb;
    border-radius: 14px;
    padding: 28px 30px;
}

.stat-label {
    font-size: 17px;
    color: #64748b;
    margin-bottom: 15px;
}

.stat-value {
    font-size: 32px;
    font-weight: 700;
    color: #172b4d;
}

@media (max-width: 1000px) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 600px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }
}

    </style>

</head>

<body>


<!-- NAVBAR -->

<nav class="navbar">

    <div class="brand">
    <img src="<?= base_url('assets/logo110.gif') ?>" alt="Logo Permata Bangsa School">
    <span>PERMATA BANGSA SCHOOL</span>
</div>

    <div class="user-area">

    <div class="user-profile">

        <div class="user-avatar">
            <?= strtoupper(
                substr(
                    session()->get('name') ?? 'U',
                    0,
                    1
                )
            ) ?>
        </div>

        <div class="user-info">

            <span class="username">
                <?= esc(
                    session()->get('name') ?? 'User'
                ) ?>
            </span>

            <span class="user-role">
                <?= ucfirst(
                    esc(session()->get('role') ?? '')
                ) ?>
            </span>

        </div>

    </div>

    <a
        href="<?= base_url('logout') ?>"
        class="logout"
    >
        <span>↪</span>
        <span>Logout</span>
    </a>

</div>

</nav>


<!-- CONTENT -->

<div class="container">


    <?php if (session()->getFlashdata('error')): ?>

        <div class="alert alert-error">

            <?= esc(session()->getFlashdata('error')) ?>

        </div>

    <?php endif; ?>


    <?php if (session()->getFlashdata('success')): ?>

        <div class="alert alert-success">

            <?= esc(session()->getFlashdata('success')) ?>

        </div>

    <?php endif; ?>


    <!-- WELCOME -->

    <div class="welcome">

        <h1>
            Student Management
        </h1>

        <p>
            Selamat datang kembali,
            <strong><?= esc(session()->get('name')) ?></strong>.
            Kelola data siswa Permata Bangsa School di sini.
        </p>

    </div>


    <!-- STATISTICS -->

    <div class="stats">

    <!-- KIRI ATAS -->
    <div class="stat-card">

        <div class="stat-title">
            Total Siswa
        </div>

        <div class="stat-value">
            <?= $totalStudents ?>
        </div>

    </div>


    <!-- KANAN ATAS -->
    <div class="stat-card">

        <div class="stat-title">
            Tahun Ajaran Aktif
        </div>

        <div class="stat-value">
            <?= esc($activeYear['year'] ?? 'Belum diatur') ?>
        </div>

    </div>


    <!-- KIRI BAWAH -->
    <div class="stat-card">

        <div class="stat-title">
            Siswa Aktif Tahun Ini
        </div>

        <div class="stat-value">
            <?= $activeAcademicStudents ?>
        </div>

    </div>


    <!-- KANAN BAWAH -->
    <div class="stat-card">

        <div class="stat-title">
            Role Pengguna
        </div>

        <div class="stat-value">
            <?= esc(ucfirst(session()->get('role'))) ?>
        </div>

    </div>

</div>

    <div class="section-title">Statistik Siswa</div>

<div class="stats-grid">

    <div class="stat-card">
        <div class="stat-label">Playgroup & Preschool</div>
        <div class="stat-value">
            <?= $playgroupPreschool ?>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-label">Elementary</div>
        <div class="stat-value">
            <?= $elementary ?>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-label">Junior High</div>
        <div class="stat-value">
            <?= $juniorHigh ?>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-label">Senior High</div>
        <div class="stat-value">
            <?= $seniorHigh ?>
        </div>
    </div>

</div>


    <!-- MENU -->

    <div class="section-title">
        Menu
    </div>


    <div class="menu-grid">


        <!-- DATA SISWA -->

        <a
            href="<?= base_url('students') ?>"
            class="menu-card"
        >

            <div class="menu-icon">
                👨‍🎓
            </div>

            <h3>
                Data Siswa
            </h3>

            <p>
                Melihat, mencari, dan mengelola data siswa.
            </p>

        </a>


        <a href="<?= base_url('academics') ?>" class="menu-card">
            <div class="menu-icon">📚</div>
            <h3>Data Akademik</h3>
            <p>Melihat histori kelas dan status siswa berdasarkan tahun pelajaran.</p>
        </a>

        
<?php if (in_array(session()->get('role'), ['admin', 'guru'], true)): ?>

    <a href="<?= base_url('students/export') ?>" class="menu-card">
        <div class="menu-icon">📊</div>
        <h3>Export Excel</h3>
        <p>Export data siswa ke file Excel.</p>
    </a>

<?php endif; ?>



        <?php if (session()->get('role') === 'admin'): ?>

            
<a href="<?= base_url('parents') ?>" class="menu-card">
    <div class="menu-icon">👨‍👩‍👧</div>
    <h3>Data Orang Tua</h3>
    <p>Melihat, mencari, dan mengelola data orang tua siswa.</p>
</a>



            <!-- USER -->

            <a
                href="<?= base_url('users') ?>"
                class="menu-card"
            >

                <div class="menu-icon">
                    👤
                </div>

                <h3>
                    Kelola User
                </h3>

                <p>
                    Mengatur akun Admin dan Guru.
                </p>

            </a>


        <?php endif; ?>


    </div>


</div>

<?= view('layouts/footer') ?>

</body>

</html>