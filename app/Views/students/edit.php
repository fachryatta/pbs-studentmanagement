<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Edit Siswa - Student Management</title>

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

        .navbar {
            height: 65px;
            background: white;
            border-bottom: 1px solid #e5e7eb;

            display: flex;
            align-items: center;
            justify-content: space-between;

            padding: 0 35px;
        }

        .brand {
            font-size: 20px;
            font-weight: bold;
            color: #2563eb;
        }

        .navbar a {
            color: #374151;
            text-decoration: none;
        }

        .container {
            max-width: 1100px;
            margin: auto;
            padding: 30px;
        }

        .page-header {
            margin-bottom: 25px;
        }

        .page-header h1 {
            margin: 0 0 7px;
            font-size: 28px;
        }

        .page-header p {
            margin: 0;
            color: #6b7280;
        }

        .form-card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 30px;
        }

        .section {
            margin-bottom: 30px;
        }

        .section:last-child {
            margin-bottom: 0;
        }

        .section-title {
            font-size: 17px;
            font-weight: bold;
            margin-bottom: 18px;

            padding-bottom: 10px;

            border-bottom: 1px solid #e5e7eb;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 18px 25px;
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
            margin-bottom: 7px;
        }

        .required {
            color: #dc2626;
        }

        input,
        select,
        textarea {
            width: 100%;

            padding: 10px 12px;

            border: 1px solid #d1d5db;

            border-radius: 6px;

            font-size: 14px;

            font-family: inherit;

            background: white;
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: none;

            border-color: #2563eb;

            box-shadow:
                0 0 0 2px rgba(37, 99, 235, 0.1);
        }

        textarea {
            min-height: 90px;
            resize: vertical;
        }

        .help {
            margin-top: 5px;

            font-size: 12px;

            color: #6b7280;
        }

        .error-box {
            background: #fee2e2;

            color: #991b1b;

            padding: 12px 15px;

            border-radius: 7px;

            margin-bottom: 25px;

            font-size: 14px;
        }

        .error-box div {
            margin: 3px 0;
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
            display: inline-block;

            padding: 10px 18px;

            border-radius: 7px;

            border: none;

            font-size: 14px;

            cursor: pointer;

            text-decoration: none;
        }

        .btn-primary {
            background: #2563eb;

            color: white;
        }

        .btn-secondary {
            background: #e5e7eb;

            color: #374151;
            
        }

        .btn-primary:hover {
            background: #1d4ed8;
        }

        .btn-secondary:hover {
            background: #d1d5db;
        }

        @media (max-width: 768px) {

            .navbar {
                padding: 0 20px;
            }

            .container {
                padding: 20px;
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

            .page-header {
        flex-direction: column;
        align-items: flex-start;
    }

    .page-header .btn {
        width: auto;
    }

        }

        /* ==========================
           PARENT SEARCH
        ========================== */

        .parent-search-wrapper {
            position: relative;
        }

        .parent-search-input {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #d1d5db;
            border-radius: 7px;
            font-size: 14px;
            background: white;
        }

        .parent-search-input:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.1);
        }

        .parent-results {
            position: absolute;
            top: calc(100% + 5px);
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #d1d5db;
            border-radius: 7px;
            max-height: 260px;
            overflow-y: auto;
            z-index: 100;
            display: none;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        }

        .parent-result {
            padding: 11px 14px;
            cursor: pointer;
            border-bottom: 1px solid #f1f5f9;
        }

        .parent-result:last-child {
            border-bottom: none;
        }

        .parent-result:hover {
            background: #f3f6fb;
        }

        .parent-result-name {
            font-weight: 600;
            color: #1f2937;
        }

        .parent-result-id {
            margin-top: 3px;
            font-size: 12px;
            color: #6b7280;
        }

        .parent-selected {
            margin-top: 8px;
            padding: 9px 12px;
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 6px;
            color: #1d4ed8;
            font-size: 13px;
            display: none;
        }

        .parent-selected strong {
            font-weight: 600;
        }

        .parent-clear {
            float: right;
            border: none;
            background: transparent;
            color: #dc2626;
            cursor: pointer;
            font-size: 12px;
            padding: 0;
        }

        .parent-help {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    flex-wrap: wrap;
}

