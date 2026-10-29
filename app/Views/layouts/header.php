<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <link rel="icon" type="image/gif" href="<?= base_url('assets/logo110.gif') ?>">    
    <title>
        <?= esc($title ?? 'Student Management') ?>
    </title>

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

        /* =========================
           NAVBAR
        ========================= */

        .navbar {
            height: 72px;

            background: #ffffff;

            border-bottom: 1px solid #e5e7eb;

            display: flex;
            align-items: center;
            justify-content: space-between;

            padding: 0 40px;
        }

        /* =========================
           BRAND
        ========================= */

        .brand {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 22px;
    font-weight: 700;
    color: #2563eb;
    text-decoration: none;
    transition: 0.2s;
}

.brand img {
    width: 42px;
    height: 42px;
    object-fit: contain;
    display: block;
}

        .brand:hover {
            color: #1d4ed8;
        }

        /* =========================
   NAVBAR RIGHT
========================= */

.navbar-right {
    display: flex;
    align-items: center;
    gap: 14px;
}

/* USER PROFILE */

.user-profile {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 5px 10px 5px 6px;

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
    color: #ffffff;

    font-size: 14px;
    font-weight: 700;

    text-transform: uppercase;
}

/* USER INFO */

.user-info {
    display: flex;
    flex-direction: column;
    gap: 2px;
    min-width: 55px;
}

.username {
    color: #1e293b;
    font-size: 14px;
    font-weight: 600;
    line-height: 1.2;
}

.user-role {
    color: #64748b;
    font-size: 11px;
    line-height: 1.2;
}

/* ROLE BADGE */

.role {
    background: #eff6ff;
    color: #2563eb;

    padding: 6px 11px;

    border-radius: 8px;

    font-size: 12px;
    font-weight: 700;

    border: 1px solid #dbeafe;
}

/* LOGOUT */

.logout {
    display: inline-flex;
    align-items: center;
    gap: 6px;

    padding: 9px 13px;

    color: #dc2626;
    background: #fff;

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
           RESPONSIVE
        ========================= */

        @media (max-width: 768px) {

            .navbar {
                padding: 0 20px;
            }

            .navbar-right {
                gap: 10px;
            }

            .role {
                display: none;
            }

            .username {
                display: none;
            }

        }

    </style>

</head>

<body>


<header class="navbar">

    <!--
        Student Management
        klik untuk kembali ke Dashboard
    -->

    <a
    href="<?= base_url('/dashboard') ?>"
    class="brand">

    <img
        src="<?= base_url('assets/logo110.gif') ?>"
        alt="Logo Permata Bangsa School">

    <span>PERMATA BANGSA SCHOOL - Student Management</span>

</a>


    <div class="navbar-right">

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
        href="<?= base_url('/logout') ?>"
        class="logout">

        <span>↪</span>
        <span>Logout</span>

    </a>

</div>

</header>

<main>
    <?= $this->renderSection('content') ?>
</main>

</body>
</html>