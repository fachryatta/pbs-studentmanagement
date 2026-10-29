<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        <?= esc($title ?? 'Export Data Siswa') ?> - Student Management
    </title>

    <?= $this->include('layouts/header') ?>

    <style>

        /* =========================================================
           GLOBAL
        ========================================================= */

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f5f7fb;
            color: #1e293b;
        }


        /* =========================================================
           CONTAINER
        ========================================================= */

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px;
        }


        /* =========================================================
           PAGE HEADER
        ========================================================= */

        .page-header {
            margin-bottom: 28px;
        }

        .page-title {
            margin: 0 0 8px;
            font-size: 32px;
            font-weight: 700;
            color: #172554;
        }

        .page-description {
            margin: 0;
            color: #64748b;
            font-size: 15px;
            line-height: 1.6;
        }


        /* =========================================================
           EXPORT CARD
        ========================================================= */

        .export-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            padding: 30px;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
        }


        /* =========================================================
           SECTION
        ========================================================= */

        .section {
            margin-bottom: 30px;
        }

        .section:last-child {
            margin-bottom: 0;
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 10px;

            margin-bottom: 18px;
            padding-bottom: 12px;

            border-bottom: 1px solid #e5e7eb;

            font-size: 18px;
            font-weight: 700;
            color: #172554;
        }

        .section-number {
            width: 28px;
            height: 28px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border-radius: 50%;

            background: #2563eb;
            color: #ffffff;

            font-size: 13px;
            font-weight: 700;
        }


        /* =========================================================
           FORM GRID
        ========================================================= */

        .form-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            margin-bottom: 8px;

            font-size: 14px;
            font-weight: 600;
            color: #334155;
        }

        .required {
            color: #dc2626;
        }


        /* =========================================================
           SELECT
        ========================================================= */

        select {
            width: 100%;

            padding: 11px 13px;

            border: 1px solid #cbd5e1;
            border-radius: 8px;

            background: #ffffff;
            color: #1e293b;

            font-family: inherit;
            font-size: 14px;

            cursor: pointer;
        }

        select:focus {
            outline: none;

            border-color: #2563eb;

            box-shadow:
                0 0 0 3px rgba(37, 99, 235, 0.10);
        }

        select:disabled {
            background: #f1f5f9;
            color: #94a3b8;
            cursor: not-allowed;
        }


        /* =========================================================
           MULTI SELECT KELAS
        ========================================================= */

        .grade-select {
            min-height: 220px;
            padding: 8px;
        }

        .grade-select option {
            padding: 8px 10px;
        }

        .grade-select optgroup {
            font-weight: 700;
            color: #172554;
        }


        /* =========================================================
           ALL GRADES CHECKBOX
        ========================================================= */

        .all-grades-wrapper {
            display: flex;
            align-items: center;
            gap: 10px;

            margin-top: 12px;

            padding: 12px 14px;

            background: #f8fafc;

            border: 1px solid #e2e8f0;
            border-radius: 8px;
        }

        .all-grades-wrapper input {
            width: 17px;
            height: 17px;

            margin: 0;

            accent-color: #2563eb;

            cursor: pointer;
        }

        .all-grades-wrapper label {
            margin: 0;

            font-size: 14px;
            font-weight: 600;

            color: #334155;

            cursor: pointer;
        }


        /* =========================================================
           HELP TEXT
        ========================================================= */

        .help-text {
            margin-top: 7px;

            color: #64748b;

            font-size: 12px;
            line-height: 1.5;
        }


        /* =========================================================
           SELECTED INFO
        ========================================================= */

        .selected-info {
            margin-top: 8px;

            font-size: 12px;

            color: #2563eb;
            font-weight: 600;
        }


        /* =========================================================
           COLUMN HEADER
        ========================================================= */

        .column-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 15px;

            margin-bottom: 18px;
        }

        .column-description {
            color: #64748b;
            font-size: 13px;
            line-height: 1.5;
        }

        .column-actions {
            display: flex;
            gap: 8px;
            flex-shrink: 0;
        }


        /* =========================================================
           SMALL BUTTON
        ========================================================= */

        .btn-small {
            border: 1px solid #cbd5e1;

            background: #ffffff;
            color: #334155;

            padding: 8px 12px;

            border-radius: 7px;

            font-family: inherit;
            font-size: 12px;
            font-weight: 600;

            cursor: pointer;

            transition: 0.2s;
        }

        .btn-small:hover {
            background: #f8fafc;
            border-color: #94a3b8;
        }


        /* =========================================================
           COLUMN GROUP
        ========================================================= */

        .column-group {
            margin-bottom: 18px;

            border: 1px solid #e2e8f0;
            border-radius: 10px;

            overflow: hidden;
        }

        .column-group:last-child {
            margin-bottom: 0;
        }

        .column-group-title {
            padding: 12px 15px;

            background: #f8fafc;

            border-bottom: 1px solid #e2e8f0;

            font-size: 14px;
            font-weight: 700;
            color: #334155;
        }

        .column-grid {
            display: grid;

            grid-template-columns:
                repeat(3, minmax(0, 1fr));

            gap: 0;

            padding: 8px;
        }


        /* =========================================================
           CHECKBOX
        ========================================================= */

        .checkbox-item {
            display: flex;
            align-items: center;

            gap: 9px;

            padding: 10px;

            border-radius: 7px;

            cursor: pointer;

            transition: 0.15s;
        }

        .checkbox-item:hover {
            background: #f8fafc;
        }

        .checkbox-item input {
            width: 16px;
            height: 16px;

            margin: 0;

            accent-color: #2563eb;

            cursor: pointer;
        }

        .checkbox-item span {
            font-size: 13px;
            color: #334155;
        }


        /* =========================================================
           ACTION AREA
        ========================================================= */

        .actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;

            gap: 10px;

            margin-top: 30px;
            padding-top: 22px;

            border-top: 1px solid #e5e7eb;
        }


        /* =========================================================
           BUTTON
        ========================================================= */

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 8px;

            padding: 11px 18px;

            border-radius: 8px;

            font-family: inherit;
            font-size: 14px;
            font-weight: 600;

            text-decoration: none;

            cursor: pointer;

            transition: 0.2s;
        }

        .btn-secondary {
            background: #f1f5f9;
            color: #334155;

            border: 1px solid #e2e8f0;
        }

        .btn-secondary:hover {
            background: #e2e8f0;
        }

        .btn-primary {
            background: #2563eb;
            color: #ffffff;

            border: 1px solid #2563eb;
        }

        .btn-primary:hover {
            background: #1d4ed8;
            border-color: #1d4ed8;

            transform: translateY(-1px);
        }


        /* =========================================================
           INFO BOX
        ========================================================= */

        .info-box {
            display: flex;
            align-items: flex-start;

            gap: 10px;

            margin-bottom: 25px;

            padding: 13px 15px;

            background: #eff6ff;

            border: 1px solid #bfdbfe;
            border-radius: 9px;

            color: #1e40af;

            font-size: 13px;
            line-height: 1.6;
        }

        .info-icon {
            flex-shrink: 0;

            font-size: 16px;
        }


        /* =========================================================
           RESPONSIVE
        ========================================================= */

        @media (max-width: 900px) {

            .container {
                padding: 30px 20px;
            }

            .column-grid {
                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
            }

        }


        @media (max-width: 650px) {

            .container {
                padding: 25px 15px;
            }

            .export-card {
                padding: 20px;
            }

            .page-title {
                font-size: 27px;
            }

            .column-toolbar {
                flex-direction: column;
                align-items: flex-start;
            }

            .column-grid {
                grid-template-columns: 1fr;
            }

            .actions {
                flex-direction: column-reverse;
                align-items: stretch;
            }

            .actions .btn {
                width: 100%;
            }

        }

    </style>