.btn-add-parent {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;

    padding: 10px 16px;

    background: #2563eb;
    color: #ffffff !important;

    border: 1px solid #2563eb;
    border-radius: 8px;

    font-size: 14px;
    font-weight: 600;

    text-decoration: none !important;

    transition:
        background 0.2s ease,
        border-color 0.2s ease,
        transform 0.2s ease,
        box-shadow 0.2s ease;
}

.btn-add-parent:hover {
    background: #1d4ed8;
    border-color: #1d4ed8;
    color: #ffffff !important;

    transform: translateY(-1px);

    box-shadow: 0 4px 10px rgba(37, 99, 235, 0.20);
}

.btn-add-parent:active {
    transform: translateY(0);
}

.btn-add-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;

    width: 20px;
    height: 20px;

    border-radius: 50%;

    background: rgba(255, 255, 255, 0.20);

    font-size: 17px;
    font-weight: 700;
    line-height: 1;
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
    margin-bottom: 30px;
}

.page-header-content {
    flex: 1;
}

.page-header-content h1 {
    margin: 0 0 8px 0;
}

.page-header-content p {
    margin: 0;
}

    </style>

</head>


<body>


<!-- CONTENT -->

<div class="container">


    <div class="page-header">

    <div class="page-header-content">

        <h1>
            Edit Data Siswa
        </h1>

        <p>
            Perbarui informasi siswa yang dipilih.
        </p>

    </div>

    <a href="<?= base_url('/students') ?>" class="btn btn-secondary">
        ← Kembali Ke Data Siswa
    </a>

