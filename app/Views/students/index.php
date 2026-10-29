<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= esc($title ?? 'Data Siswa') ?> - Student Management</title>

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
           BUTTON TAMBAH
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
            padding: 14px 18px;
            border-radius: 9px;
            margin-bottom: 25px;
            font-size: 14px;
        }

        .alert-success {
            background: #dcfce7;
            border: 1px solid #bbf7d0;
            color: #166534;
        }

        .alert-error {
            background: #fee2e2;
            border: 1px solid #fecaca;
            color: #991b1b;
        }


        /* =========================
           TOOLBAR
        ========================= */

        .toolbar {
            background: #ffffff;

            border: 1px solid #e2e8f0;
            border-radius: 12px;

            padding: 18px;

            display: flex;
            align-items: center;

            gap: 12px;

            margin-bottom: 18px;

            box-shadow: 0 2px 5px rgba(15, 23, 42, 0.03);
        }

        .search-box {
            position: relative;
            flex: 1;
        }

        .search-box input {
            width: 100%;
            height: 42px;

            border: 1px solid #cbd5e1;
            border-radius: 8px;

            padding: 0 15px 0 40px;

            font-size: 14px;

            outline: none;
        }

        .search-box input:focus {
            border-color: #2563eb;

            box-shadow:
                0 0 0 3px rgba(37, 99, 235, 0.10);
        }

        .search-icon {
            position: absolute;

            left: 14px;
            top: 11px;

            color: #94a3b8;

            font-size: 16px;
        }

        .filter {
            height: 42px;

            border: 1px solid #cbd5e1;
            border-radius: 8px;

            padding: 0 35px 0 12px;

            background: white;
            color: #334155;

            font-size: 14px;

            outline: none;
        }

        .filter:focus {
            border-color: #2563eb;
        }

        .total-data {
            white-space: nowrap;

            color: #64748b;

            font-size: 14px;
        }

        .total-data strong {
            color: #1e293b;
        }


        /* =========================
           TABLE
        ========================= */

        .table-card {
            background: white;

            border: 1px solid #e2e8f0;
            border-radius: 12px;

            overflow: hidden;

            box-shadow:
                0 2px 5px rgba(15, 23, 42, 0.03);
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;

            border-collapse: collapse;

            min-width: 1050px;
        }

        thead {
            background: #f8fafc;
        }

        th {
            padding: 16px 18px;

            text-align: left;

            font-size: 13px;
            font-weight: 700;

            color: #475569;

            border-bottom: 1px solid #e2e8f0;

            white-space: nowrap;
        }

        td {
            padding: 16px 18px;

            font-size: 14px;

            color: #334155;

            border-bottom: 1px solid #f1f5f9;

            vertical-align: middle;
        }

        tbody tr {
            transition: background 0.15s;
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

        .nis {
            font-weight: 600;
            color: #1e40af;
        }

        .nisn {
            color: #475569;
        }

        .student-name {
            font-weight: 600;
            color: #172554;
        }


        /* =========================
           BADGES
        ========================= */

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
           ACTION
        ========================= */

        .actions {
            display: flex;

            align-items: center;

            gap: 8px;

            white-space: nowrap;
        }

        .btn-detail,
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


        /* DETAIL */

        .btn-detail {
            background: #2563eb;
            color: white;
        }

        .btn-detail:hover {
            background: #1d4ed8;
        }


        /* EDIT */

        .btn-edit {
            background: #f59e0b;
            color: white;
        }

        .btn-edit:hover {
            background: #d97706;
        }


        /* DELETE */

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
                flex-direction: column;
                align-items: stretch;
            }

            .total-data {
                text-align: right;
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
                flex-wrap: wrap;
            }

        }

    </style>

</head>


<body>


    <!-- =========================
         MAIN
    ========================= -->

    <main class="container">


        <!-- =========================
             PAGE HEADER
        ========================= -->

        <div class="page-header">

            <div>

                <h1 class="page-title">
                    Data Siswa
                </h1>

                <p class="page-description">
                    Kelola data siswa Permata Bangsa School
                </p>

            </div>


            <?php if (session()->get('role') === 'admin'): ?>

                <div class="header-actions">

                    <form
    action="<?= base_url('/students/delete-all') ?>"
    method="post"
    class="delete-all-form"
    onsubmit="return confirm('Yakin ingin menghapus semua data siswa? Data yang sudah dihapus tidak dapat dikembalikan.');"
>
    <?= csrf_field() ?>

    <button
        type="submit"
        class="btn-delete-all"
    >
        🗑 Hapus Semua Data
    </button>
