<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title><?= esc($title ?? 'Data Orang Tua') ?> - Student Management</title>

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

        /* =========================
           CONTAINER
        ========================= */

        .container {
            max-width: 1500px;
            margin: 0 auto;
            padding: 40px;
        }

        /* =========================
           PAGE HEADER
        ========================= */

        .page-header {
            display: flex;
            align-items: flex-start;
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

        /* =========================
           BUTTON
        ========================= */

        .btn-add {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;

            background: #2563eb;
            color: white;

            padding: 12px 20px;

            border-radius: 9px;

            text-decoration: none;

            font-size: 15px;
            font-weight: 600;

            transition: 0.2s;
        }

        .btn-add:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
        }

        .header-actions {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
    justify-content: flex-end;
}

.btn-delete-all {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;

    background: #fff1f2;
    color: #dc2626;

    border: 1px solid #fecdd3;

    padding: 12px 18px;

    border-radius: 9px;

    font-size: 15px;
    font-weight: 600;

    cursor: pointer;

    transition: 0.2s;
}

.btn-delete-all:hover {
    background: #fee2e2;
    border-color: #fca5a5;
    transform: translateY(-1px);
}

.delete-all-form {
    margin: 0;
}

        /* =========================
           ALERT
        ========================= */

        .alert {
            padding: 13px 16px;
            margin-bottom: 20px;
            border-radius: 8px;
            font-size: 14px;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        /* =========================
           TOOLBAR
        ========================= */

        .toolbar {
            background: white;

            border: 1px solid #e2e8f0;

            border-radius: 12px;

            padding: 16px;

            display: flex;
            align-items: center;

            gap: 12px;

            margin-bottom: 18px;

            flex-wrap: wrap;
        }

        .search-box {
            position: relative;
            flex: 1;
            min-width: 280px;
        }

        .search-icon {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            font-size: 16px;
        }

        .search-input {
            width: 100%;

            height: 44px;

            padding: 0 14px 0 40px;

            border: 1px solid #cbd5e1;

            border-radius: 8px;

            font-size: 14px;

            outline: none;
        }

        .search-input:focus {
            border-color: #2563eb;

            box-shadow:
                0 0 0 3px rgba(37, 99, 235, 0.08);
        }

        .total-data {
            color: #64748b;
            font-size: 14px;

            white-space: nowrap;
        }

        .total-data strong {
            color: #172554;
        }

        /* =========================
           TABLE
        ========================= */

        .table-card {
            background: white;

            border: 1px solid #e2e8f0;

            border-radius: 12px;

            overflow: hidden;
        }

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;

            border-collapse: collapse;

            min-width: 1250px;
        }

        thead {
            background: #f8fafc;
        }

        th {
            padding: 15px 14px;

            text-align: left;

            font-size: 13px;

            color: #475569;

            font-weight: 700;

            border-bottom: 1px solid #e2e8f0;

            white-space: nowrap;
        }

        td {
            padding: 15px 14px;

            font-size: 14px;

            color: #334155;

            border-bottom: 1px solid #eef2f7;

            vertical-align: top;
        }

        tbody tr:hover {
            background: #f8fafc;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        /* =========================
           TABLE TEXT
        ========================= */

        .number {
            width: 55px;
            color: #64748b;
        }

        .guardian-name {
            font-weight: 600;
            color: #172554;
            min-width: 170px;
        }

        .guardian-secondary {
            color: #475569;
        }

        .address {
            max-width: 280px;
            min-width: 220px;
            white-space: normal;
            line-height: 1.5;
        }

        .contact-list {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .contact-item {
            font-size: 13px;
            color: #475569;
        }

        .contact-label {
            display: inline-block;
            min-width: 62px;
            color: #94a3b8;
        }

        .student-count {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            min-width: 34px;
            height: 28px;

            padding: 0 9px;

            background: #eff6ff;
            color: #2563eb;

            border: 1px solid #dbeafe;

            border-radius: 20px;

            font-size: 12px;
            font-weight: 700;
        }

        /* =========================
           ACTION
        ========================= */

        .actions {
            display: flex;
            align-items: center;
            gap: 7px;
            white-space: nowrap;
        }

        .btn-edit,
        .btn-delete {
            display: inline-flex;

            align-items: center;
            justify-content: center;

            padding: 8px 13px;

            border-radius: 7px;

            text-decoration: none;

            font-size: 13px;

            font-weight: 600;

            border: none;

            cursor: pointer;

            transition: 0.2s;
        }

        .btn-edit {
            background: #f59e0b;
            color: white;
        }

        .btn-edit:hover {
            background: #d97706;
        }

        .btn-delete {
            background: #ef4444;
            color: white;
        }

        .btn-delete:hover {
            background: #dc2626;
        }

        .delete-form {
            display: inline;
        }

        /* =========================
           EMPTY STATE
        ========================= */

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #64748b;
        }

        .empty-icon {
            font-size: 42px;
            margin-bottom: 12px;
        }

        .empty-state h3 {
            color: #334155;
            margin-bottom: 6px;
        }

        /* =========================
           PAGINATION
        ========================= */

        .pagination-bar {
            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 16px;

            padding: 16px 18px;

            border-top: 1px solid #e2e8f0;

            background: #ffffff;
        }

        .pagination-info {
            color: #64748b;
            font-size: 13px;
        }

        .pagination-info strong {
            color: #334155;
        }

        .pagination-controls {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .pagination-btn {
            min-width: 36px;
            height: 36px;

            padding: 0 10px;

            border: 1px solid #dbe3ef;

            background: #ffffff;

            color: #334155;

            border-radius: 7px;

            font-size: 13px;

            font-weight: 600;

            cursor: pointer;

            transition: 0.15s;
        }

        .pagination-btn:hover:not(:disabled) {
            border-color: #2563eb;
            color: #2563eb;
            background: #eff6ff;
        }

        .pagination-btn.active {
            background: #2563eb;
            border-color: #2563eb;
            color: #ffffff;
        }

        .pagination-btn:disabled {
            opacity: 0.45;
            cursor: not-allowed;
        }

        .pagination-ellipsis {
            min-width: 24px;
            text-align: center;
            color: #94a3b8;
        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 768px) {

    .container {
        padding: 25px 20px;
    }

    .page-header {
        flex-direction: column;
    }

    .header-actions {
        width: 100%;
        flex-direction: column;
    }

    .btn-add,
    .btn-delete-all {
        width: 100%;
    }

    .toolbar {
        align-items: stretch;
    }

    .search-box {
        min-width: 100%;
    }

    .total-data {
        text-align: right;
        width: 100%;
    }

    .pagination-bar {
        flex-direction: column;
        align-items: stretch;
    }

    .pagination-info {
        text-align: center;
    }

    .pagination-controls {
        justify-content: center;
    }
}

    </style>

</head>

<body>

<main class="container">

    <!-- =========================
         PAGE HEADER
    ========================= -->

    <div class="page-header">

        <div>

            <h1 class="page-title">
                Data Orang Tua
            </h1>

            <p class="page-description">
                Kelola data orang tua dan wali siswa Permata Bangsa School
            </p>

        </div>

        <?php if (session()->get('role') === 'admin'): ?>

    <div class="header-actions">

        <!-- HAPUS SEMUA DATA -->

        <form
            action="<?= base_url('/parents/delete-all') ?>"
            method="post"
            class="delete-all-form"
            onsubmit="return confirm('PERINGATAN!\n\nSemua data orang tua akan dihapus dan tidak dapat dikembalikan.\n\nData siswa tidak akan ikut terhapus.\n\nYakin ingin menghapus SEMUA data orang tua?');"
        >

            <?= csrf_field() ?>

            <button
                type="submit"
                class="btn-delete-all"
            >
                🗑 Hapus Semua Data
            </button>

        </form>


        <!-- TAMBAH ORANG TUA -->

        <a
            href="<?= base_url('/parents/create') ?>"
            class="btn-add"
        >
            + Tambah Orang Tua
        </a>

    </div>

<?php endif; ?>

    </div>


    <!-- =========================
         ALERT
    ========================= -->

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


    <!-- =========================
         TOOLBAR
    ========================= -->

    <div class="toolbar">

        <div class="search-box">

            <span class="search-icon">
                🔍
            </span>

            <input
                type="text"
                id="searchInput"
                class="search-input"
                placeholder="Cari nama wali, email, atau nomor telepon..."
                autocomplete="off"
            >

        </div>

        <div class="total-data">

            Total:

            <strong id="totalParents">
                <?= count($parents) ?>
            </strong>

            data orang tua

        </div>

    </div>


    <!-- =========================
         TABLE
    ========================= -->

    <div class="table-card">

        <div class="table-wrapper">

            <table id="parentTable">

                <thead>

                    <tr>

                        <th class="number">
                            No
                        </th>

                        <th>
                            Wali 1
                        </th>

                        <th>
                            Wali 2
                        </th>

                        <th>
                            Alamat
                        </th>

                        <th>
                            Email
                        </th>

                        <th>
                            Nomor Telepon
                        </th>

                        <th>
                            Siswa
                        </th>

                        <th>
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody>

                    <?php if (!empty($parents)): ?>

                        <?php $no = 1; ?>

                        <?php foreach ($parents as $parent): ?>

                            <tr
                                data-search="<?= esc(
                                    strtolower(
                                        ($parent['guardian_1'] ?? '') . ' ' .
                                        ($parent['guardian_2'] ?? '') . ' ' .
                                        ($parent['email_1'] ?? '') . ' ' .
                                        ($parent['email_2'] ?? '') . ' ' .
                                        ($parent['email_3'] ?? '') . ' ' .
                                        ($parent['home_phone'] ?? '') . ' ' .
                                        ($parent['father_phone'] ?? '') . ' ' .
                                        ($parent['mother_phone'] ?? '')
                                    )
                                ) ?>"
                            >

                                <!-- NO -->

                                <td class="number">
                                    <?= $no++ ?>
                                </td>


                                <!-- WALI 1 -->

                                <td class="guardian-name">

                                    <?= esc(
                                        $parent['guardian_1']
                                        ?: '-'
                                    ) ?>

                                </td>


                                <!-- WALI 2 -->

                                <td class="guardian-secondary">

                                    <?= esc(
                                        $parent['guardian_2']
                                        ?: '-'
                                    ) ?>

                                </td>


                                <!-- ALAMAT -->

                                <td class="address">

                                    <?= nl2br(
                                        esc(
                                            $parent['address']
                                            ?: '-'
                                        )
                                    ) ?>

                                </td>


                                <!-- EMAIL -->

                                <td>

                                    <div class="contact-list">

                                        <div class="contact-item">
                                            <span class="contact-label">
                                                Email 1
                                            </span>

                                            <?= esc(
                                                $parent['email_1']
                                                ?: '-'
                                            ) ?>
                                        </div>

                                        <div class="contact-item">
                                            <span class="contact-label">
                                                Email 2
                                            </span>

                                            <?= esc(
                                                $parent['email_2']
                                                ?: '-'
                                            ) ?>
                                        </div>

                                        <div class="contact-item">
                                            <span class="contact-label">
                                                Email 3
                                            </span>

                                            <?= esc(
                                                $parent['email_3']
                                                ?: '-'
                                            ) ?>
                                        </div>

                                    </div>

                                </td>


                                <!-- TELEPON -->

                                <td>

                                    <div class="contact-list">

                                        <div class="contact-item">
                                            <span class="contact-label">
                                                Rumah
                                            </span>

                                            <?= esc(
                                                $parent['home_phone']
                                                ?: '-'
                                            ) ?>
                                        </div>

                                        <div class="contact-item">
                                            <span class="contact-label">
                                                Ayah
                                            </span>

                                            <?= esc(
                                                $parent['father_phone']
                                                ?: '-'
                                            ) ?>
                                        </div>

                                        <div class="contact-item">
                                            <span class="contact-label">
                                                Ibu
                                            </span>

                                            <?= esc(
                                                $parent['mother_phone']
                                                ?: '-'
                                            ) ?>
                                        </div>

                                    </div>

                                </td>


                                <!-- JUMLAH SISWA -->

                                <td>

                                    <span class="student-count">

                                        <?= esc(
                                            $parent['student_count'] ?? 0
                                        ) ?>

                                        siswa

                                    </span>

                                </td>


                                <!-- AKSI -->

                                <td>

                                    <div class="actions">

                                        <?php if (session()->get('role') === 'admin'): ?>

                                            <a
                                                href="<?= base_url('/parents/edit/' . $parent['id']) ?>"
                                                class="btn-edit"
                                            >
                                                Edit
                                            </a>

                                            <form
                                                action="<?= base_url('/parents/delete/' . $parent['id']) ?>"
                                                method="post"
                                                class="delete-form"
                                                onsubmit="return confirm('Yakin ingin menghapus data orang tua ini? Data siswa yang menggunakan orang tua ini tidak akan ikut terhapus.');"
                                            >

                                                <?= csrf_field() ?>

                                                <button
                                                    type="submit"
                                                    class="btn-delete"
                                                >
                                                    Hapus
                                                </button>

                                            </form>

                                        <?php endif; ?>

                                    </div>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>

                            <td colspan="8">

                                <div class="empty-state">

                                    <div class="empty-icon">
                                        👨‍👩‍👧
                                    </div>

                                    <h3>
                                        Belum ada data orang tua
                                    </h3>

                                    <p>
                                        Silakan tambahkan data orang tua terlebih dahulu.
                                    </p>

                                </div>

                            </td>

                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>


        <!-- PAGINATION -->

        <div
            class="pagination-bar"
            id="paginationBar"
        >

            <div
                class="pagination-info"
                id="paginationInfo"
            >
                Menampilkan <strong>0</strong> data
            </div>

            <div
                class="pagination-controls"
                id="paginationControls"
            ></div>

        </div>

    </div>

</main>


<script>

const searchInput =
    document.getElementById('searchInput');

const table =
    document.getElementById('parentTable');

const tbody =
    table.querySelector('tbody');

const totalParents =
    document.getElementById('totalParents');

const paginationInfo =
    document.getElementById('paginationInfo');

const paginationControls =
    document.getElementById('paginationControls');

const rows =
    Array.from(
        tbody.querySelectorAll('tr[data-search]')
    );

const perPage = 10;

let currentPage = 1;


// ==========================================
// RENDER PAGINATION
// ==========================================

function renderPagination(
    total,
    totalPages,
    startIndex,
    endIndex
) {

    paginationControls.innerHTML = '';

    if (total === 0) {

        paginationInfo.innerHTML =
            'Menampilkan <strong>0</strong> data';

        return;

    }


    paginationInfo.innerHTML =
        'Menampilkan <strong>' +
        startIndex +
        '</strong> - <strong>' +
        endIndex +
        '</strong> dari <strong>' +
        total +
        '</strong> data';


    // PREVIOUS

    const previous =
        document.createElement('button');

    previous.type = 'button';

    previous.className = 'pagination-btn';

    previous.textContent = '‹';

    previous.disabled =
        currentPage === 1;

    previous.addEventListener(
        'click',
        function () {

            if (currentPage > 1) {

                currentPage--;

                renderTable();

            }

        }
    );

    paginationControls.appendChild(previous);


    // NOMOR HALAMAN

    const maxVisiblePages = 5;

    let startPage =
        Math.max(
            1,
            currentPage - 2
        );

    let endPage =
        Math.min(
            totalPages,
            startPage + maxVisiblePages - 1
        );

    if (
        endPage - startPage + 1
        < maxVisiblePages
    ) {

        startPage =
            Math.max(
                1,
                endPage - maxVisiblePages + 1
            );

    }


    if (startPage > 1) {

        addPageButton(1);

        if (startPage > 2) {

            const ellipsis =
                document.createElement('span');

            ellipsis.className =
                'pagination-ellipsis';

            ellipsis.textContent = '...';

            paginationControls.appendChild(
                ellipsis
            );

        }

    }


    for (
        let page = startPage;
        page <= endPage;
        page++
    ) {

        addPageButton(page);

    }


    if (endPage < totalPages) {

        if (endPage < totalPages - 1) {

            const ellipsis =
                document.createElement('span');

            ellipsis.className =
                'pagination-ellipsis';

            ellipsis.textContent = '...';

            paginationControls.appendChild(
                ellipsis
            );

        }

        addPageButton(totalPages);

    }


    // NEXT

    const next =
        document.createElement('button');

    next.type = 'button';

    next.className = 'pagination-btn';

    next.textContent = '›';

    next.disabled =
        currentPage === totalPages;

    next.addEventListener(
        'click',
        function () {

            if (
                currentPage < totalPages
            ) {

                currentPage++;

                renderTable();

            }

        }
    );

    paginationControls.appendChild(next);


    function addPageButton(page) {

        const button =
            document.createElement('button');

        button.type = 'button';

        button.className =
            'pagination-btn';

        button.textContent = page;

        if (page === currentPage) {

            button.classList.add('active');

        }

        button.addEventListener(
            'click',
            function () {

                currentPage = page;

                renderTable();

            }
        );

        paginationControls.appendChild(
            button
        );

    }

}


// ==========================================
// RENDER TABLE
// ==========================================

function renderTable() {

    const keyword =
        searchInput.value
            .trim()
            .toLowerCase();


    const filteredRows =
        rows.filter(function (row) {

            const searchData =
                row.dataset.search || '';

            return searchData.includes(
                keyword
            );

        });


    const total =
        filteredRows.length;

    const totalPages =
        Math.max(
            1,
            Math.ceil(
                total / perPage
            )
        );


    if (
        currentPage > totalPages
    ) {

        currentPage =
            totalPages;

    }


    const startIndex =
        (currentPage - 1) * perPage;

    const endIndex =
        Math.min(
            startIndex + perPage,
            total
        );


    const visibleRows =
        filteredRows.slice(
            startIndex,
            endIndex
        );


    rows.forEach(function (row) {

        row.style.display = 'none';

    });


    visibleRows.forEach(
        function (row, index) {

            row.style.display = '';

            row.querySelector(
                '.number'
            ).textContent =
                startIndex + index + 1;

        }
    );


    totalParents.textContent =
        total;


    // EMPTY SEARCH RESULT

    let filteredEmptyRow =
        document.getElementById(
            'filteredEmptyRow'
        );


    if (
        total === 0 &&
        rows.length > 0
    ) {

        if (!filteredEmptyRow) {

            filteredEmptyRow =
                document.createElement('tr');

            filteredEmptyRow.id =
                'filteredEmptyRow';

            filteredEmptyRow.innerHTML = `
                <td colspan="8">
                    <div class="empty-state">
                        <div class="empty-icon">🔎</div>
                        <h3>Data tidak ditemukan</h3>
                        <p>Coba ubah kata kunci pencarian.</p>
                    </div>
                </td>
            `;

            tbody.appendChild(
                filteredEmptyRow
            );

        }

        filteredEmptyRow.style.display =
            '';

    } else if (filteredEmptyRow) {

        filteredEmptyRow.style.display =
            'none';

    }


    renderPagination(
        total,
        totalPages,
        startIndex + 1,
        endIndex
    );

}


// ==========================================
// SEARCH
// ==========================================

searchInput.addEventListener(
    'input',
    function () {

        currentPage = 1;

        renderTable();

    }
);


// INITIAL

renderTable();

</script>

<?= view('layouts/footer') ?>

</body>

</html>