</div>


    <!-- VALIDATION ERROR -->

    <?php if (session()->get('errors')): ?>

        <div class="error-box">

            <strong>
                Terdapat kesalahan:
            </strong>

            <?php foreach (session()->get('errors') as $error): ?>

                <div>
                    • <?= esc($error) ?>
                </div>

            <?php endforeach; ?>

        </div>

    <?php endif; ?>


    <div class="form-card">


        <form
            action="<?= base_url('students/update/' . $student['id']) ?>"
            method="post"
        >

            <?= csrf_field() ?>


            <!-- ==========================
                 DATA IDENTITAS
            =========================== -->

            <div class="section">

                <div class="section-title">
                    Data Identitas
                </div>


                <div class="form-grid">


                    <!-- NIS -->

                    <div class="form-group">

                        <label for="nis">
                            NIS
                        </label>

                        <input
                            type="text"
                            id="nis"
                            name="nis"
                            value="<?= old('nis', $student['nis'] ?? '') ?>"
                        >

                    </div>


                    <!-- NISN -->

                    <div class="form-group">

                        <label for="nisn">
                            NISN
                        </label>

                        <input
                            type="text"
                            id="nisn"
                            name="nisn"
                            value="<?= old('nisn', $student['nisn']) ?>"
                        >

                    </div>


                    <!-- NIK -->

                    <div class="form-group">

                        <label for="nik">
                            NIK
                        </label>

                        <input
                            type="text"
                            id="nik"
                            name="nik"
                            value="<?= old('nik', $student['nik']) ?>"
                        >

                    </div>


                    <!-- NO KK -->

                    <div class="form-group">

                        <label for="no_kk">
                            No. KK
                        </label>

                        <input
                            type="text"
                            id="no_kk"
                            name="no_kk"
                            value="<?= old('no_kk', $student['no_kk']) ?>"
                        >

                    </div>


                    <!-- NAMA -->

                    <div class="form-group full">

                        <label for="name">
                            Nama Siswa
                            <span class="required">*</span>
                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="<?= old('name', $student['name']) ?>"
                            required
                        >

                    </div>


                    <!-- TEMPAT LAHIR -->

                    <div class="form-group">

                        <label for="birth_place">
                            Tempat Lahir
                        </label>

                        <input
                            type="text"
                            id="birth_place"
                            name="birth_place"
                            value="<?= old('birth_place', $student['birth_place']) ?>"
                        >

                    </div>


                    <!-- TANGGAL LAHIR -->

                    <div class="form-group">

                        <label for="birth_date">
                            Tanggal Lahir
                        </label>

                        <input
                            type="date"
                            id="birth_date"
                            name="birth_date"
                            value="<?= old('birth_date', $student['birth_date']) ?>"
                        >

                    </div>


                    <!-- JENIS KELAMIN -->

                    <div class="form-group">

                        <label for="gender">
                            Jenis Kelamin
                        </label>

                        <select
                            id="gender"
                            name="gender"
                        >

                            <option value="">
                                -- Pilih Jenis Kelamin --
                            </option>

                            <option
                                value="Laki-laki"
                                <?= old('gender', $student['gender']) === 'Laki-laki' ? 'selected' : '' ?>
                            >
                                Laki-laki
                            </option>

                            <option
                                value="Perempuan"
                                <?= old('gender', $student['gender']) === 'Perempuan' ? 'selected' : '' ?>
                            >
                                Perempuan
                            </option>

                        </select>

                    </div>


                    <!-- AGAMA -->

                    <div class="form-group">

                        <label for="religion">
                            Agama
                        </label>

                        <input
                            type="text"
                            id="religion"
                            name="religion"
                            value="<?= old('religion', $student['religion']) ?>"
                        >

                    </div>


                </div>

            </div>


            <!-- ==========================
                 DATA ORANG TUA & KONTAK
            =========================== -->

            <div class="section">

                <div class="section-title">
                    Data Orang Tua & Kontak
                </div>


                <div class="form-grid">


                    <!-- ORANG TUA / WALI -->

                    <div class="form-group full">

                        <label for="parentSearch">
                            Orang Tua / Wali
                        </label>

                        <div class="parent-search-wrapper">

                            <input
                                type="text"
                                id="parentSearch"
                                class="parent-search-input"
                                placeholder="🔍 Cari nama wali/orang tua..."
                                autocomplete="off"
                            >

                            <input
                                type="hidden"
                                name="parent_id"
                                id="parent_id"
                                value="<?= old('parent_id', $student['parent_id'] ?? '') ?>"
                            >

                            <div id="parentResults" class="parent-results">

                                <?php foreach ($parents as $parent): ?>

                                    <div
                                        class="parent-result"
                                        data-id="<?= esc($parent['id']) ?>"
                                        data-search="<?= esc(strtolower(($parent['guardian_1'] ?? '') . ' ' . ($parent['guardian_2'] ?? '') . ' ' . ($parent['address'] ?? ''))) ?>"
                                    >

                                        <div class="parent-result-name">
                                            <?= esc($parent['guardian_1'] ?: 'Tanpa nama') ?>
                                            <?php if (!empty($parent['guardian_2'])): ?>
                                                &amp; <?= esc($parent['guardian_2']) ?>
                                            <?php endif; ?>
                                        </div>

                                        <?php if (!empty($parent['address'])): ?>
                                            <div class="parent-result-id">
                                                <?= esc($parent['address']) ?>
                                            </div>
                                        <?php endif; ?>

                                    </div>

                                <?php endforeach; ?>

                            </div>

                            <div id="selectedParent" class="parent-selected">
                                <strong id="selectedParentName"></strong>
                                <button type="button" id="clearParent" class="parent-clear">
                                    Hapus pilihan
                                </button>
                            </div>

                        </div>

                        <div class="help">
                            Ketik nama wali/orang tua untuk mencari data yang sudah terdaftar.
                        </div>

                        <div class="help parent-help">
                            <span>Data alamat, email, dan nomor telepon dikelola di menu Data Orang Tua.</span>
                            <a href="<?= base_url('parents/create') ?>" class="btn-add-parent">
                                <span class="btn-add-icon">+</span>
                                Tambah Orang Tua
                            </a>
                        </div>

                    </div>



                </div>

            </div>


            <!-- ==========================
                 DATA AKADEMIK
            =========================== -->

            <div class="section">

                <div class="section-title">
                    Data Akademik
                </div>


                <div class="form-grid">


                    <!-- KELAS -->

                    <div class="form-group">

                        <label for="grade_id">
                            Kelas
                            <span class="required">*</span>
                        </label>

                        <select
                            id="grade_id"
                            name="grade_id"
                            required
                        >

                            <option value="">
                                -- Pilih Kelas --
                            </option>


                            <?php foreach ($grades as $grade): ?>

                                <option
                                    value="<?= $grade['id'] ?>"
                                    <?= old(
    'grade_id',
    $studentAcademic['grade_id'] ?? ''
) == $grade['id'] ? 'selected' : '' ?>
                                >

                                    <?= esc($grade['name']) ?>

                                    -
                                    <?= esc($grade['level']) ?>

                                </option>

                            <?php endforeach; ?>


                        </select>

                    </div>


                    <!-- TAHUN AJARAN -->

                    <div class="form-group">

                        <label for="academic_year_id">
                            Tahun Ajaran
                            <span class="required">*</span>
                        </label>

                        <select
                            id="academic_year_id"
                            name="academic_year_id"
                            required
                        >

                            <option value="">
                                -- Pilih Tahun Ajaran --
                            </option>


                            <?php foreach ($academicYears as $academicYear): ?>

                                <option
                                    value="<?= $academicYear['id'] ?>"
                                    <?= old(
    'academic_year_id',
    $studentAcademic['academic_year_id']
        ?? ($activeAcademicYear['id'] ?? '')
) == $academicYear['id'] ? 'selected' : '' ?>
                                >

                                    <?= esc($academicYear['year']) ?>

                                </option>

                            <?php endforeach; ?>


                        </select>

                    </div>


                </div>

            </div>


            <!-- ACTION -->

            <div class="actions">

                <a
                    href="<?= base_url('students') ?>"
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