</form>

                    <a
                        href="<?= base_url('/students/create') ?>"
                        class="btn-add"
                    >
                        + Tambah Siswa
                    </a>

                </div>

            <?php endif; ?>


        </div>



        <!-- =========================
             ALERT SUCCESS
        ========================= -->

        <?php if (session()->getFlashdata('success')): ?>

            <div class="alert alert-success">

                <?= esc(session()->getFlashdata('success')) ?>

            </div>

        <?php endif; ?>



        <!-- =========================
             ALERT ERROR
        ========================= -->

        <?php if (session()->getFlashdata('error')): ?>

            <div class="alert alert-error">

                <?= esc(session()->getFlashdata('error')) ?>

            </div>

        <?php endif; ?>



        <!-- =========================
             TOOLBAR
        ========================= -->

        <div class="toolbar">


            <!-- SEARCH -->

            <div class="search-box">

                <span class="search-icon">
                    🔍
                </span>

                <input
                    type="text"
                    id="searchInput"
                    placeholder="Cari NIS, NISN, atau nama siswa..."
                    autocomplete="off"
                >

            </div>



            <!-- FILTER JENJANG -->

            <select
                id="levelFilter"
                class="filter"
            >

                <option value="">
                    Semua Jenjang
                </option>

                <option value="Playgroup">
                    Playgroup
                </option>

                <option value="Preschool">
                    Preschool
                </option>

                <option value="Elementary">
                    Elementary
                </option>

                <option value="Junior High">
                    Junior High
                </option>

                <option value="Senior High">
                    Senior High
                </option>

            </select>

            
            <!-- FILTER KELAS -->
            <select
                id="gradeFilter"
                class="filter"
                disabled
            >
                <option value="">
                    Semua Kelas
                </option>
            </select>

            <select id="sortFilter" class="filter">
    <option value="name-asc">Nama A-Z</option>
    <option value="name-desc">Nama Z-A</option>
    <option value="nis-asc">NIS ↑</option>
    <option value="nis-desc">NIS ↓</option>