</head>


<body>


<!-- =========================================================
     CONTENT
========================================================= -->

<div class="container">


    <!-- =====================================================
         PAGE HEADER
    ====================================================== -->

    <div class="page-header">

        <h1 class="page-title">
            Export Data Siswa
        </h1>

        <p class="page-description">
            Pilih tahun pelajaran, kelas, dan kolom data
            yang ingin kamu export ke file Excel.
        </p>

    </div>



    <!-- =====================================================
         EXPORT CARD
    ====================================================== -->

    <div class="export-card">


        <!-- =================================================
             INFO
        ================================================== -->

        <div class="info-box">

            <div class="info-icon">
                ℹ️
            </div>

            <div>
                Data Excel akan dibuat berdasarkan tahun pelajaran
                dan kelas yang kamu pilih. Kamu dapat memilih
                beberapa kelas sekaligus, bahkan dari jenjang
                yang berbeda.
            </div>

        </div>



        <!-- =================================================
             FORM
        ================================================== -->

        <form
            action="<?= base_url('students/export/download') ?>"
            method="get"
            id="exportForm"
        >


            <!-- =================================================
                 FILTER DATA
            ================================================== -->

            <div class="section">


                <div class="section-title">

                    <span class="section-number">
                        1
                    </span>

                    Filter Data

                </div>



                <div class="form-grid">


                    <!-- =========================================
                         TAHUN PELAJARAN
                    ========================================== -->

                    <div class="form-group">

                        <label for="academic_year_id">

                            Tahun Pelajaran

                            <span class="required">
                                *
                            </span>

                        </label>


                        <select
                            id="academic_year_id"
                            name="academic_year_id"
                            required
                        >

                            <option value="">
                                -- Pilih Tahun Pelajaran --
                            </option>


                            <?php foreach (($academicYears ?? []) as $academicYear): ?>

                                <option
                                    value="<?= esc($academicYear['id']) ?>"
                                >

                                    <?= esc($academicYear['year']) ?>


                                    <?php if (!empty($academicYear['is_active'])): ?>

                                        — Aktif

                                    <?php endif; ?>

                                </option>

                            <?php endforeach; ?>


                        </select>


                        <div class="help-text">

                            Tentukan tahun pelajaran yang datanya
                            ingin diambil.

                        </div>

                    </div>



                    <!-- =========================================
                         KELAS
                    ========================================== -->

                    <div class="form-group">

                        <label for="grade_id">

                            Kelas

                        </label>


                        <select
                            id="grade_id"
                            name="grade_id[]"
                            class="grade-select"
                            multiple
                            disabled
                        >

                            <?php
                            /*
                             * =====================================================
                             * GROUP KELAS BERDASARKAN JENJANG
                             *
                             * Jenjang bukan lagi filter.
                             * Hanya digunakan sebagai grouping visual.
                             * =====================================================
                             */

                            $gradesByLevel = [];

                            foreach (($grades ?? []) as $grade) {

                                $level = $grade['level'] ?? 'Lainnya';

                                if (!isset($gradesByLevel[$level])) {
                                    $gradesByLevel[$level] = [];
                                }

                                $gradesByLevel[$level][] = $grade;
                            }

                            /*
                             * Urutan jenjang supaya tampilan konsisten.
                             */

                            $levelOrder = [
                                'Playgroup',
                                'Preschool',
                                'Elementary',
                                'Junior High',
                                'Senior High'
                            ];

                            /*
                             * Tampilkan jenjang yang sudah ditentukan
                             * terlebih dahulu.
                             */

                            foreach ($levelOrder as $level):

                                if (empty($gradesByLevel[$level])) {
                                    continue;
                                }

                            ?>

                                <optgroup
                                    label="<?= esc($level) ?>"
                                >

                                    <?php foreach ($gradesByLevel[$level] as $grade): ?>

                                        <option
                                            value="<?= esc($grade['id']) ?>"
                                        >

                                            <?= esc($grade['name']) ?>

                                        </option>

                                    <?php endforeach; ?>

                                </optgroup>

                            <?php

                            endforeach;


                            /*
                             * Tampilkan jenjang lain jika ada.
                             */

                            foreach ($gradesByLevel as $level => $levelGrades):

                                if (in_array($level, $levelOrder, true)) {
                                    continue;
                                }

                            ?>

                                <optgroup
                                    label="<?= esc($level) ?>"
                                >

                                    <?php foreach ($levelGrades as $grade): ?>

                                        <option
                                            value="<?= esc($grade['id']) ?>"
                                        >

                                            <?= esc($grade['name']) ?>

                                        </option>

                                    <?php endforeach; ?>

                                </optgroup>

                            <?php endforeach; ?>


                        </select>


                        <!-- =====================================
                             SEMUA KELAS
                        ====================================== -->

                        <div class="all-grades-wrapper">

                            <input
                                type="checkbox"
                                id="all_grades"
                                name="all_grades"
                                value="1"
                                checked
                            >

                            <label for="all_grades">

                                Export Semua Kelas

                            </label>

                        </div>


                        <div class="help-text">

                            Jika ingin memilih kelas tertentu,
                            hilangkan centang <strong>Export Semua Kelas</strong>,
                            lalu pilih satu atau beberapa kelas dengan <strong>Ctrl + Click</strong>.

                        </div>


                        <div
                            id="selectedGradeInfo"
                            class="selected-info"
                            style="display: none;"
                        ></div>


                    </div>


                </div>

            </div>



            <!-- =================================================
                 COLUMNS
            ================================================== -->

            <div class="section">


                <div class="section-title">

                    <span class="section-number">
                        2
                    </span>

                    Kolom yang Akan Diexport

                </div>



                <div class="column-toolbar">

                    <div class="column-description">

                        Centang kolom yang ingin dimasukkan ke Excel.

                    </div>


                    <div class="column-actions">

                        <button
                            type="button"
                            class="btn-small"
                            id="selectAll"
                        >
                            Pilih Semua
                        </button>


                        <button
                            type="button"
                            class="btn-small"
                            id="unselectAll"
                        >
                            Hapus Semua
                        </button>

                    </div>

                </div>



                <!-- =================================================
                     DATA IDENTITAS
                ================================================== -->

                <div class="column-group">

                    <div class="column-group-title">
                        Data Identitas
                    </div>


                    <div class="column-grid">


                        <label class="checkbox-item">

                            <input
                                type="checkbox"
                                name="columns[]"
                                value="nis"
                                checked
                            >

                            <span>
                                NIS
                            </span>

                        </label>


                        <label class="checkbox-item">

                            <input
                                type="checkbox"
                                name="columns[]"
                                value="nisn"
                                checked
                            >

                            <span>
                                NISN
                            </span>

                        </label>


                        <label class="checkbox-item">

                            <input
                                type="checkbox"
                                name="columns[]"
                                value="nik"
                            >

                            <span>
                                NIK
                            </span>

                        </label>


                        <label class="checkbox-item">

                            <input
                                type="checkbox"
                                name="columns[]"
                                value="no_kk"
                            >

                            <span>
                                No. KK
                            </span>

                        </label>


                        <label class="checkbox-item">

                            <input
                                type="checkbox"
                                name="columns[]"
                                value="name"
                                checked
                            >

                            <span>
                                Nama Siswa
                            </span>

                        </label>


                        <label class="checkbox-item">

                            <input
                                type="checkbox"
                                name="columns[]"
                                value="birth_place"
                            >

                            <span>
                                Tempat Lahir
                            </span>

                        </label>


                        <label class="checkbox-item">

                            <input
                                type="checkbox"
                                name="columns[]"
                                value="birth_date"
                            >

                            <span>
                                Tanggal Lahir
                            </span>

                        </label>


                        <label class="checkbox-item">

                            <input
                                type="checkbox"
                                name="columns[]"
                                value="gender"
                            >

                            <span>
                                Jenis Kelamin
                            </span>

                        </label>


                        <label class="checkbox-item">

                            <input
                                type="checkbox"
                                name="columns[]"
                                value="religion"
                            >

                            <span>
                                Agama
                            </span>

                        </label>


                    </div>

                </div>



                <!-- =================================================
                     DATA ORANG TUA
                ================================================== -->

                <div class="column-group">

                    <div class="column-group-title">
                        Data Orang Tua & Kontak
                    </div>


                    <div class="column-grid">


                        <label class="checkbox-item">

                            <input
                                type="checkbox"
                                name="columns[]"
                                value="guardian_1"
                            >

                            <span>
                                Orang Tua / Wali 1
                            </span>

                        </label>


                        <label class="checkbox-item">

                            <input
                                type="checkbox"
                                name="columns[]"
                                value="guardian_2"
                            >

                            <span>
                                Orang Tua / Wali 2
                            </span>

                        </label>


                        <label class="checkbox-item">

                            <input
                                type="checkbox"
                                name="columns[]"
                                value="parent_address"
                            >

                            <span>
                                Alamat
                            </span>

                        </label>


                        <label class="checkbox-item">

                            <input
                                type="checkbox"
                                name="columns[]"
                                value="email_1"
                            >

                            <span>
                                Email 1
                            </span>

                        </label>


                        <label class="checkbox-item">

                            <input
                                type="checkbox"
                                name="columns[]"
                                value="email_2"
                            >

                            <span>
                                Email 2
                            </span>

                        </label>


                        <label class="checkbox-item">

                            <input
                                type="checkbox"
                                name="columns[]"
                                value="email_3"
                            >

                            <span>
                                Email 3
                            </span>

                        </label>


                        <label class="checkbox-item">

                            <input
                                type="checkbox"
                                name="columns[]"
                                value="home_phone"
                            >

                            <span>
                                Telepon Rumah
                            </span>

                        </label>


                        <label class="checkbox-item">

                            <input
                                type="checkbox"
                                name="columns[]"
                                value="father_phone"
                            >

                            <span>
                                No. HP Ayah
                            </span>

                        </label>


                        <label class="checkbox-item">

                            <input
                                type="checkbox"
                                name="columns[]"
                                value="mother_phone"
                            >

                            <span>
                                No. HP Ibu
                            </span>

                        </label>


                    </div>

                </div>



                <!-- =================================================
                     DATA AKADEMIK
                ================================================== -->

                <div class="column-group">

                    <div class="column-group-title">
                        Data Akademik
                    </div>


                    <div class="column-grid">


                        <label class="checkbox-item">

                            <input
                                type="checkbox"
                                name="columns[]"
                                value="grade_name"
                                checked
                            >

                            <span>
                                Kelas
                            </span>

                        </label>


                        <label class="checkbox-item">

                            <input
                                type="checkbox"
                                name="columns[]"
                                value="grade_level"
                                checked
                            >

                            <span>
                                Jenjang
                            </span>

                        </label>


                        <label class="checkbox-item">

                            <input
                                type="checkbox"
                                name="columns[]"
                                value="academic_year"
                                checked
                            >

                            <span>
                                Tahun Pelajaran
                            </span>

                        </label>


                    </div>

                </div>


            </div>



            <!-- =================================================
                 ACTION
            ================================================== -->

            <div class="actions">


                <a
                    href="<?= base_url('students') ?>"
                    class="btn btn-secondary"
                >
                    ← Kembali
                </a>


                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    📊 Export ke Excel
                </button>


            </div>


        </form>

    </div>