</div>

<?= view('layouts/footer') ?>



<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('parentSearch');
    const parentIdInput = document.getElementById('parent_id');
    const results = document.getElementById('parentResults');
    const selectedParent = document.getElementById('selectedParent');
    const selectedParentName = document.getElementById('selectedParentName');
    const clearParent = document.getElementById('clearParent');
    const parentItems = document.querySelectorAll('.parent-result');

    if (!searchInput || !parentIdInput || !results || !selectedParent || !selectedParentName || !clearParent) {
        return;
    }

    function filterParents() {
        const keyword = searchInput.value.toLowerCase().trim();
        parentItems.forEach(function (item) {
            const searchText = item.dataset.search || '';
            item.style.display = (keyword === '' || searchText.includes(keyword)) ? 'block' : 'none';
        });
        results.style.display = 'block';
    }

    searchInput.addEventListener('focus', filterParents);
    searchInput.addEventListener('input', function () {
        // Jika pengguna mengubah teks pencarian, minta mereka memilih hasil lagi.
        parentIdInput.value = '';
        selectedParentName.textContent = '';
        selectedParent.style.display = 'none';
        filterParents();
    });

    parentItems.forEach(function (item) {
        item.addEventListener('click', function () {
            const id = this.dataset.id;
            const name = this.querySelector('.parent-result-name').innerText.trim();
            parentIdInput.value = id;
            searchInput.value = name;
            selectedParentName.textContent = name;
            selectedParent.style.display = 'block';
            results.style.display = 'none';
        });
    });

    clearParent.addEventListener('click', function () {
        parentIdInput.value = '';
        searchInput.value = '';
        selectedParentName.textContent = '';
        selectedParent.style.display = 'none';
        results.style.display = 'none';
        searchInput.focus();
    });

    document.addEventListener('click', function (event) {
        if (!event.target.closest('.parent-search-wrapper')) {
            results.style.display = 'none';
        }
    });

    // Saat form dibuka, tampilkan orang tua yang sudah terhubung dengan siswa.
    const selectedId = parentIdInput.value;
    if (selectedId) {
        parentItems.forEach(function (item) {
            if (item.dataset.id === selectedId) {
                const name = item.querySelector('.parent-result-name').innerText.trim();
                searchInput.value = name;
                selectedParentName.textContent = name;
                selectedParent.style.display = 'block';
            }
        });
    }
});
</script>

</body>

</html>