</select>


            <!-- TOTAL -->

            <div class="total-data">

                Total:

                <strong id="totalStudents">
                    <?= count($students) ?>
                </strong>

                siswa

            </div>


        </div>



        <!-- =========================
             TABLE
        ========================= -->

        <div class="table-card">

            <div class="table-wrapper">

                <table id="studentTable">


                    <!-- TABLE HEADER -->

                    <thead>

                        <tr>

                            <th class="number">
                                No
                            </th>

                            <th>
                                NIS
                            </th>

                            <th>
                                NISN
                            </th>

                            <th>
                                Nama Siswa
                            </th>

                            <th>
                                Jenis Kelamin
                            </th>

                            <th>
                                Kelas
                            </th>

                            <th>
                                Jenjang
                            </th>

                            <th>
                                Tahun Ajaran
                            </th>

                            <th>
                                Aksi
                            </th>

                        </tr>

                    </thead>



                    <!-- TABLE BODY -->

                    <tbody>


                        <?php if (!empty($students)): ?>


                            <?php $no = 1; ?>


                            <?php foreach ($students as $student): ?>


                                <tr
                                    data-level="<?= esc($student['grade_level'] ?? '') ?>"
                                    data-grade="<?= esc($student['grade_name'] ?? '') ?>"
                                    data-name="<?= esc(strtolower($student['name'])) ?>"
    data-nis="<?= esc($student['nis'] ?? '') ?>"
                                >


                                    <!-- NO -->

                                    <td class="number">

                                        <?= $no++ ?>

                                    </td>



                                    <!-- NIS -->

                                    <td class="nis">

                                        <?= esc($student['nis'] ?? '-') ?>

                                    </td>



                                    <!-- NISN -->

                                    <td class="nisn">

                                        <?= esc($student['nisn'] ?: '-') ?>

                                    </td>



                                    <!-- NAMA -->

                                    <td class="student-name">

                                        <?= esc($student['name'] ?? '-') ?>

                                    </td>



                                    <!-- JENIS KELAMIN -->

                                    <td>

                                        <?= esc($student['gender'] ?: '-') ?>

                                    </td>



                                    <!-- KELAS -->

                                    <td>

                                        <span class="badge badge-grade">

                                            <?= esc($student['grade_name'] ?? '-') ?>

                                        </span>

                                    </td>



                                    <!-- JENJANG -->

                                    <td>

                                        <span class="badge badge-level">

                                            <?= esc($student['grade_level'] ?? '-') ?>

                                        </span>

                                    </td>



                                    <!-- TAHUN AJARAN -->

                                    <td>

                                        <span class="badge badge-year">

                                            <?= esc($student['academic_year'] ?? '-') ?>

                                        </span>

                                    </td>



                                    <!-- AKSI -->

                                    <td>

                                        <div class="actions">


                                            <!-- DETAIL -->
                                            <a
                                                href="<?= base_url('/students/detail/' . $student['id']) ?>"
                                                class="btn-detail"
                                            >
                                                Detail
                                            </a>



                                            <?php if (session()->get('role') === 'admin'): ?>


                                                <!-- EDIT -->

                                                <a
                                                    href="<?= base_url('/students/edit/' . $student['id']) ?>"
                                                    class="btn-edit"
                                                >
                                                    Edit
                                                </a>



                                                <!-- DELETE -->

                                                <form
                                                    action="<?= base_url('/students/delete/' . $student['id']) ?>"
                                                    method="post"
                                                    class="delete-form"
                                                    onsubmit="return confirm('Yakin ingin menghapus data siswa ini?');"
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


                            <!-- EMPTY STATE -->

                            <tr>

                                <td colspan="9">

                                    <div class="empty-state">

                                        <div class="empty-icon">
                                            👨‍🎓
                                        </div>

                                        <h3>
                                            Belum ada data siswa
                                        </h3>

                                        <p>
                                            Silakan tambahkan data siswa terlebih dahulu.
                                        </p>

                                    </div>

                                </td>

                            </tr>


                        <?php endif; ?>


                    </tbody>


                </table>

            </div>

            <div class="pagination-bar" id="paginationBar">
                <div class="pagination-info" id="paginationInfo">
                    Menampilkan <strong>0</strong> data
                </div>
                <div class="pagination-controls" id="paginationControls"></div>
            </div>

        </div>


    </main>



    <!-- =========================
         SEARCH & FILTER
    ========================= -->

    <script>
        const searchInput = document.getElementById('searchInput');
        const levelFilter = document.getElementById('levelFilter');
        const gradeFilter = document.getElementById('gradeFilter');
        const sortFilter = document.getElementById('sortFilter');
        const table = document.getElementById('studentTable');
        const tbody = table.querySelector('tbody');
        const totalStudents = document.getElementById('totalStudents');
        const paginationBar = document.getElementById('paginationBar');
        const paginationInfo = document.getElementById('paginationInfo');
        const paginationControls = document.getElementById('paginationControls');

        const rows = Array.from(tbody.querySelectorAll('tr[data-level]'));
        const perPage = 10;
        let currentPage = 1;

        // Buat pilihan kelas berdasarkan jenjang yang dipilih.
        function updateGradeFilter() {
            const selectedLevel = levelFilter.value.trim().toLowerCase();
            const currentGrade = gradeFilter.value;

            const grades = [...new Set(
                rows
                    .filter(function(row) {
                        const rowLevel = (row.dataset.level || '').trim().toLowerCase();
                        return selectedLevel === '' || rowLevel === selectedLevel;
                    })
                    .map(function(row) {
                        return (row.dataset.grade || '').trim();
                    })
                    .filter(function(grade) {
                        return grade !== '';
                    })
            )];

            grades.sort(function(a, b) {
                return a.localeCompare(b, 'id', {
                    numeric: true,
                    sensitivity: 'base'
                });
            });

            gradeFilter.innerHTML = '';

            const allOption = document.createElement('option');
            allOption.value = '';
            allOption.textContent = selectedLevel === ''
                ? 'Semua Kelas'
                : 'Semua Kelas di ' + levelFilter.value;
            gradeFilter.appendChild(allOption);

            grades.forEach(function(grade) {
                const option = document.createElement('option');
                option.value = grade;
                option.textContent = grade;
                gradeFilter.appendChild(option);
            });

            gradeFilter.disabled = grades.length === 0;

            if (grades.includes(currentGrade)) {
                gradeFilter.value = currentGrade;
            } else {
                gradeFilter.value = '';
            }
        }

        function sortRows() {
            const sortValue = sortFilter.value;

            rows.sort(function(a, b) {
                if (sortValue === 'name-asc') {
                    return a.dataset.name.localeCompare(
                        b.dataset.name,
                        'id',
                        { sensitivity: 'base' }
                    );
                }

                if (sortValue === 'name-desc') {
                    return b.dataset.name.localeCompare(
                        a.dataset.name,
                        'id',
                        { sensitivity: 'base' }
                    );
                }

                if (sortValue === 'nis-asc') {
                    const nisA = (a.dataset.nis || '').trim();
                    const nisB = (b.dataset.nis || '').trim();
                    if (nisA === '') return 1;
                    if (nisB === '') return -1;
                    return nisA.localeCompare(nisB, 'id', { numeric: true });
                }

                if (sortValue === 'nis-desc') {
                    const nisA = (a.dataset.nis || '').trim();
                    const nisB = (b.dataset.nis || '').trim();
                    if (nisA === '') return 1;
                    if (nisB === '') return -1;
                    return nisB.localeCompare(nisA, 'id', { numeric: true });
                }

                return 0;
            });

            rows.forEach(function(row) {
                tbody.appendChild(row);
            });
        }

        function getFilteredRows() {
            const searchValue = searchInput.value.toLowerCase().trim();
            const levelValue = levelFilter.value.toLowerCase().trim();
            const gradeValue = gradeFilter.value.toLowerCase().trim();

            return rows.filter(function(row) {
                const rowText = row.innerText.toLowerCase();
                const rowLevel = (row.dataset.level || '').toLowerCase().trim();
                const rowGrade = (row.dataset.grade || '').toLowerCase().trim();

                const matchSearch = rowText.includes(searchValue);
                const matchLevel = levelValue === '' || rowLevel === levelValue;
                const matchGrade = gradeValue === '' || rowGrade === gradeValue;

                return matchSearch && matchLevel && matchGrade;
            });
        }

        function createPageButton(label, page, disabled, active) {
            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'pagination-btn' + (active ? ' active' : '');
            button.textContent = label;
            button.disabled = disabled;

            if (!disabled) {
                button.addEventListener('click', function() {
                    currentPage = page;
                    renderTable();
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });
            }

            return button;
        }

        function renderPagination(total, totalPages, start, end) {
            paginationControls.innerHTML = '';

            if (total === 0) {
                paginationInfo.innerHTML = 'Menampilkan <strong>0</strong> data';
                paginationBar.style.display = 'none';
                return;
            }

            paginationBar.style.display = 'flex';
            paginationInfo.innerHTML =
                'Menampilkan <strong>' + start + '-' + end + '</strong> dari <strong>' + total + '</strong> siswa';

            paginationControls.appendChild(
                createPageButton('‹', currentPage - 1, currentPage === 1, false)
            );

            const pages = [];

            if (totalPages <= 7) {
                for (let page = 1; page <= totalPages; page++) {
                    pages.push(page);
                }
            } else {
                pages.push(1);

                if (currentPage > 4) {
                    pages.push('...');
                }

                const pageStart = Math.max(2, currentPage - 1);
                const pageEnd = Math.min(totalPages - 1, currentPage + 1);

                for (let page = pageStart; page <= pageEnd; page++) {
                    pages.push(page);
                }

                if (currentPage < totalPages - 3) {
                    pages.push('...');
                }

                pages.push(totalPages);
            }

            pages.forEach(function(page) {
                if (page === '...') {
                    const span = document.createElement('span');
                    span.className = 'pagination-ellipsis';
                    span.textContent = '…';
                    paginationControls.appendChild(span);
                    return;
                }

                paginationControls.appendChild(
                    createPageButton(String(page), page, false, page === currentPage)
                );
            });

            paginationControls.appendChild(
                createPageButton('›', currentPage + 1, currentPage === totalPages, false)
            );
        }

        function renderTable() {
            sortRows();

            const filteredRows = getFilteredRows();
            const total = filteredRows.length;
            const totalPages = Math.max(1, Math.ceil(total / perPage));

            if (currentPage > totalPages) {
                currentPage = totalPages;
            }

            const startIndex = (currentPage - 1) * perPage;
            const endIndex = Math.min(startIndex + perPage, total);
            const visibleRows = filteredRows.slice(startIndex, endIndex);

            rows.forEach(function(row) {
                row.style.display = 'none';
            });

            visibleRows.forEach(function(row, index) {
                row.style.display = '';
                row.querySelector('.number').textContent = startIndex + index + 1;
            });

            totalStudents.textContent = total;

            // Jika pencarian/filter tidak menemukan data.
            let filteredEmptyRow = document.getElementById('filteredEmptyRow');
            if (total === 0 && rows.length > 0) {
                if (!filteredEmptyRow) {
                    filteredEmptyRow = document.createElement('tr');
                    filteredEmptyRow.id = 'filteredEmptyRow';
                    filteredEmptyRow.innerHTML = `
                        <td colspan="9">
                            <div class="empty-state">
                                <div class="empty-icon">🔎</div>
                                <h3>Data tidak ditemukan</h3>
                                <p>Coba ubah kata kunci pencarian atau filter.</p>
                            </div>
                        </td>
                    `;
                    tbody.appendChild(filteredEmptyRow);
                }
                filteredEmptyRow.style.display = '';
            } else if (filteredEmptyRow) {
                filteredEmptyRow.style.display = 'none';
            }

            renderPagination(total, totalPages, startIndex + 1, endIndex);
        }

        function resetToFirstPage() {
            currentPage = 1;
            renderTable();
        }

        searchInput.addEventListener('input', resetToFirstPage);

        levelFilter.addEventListener('change', function() {
            updateGradeFilter();
            resetToFirstPage();
        });

        gradeFilter.addEventListener('change', resetToFirstPage);
        sortFilter.addEventListener('change', resetToFirstPage);

        // Jalankan saat halaman pertama kali dibuka.
        updateGradeFilter();
        renderTable();
    </script>

<?= view('layouts/footer') ?>

</body>

</html>