</div>



<!-- =========================================================
     JAVASCRIPT
========================================================= -->

<script>

document.addEventListener('DOMContentLoaded', function () {


    /* =========================================================
       ELEMENT
    ========================================================= */

    const allGradesCheckbox =
        document.getElementById('all_grades');

    const gradeSelect =
        document.getElementById('grade_id');

    const selectedGradeInfo =
        document.getElementById('selectedGradeInfo');

    const selectAllButton =
        document.getElementById('selectAll');

    const unselectAllButton =
        document.getElementById('unselectAll');

    const exportForm =
        document.getElementById('exportForm');


    /* =========================================================
       UPDATE STATUS KELAS
    ========================================================= */

    function updateGradeState() {

        if (allGradesCheckbox.checked) {

            /*
             * Semua kelas dipilih.
             */

            gradeSelect.disabled = true;

            /*
             * Hapus pilihan kelas manual.
             */

            Array.from(gradeSelect.options).forEach(function (option) {

                option.selected = false;

            });

            selectedGradeInfo.style.display = 'none';

        } else {

            /*
             * Mode pilih kelas manual.
             */

            gradeSelect.disabled = false;

            updateSelectedGradeInfo();

        }

    }


    /* =========================================================
       INFO JUMLAH KELAS TERPILIH
    ========================================================= */

    function updateSelectedGradeInfo() {

        if (allGradesCheckbox.checked) {

            selectedGradeInfo.style.display = 'none';

            return;
        }


        const selectedOptions =
            Array.from(gradeSelect.selectedOptions);


        if (selectedOptions.length === 0) {

            selectedGradeInfo.textContent =
                'Belum ada kelas yang dipilih.';

            selectedGradeInfo.style.display = 'block';

            return;
        }


        selectedGradeInfo.textContent =
            selectedOptions.length +
            ' kelas dipilih.';


        selectedGradeInfo.style.display = 'block';

    }


    /* =========================================================
       CHECKBOX SEMUA KELAS
    ========================================================= */

    allGradesCheckbox.addEventListener(
        'change',
        function () {

            updateGradeState();

        }
    );


    /* =========================================================
       PERUBAHAN PILIHAN KELAS
    ========================================================= */

    gradeSelect.addEventListener(
        'change',
        function () {

            /*
             * Jika user memilih kelas manual,
             * otomatis matikan mode Semua Kelas.
             */

            if (gradeSelect.selectedOptions.length > 0) {

                allGradesCheckbox.checked = false;

            }

            updateGradeState();

        }
    );


    /* =========================================================
       PILIH SEMUA KOLOM
    ========================================================= */

    selectAllButton.addEventListener(
        'click',
        function () {

            const checkboxes =
                exportForm.querySelectorAll(
                    'input[name="columns[]"]'
                );


            checkboxes.forEach(function (checkbox) {

                checkbox.checked = true;

            });

        }
    );


    /* =========================================================
       HAPUS SEMUA KOLOM
    ========================================================= */

    unselectAllButton.addEventListener(
        'click',
        function () {

            const checkboxes =
                exportForm.querySelectorAll(
                    'input[name="columns[]"]'
                );


            checkboxes.forEach(function (checkbox) {

                checkbox.checked = false;

            });

        }
    );


    /* =========================================================
       VALIDASI SEBELUM EXPORT
    ========================================================= */

    exportForm.addEventListener(
        'submit',
        function (event) {


            /*
             * Pastikan tahun pelajaran dipilih.
             */

            const academicYear =
                document.getElementById(
                    'academic_year_id'
                );


            if (academicYear.value === '') {

                event.preventDefault();

                alert(
                    'Silakan pilih tahun pelajaran terlebih dahulu.'
                );

                academicYear.focus();

                return;

            }


            /*
             * Jika bukan semua kelas,
             * minimal satu kelas harus dipilih.
             */

            if (!allGradesCheckbox.checked) {

                const selectedGrades =
                    gradeSelect.selectedOptions.length;


                if (selectedGrades === 0) {

                    event.preventDefault();

                    alert(
                        'Silakan pilih minimal satu kelas atau centang "Export Semua Kelas".'
                    );

                    gradeSelect.focus();

                    return;

                }

            }


            /*
             * Pastikan minimal satu kolom dipilih.
             */

            const selectedColumns =
                exportForm.querySelectorAll(
                    'input[name="columns[]"]:checked'
                );


            if (selectedColumns.length === 0) {

                event.preventDefault();

                alert(
                    'Silakan pilih minimal satu kolom untuk diexport.'
                );

                return;

            }

        }
    );


    /* =========================================================
       INITIAL STATE
    ========================================================= */

    updateGradeState();

});

</script>


</body>

</html>