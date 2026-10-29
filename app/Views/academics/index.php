<?= view('layouts/header') ?>

<?php
$academicLevels = [];
$academicGrades = [];
foreach (($academics ?? []) as $academicRow) {
    $levelValue = trim((string) ($academicRow['grade_level'] ?? ''));
    $gradeIdValue = (int) ($academicRow['grade_id'] ?? 0);
    $gradeNameValue = trim((string) ($academicRow['grade_name'] ?? ''));

    if ($levelValue !== '') {
        $academicLevels[$levelValue] = $levelValue;
    }
    if ($gradeIdValue > 0 && $gradeNameValue !== '') {
        $academicGrades[$gradeIdValue] = $gradeNameValue;
    }
}
natcasesort($academicLevels);
natcasesort($academicGrades);
?>

<style>
    .academic-container { max-width: 1500px; margin: 0 auto; padding: 38px 40px 50px; }
    .page-header { display:flex; justify-content:space-between; align-items:flex-start; gap:20px; margin-bottom:26px; }
    .page-title { margin:0 0 7px; font-size:34px; color:#172554; }
    .page-description { margin:0; color:#64748b; font-size:15px; }
    .header-actions { display:flex; gap:10px; flex-wrap:wrap; }
    .btn { display:inline-flex; align-items:center; justify-content:center; gap:7px; padding:11px 16px; border-radius:9px; text-decoration:none; font-weight:700; font-size:14px; border:1px solid transparent; }
    .btn-primary { background:#2563eb; color:#fff; }
    .btn-primary:hover { background:#1d4ed8; }
    .btn-secondary { background:#fff; color:#334155; border-color:#cbd5e1; }
    .btn-secondary:hover { background:#f8fafc; }
    .filter-card, .summary-card, .table-card { background:#fff; border:1px solid #e2e8f0; border-radius:14px; }
    .filter-card { padding:20px; margin-bottom:20px; }
    .filter-form { display:flex; align-items:end; gap:12px; flex-wrap:wrap; }
    .field { min-width:260px; flex:1; }
    .field label { display:block; margin-bottom:7px; font-size:13px; font-weight:700; color:#334155; }
    .select { width:100%; padding:11px 12px; border:1px solid #cbd5e1; border-radius:9px; background:#fff; color:#0f172a; font-size:14px; }
    .summary-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:16px; margin-bottom:20px; }
    .summary-card { padding:18px 20px; }
    .summary-label { color:#64748b; font-size:13px; margin-bottom:7px; }
    .summary-value { color:#172554; font-size:27px; font-weight:800; }
    .summary-value.green { color:#15803d; }
    .summary-value.red { color:#b91c1c; }
    .year-banner { padding:18px 20px; margin-bottom:20px; background:#eff6ff; border:1px solid #bfdbfe; border-radius:12px; color:#1e40af; }
    .year-banner strong { color:#172554; }
    .table-card { overflow:hidden; }
    .table-top { padding:18px 20px; border-bottom:1px solid #e2e8f0; display:flex; justify-content:space-between; gap:15px; align-items:center; flex-wrap:wrap; }
    .table-title { font-size:17px; font-weight:800; color:#172554; }
    .table-filters { display:flex; align-items:center; gap:10px; flex-wrap:wrap; }
    .search { width:280px; max-width:100%; padding:10px 12px; border:1px solid #cbd5e1; border-radius:9px; }
    .filter-select { min-width:155px; max-width:220px; padding:10px 12px; border:1px solid #cbd5e1; border-radius:9px; background:#fff; color:#0f172a; }
    .pagination-bar { display:flex; align-items:center; justify-content:space-between; gap:12px; flex-wrap:wrap; padding:14px 20px; border-top:1px solid #e2e8f0; color:#64748b; font-size:13px; }
    .pagination-actions { display:flex; align-items:center; gap:8px; }
    .page-btn { border:1px solid #cbd5e1; background:#fff; color:#334155; padding:7px 11px; border-radius:7px; font-weight:700; cursor:pointer; }
    .page-btn:disabled { opacity:.45; cursor:not-allowed; }
    .table-wrapper { overflow-x:auto; }
    table { width:100%; border-collapse:collapse; min-width:920px; }
    th { background:#f8fafc; color:#475569; font-size:12px; text-transform:uppercase; letter-spacing:.03em; text-align:left; padding:13px 14px; border-bottom:1px solid #e2e8f0; white-space:nowrap; }
    td { padding:13px 14px; border-bottom:1px solid #eef2f7; vertical-align:middle; font-size:14px; }
    tr:last-child td { border-bottom:0; }
    .badge { display:inline-flex; align-items:center; padding:5px 10px; border-radius:999px; font-size:12px; font-weight:800; }
    .badge-grade { background:#dbeafe; color:#1d4ed8; }
    .badge-active { background:#dcfce7; color:#166534; }
    .badge-out { background:#fee2e2; color:#991b1b; }
    .badge-graduated { background:#ede9fe; color:#6d28d9; }
    .btn-small { display:inline-flex; padding:7px 10px; border-radius:7px; background:#f8fafc; border:1px solid #cbd5e1; color:#334155; text-decoration:none; font-size:12px; font-weight:700; }
    .empty-state { text-align:center; padding:55px 25px; color:#64748b; }
    .empty-state h3 { color:#334155; margin:0 0 7px; }
    @media (max-width: 800px) { .academic-container{padding:25px 20px 40px}.page-header{flex-direction:column}.summary-grid{grid-template-columns:1fr}.table-top{align-items:flex-start;flex-direction:column}.table-filters{width:100%}.search,.filter-select{width:100%;max-width:none}.field{min-width:100%} }
</style>

<main class="academic-container">
    <div class="page-header">
        <div>
            <h1 class="page-title">Data Akademik</h1>
            <p class="page-description">Histori kelas dan status setiap siswa berdasarkan tahun pelajaran.</p>
        </div>
        <div class="header-actions">
            <?php if (session()->get('role') === 'admin'): ?>
                <a href="<?= base_url('/academics/promote') ?>" class="btn btn-primary">⚙️ Proses Tahun Baru</a>
                <a href="<?= base_url('/academics/years') ?>" class="btn btn-secondary">📅 Tahun Pelajaran</a>
            <?php endif; ?>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-error"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <?php if ($selectedYear): ?>
        <div class="year-banner">
            Menampilkan data akademik untuk <strong><?= esc($selectedYear['year']) ?></strong>.
            <?php if ($activeYear && (int)$activeYear['id'] === (int)$selectedYear['id']): ?>
                Tahun ini sedang <strong>aktif</strong>.
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div class="filter-card">
        <form class="filter-form" method="get" action="<?= base_url('/academics') ?>">
            <div class="field">
                <label for="academic_year_id">Pilih Tahun Pelajaran</label>
                <select class="select" id="academic_year_id" name="academic_year_id" onchange="this.form.submit()">
                    <?php foreach ($academicYears as $year): ?>
                        <option value="<?= (int)$year['id'] ?>" <?= (int)$selectedYearId === (int)$year['id'] ? 'selected' : '' ?>>
                            <?= esc($year['year']) ?><?= (int)$year['is_active'] === 1 ? ' — Aktif' : '' ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <noscript><button class="btn btn-secondary" type="submit">Tampilkan</button></noscript>
        </form>
    </div>

    <div class="summary-grid">
        <div class="summary-card"><div class="summary-label">Total Riwayat Siswa</div><div class="summary-value"><?= count($academics) ?></div></div>
        <div class="summary-card"><div class="summary-label">Siswa Aktif</div><div class="summary-value green"><?= $activeCount ?></div></div>
        <div class="summary-card"><div class="summary-label">Keluar / Lulus</div><div class="summary-value red"><?= $outCount ?></div></div>
    </div>

    <div class="table-card">
        <div class="table-top">
            <div class="table-title">Daftar Akademik Siswa</div>
            <div class="table-filters">
                <input class="search" type="search" id="academicSearch" placeholder="Cari nama, NIS, NISN, status...">
                <select class="filter-select" id="academicLevelFilter" aria-label="Filter jenjang">
                    <option value="">Semua Jenjang</option>
                    <?php foreach ($academicLevels as $levelOption): ?>
                        <option value="<?= esc($levelOption) ?>"><?= esc($levelOption) ?></option>
                    <?php endforeach; ?>
                </select>
                <select class="filter-select" id="academicGradeFilter" aria-label="Filter kelas">
                    <option value="">Semua Kelas</option>
                    <?php foreach ($academicGrades as $gradeIdOption => $gradeNameOption): ?>
                        <option value="<?= (int)$gradeIdOption ?>"><?= esc($gradeNameOption) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <?php if (!empty($academics)): ?>
            <div class="table-wrapper">
                <table id="academicTable">
                    <thead>
                        <tr>
                            <th>No</th><th>NIS</th><th>NISN</th><th>Nama Siswa</th><th>Kelas</th><th>Jenjang</th><th>Status</th><th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($academics as $index => $academic): ?>
                            <tr
                                data-row="academic"
                                data-grade-id="<?= (int)($academic['grade_id'] ?? 0) ?>"
                                data-level="<?= esc($academic['grade_level'] ?? '') ?>"
                                data-search="<?= esc(implode(' ', [
                                    $academic['student_name'] ?? '',
                                    $academic['nis'] ?? '',
                                    $academic['nisn'] ?? '',
                                    $academic['gender'] ?? '',
                                    $academic['grade_name'] ?? '',
                                    $academic['grade_level'] ?? '',
                                    $academic['status'] ?? '',
                                ])) ?>"
                            >
                                <td class="row-number"><?= $index + 1 ?></td>
                                <td><?= esc($academic['nis'] ?? '-') ?></td>
                                <td><?= esc($academic['nisn'] ?? '-') ?></td>
                                <td><strong><?= esc($academic['student_name']) ?></strong></td>
                                <td><span class="badge badge-grade"><?= esc($academic['grade_name']) ?></span></td>
                                <td><?= esc($academic['grade_level'] ?? '-') ?></td>
                                <td>
                                    <?php if (($academic['status'] ?? '') === 'aktif'): ?>
                                        <span class="badge badge-active">Aktif</span>
                                    <?php elseif (($academic['status'] ?? '') === 'keluar'): ?>
                                        <span class="badge badge-out">Keluar</span>
                                    <?php elseif (($academic['status'] ?? '') === 'lulus'): ?>
                                        <span class="badge badge-graduated">Lulus</span>
                                    <?php else: ?>
                                        <span class="badge"><?= esc($academic['status'] ?? '-') ?></span>
                                    <?php endif; ?>
                                </td>
                                <td><a class="btn-small" href="<?= base_url('/academics/student/' . $academic['student_id']) ?>">Riwayat</a></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr id="academicNoResults" style="display:none;">
                            <td colspan="8" class="empty-state">Tidak ada siswa yang cocok dengan pencarian atau filter.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="pagination-bar" id="academicPagination">
                <span id="academicResultCount">Memuat data...</span>
                <div class="pagination-actions">
                    <button type="button" class="page-btn" id="academicPrev">← Sebelumnya</button>
                    <span id="academicPageInfo">Halaman 1</span>
                    <button type="button" class="page-btn" id="academicNext">Berikutnya →</button>
                </div>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <h3>Belum ada data akademik</h3>
                <p>Belum ada histori siswa pada tahun pelajaran yang dipilih.</p>
                <?php if (session()->get('role') === 'admin'): ?>
                    <a href="<?= base_url('/academics/promote') ?>" class="btn btn-primary" style="margin-top:15px;">Mulai Proses Tahun Baru</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</main>

<script>
(function () {
    const table = document.getElementById('academicTable');
    if (!table) return;

    const rows = Array.from(table.querySelectorAll('tbody tr[data-row="academic"]'));
    const searchInput = document.getElementById('academicSearch');
    const levelFilter = document.getElementById('academicLevelFilter');
    const gradeFilter = document.getElementById('academicGradeFilter');
    const noResults = document.getElementById('academicNoResults');
    const resultCount = document.getElementById('academicResultCount');
    const pageInfo = document.getElementById('academicPageInfo');
    const prevButton = document.getElementById('academicPrev');
    const nextButton = document.getElementById('academicNext');
    const pageSize = 10;
    let currentPage = 1;

    function render(resetPage = false) {
        if (resetPage) currentPage = 1;

        const keyword = (searchInput?.value || '').toLowerCase().trim();
        const selectedLevel = (levelFilter?.value || '').toLowerCase();
        const selectedGrade = gradeFilter?.value || '';

        const filteredRows = rows.filter(row => {
            const matchesSearch = (row.dataset.search || '').toLowerCase().includes(keyword);
            const matchesLevel = !selectedLevel || (row.dataset.level || '').toLowerCase() === selectedLevel;
            const matchesGrade = !selectedGrade || row.dataset.gradeId === selectedGrade;
            return matchesSearch && matchesLevel && matchesGrade;
        });

        const totalPages = Math.max(1, Math.ceil(filteredRows.length / pageSize));
        if (currentPage > totalPages) currentPage = totalPages;
        const startIndex = (currentPage - 1) * pageSize;
        const endIndex = Math.min(startIndex + pageSize, filteredRows.length);
        const visibleRows = new Set(filteredRows.slice(startIndex, endIndex));

        rows.forEach(row => { row.style.display = visibleRows.has(row) ? '' : 'none'; });
        filteredRows.slice(startIndex, endIndex).forEach((row, index) => {
            const numberCell = row.querySelector('.row-number');
            if (numberCell) numberCell.textContent = String(startIndex + index + 1);
        });

        if (noResults) noResults.style.display = filteredRows.length ? 'none' : '';
        if (resultCount) {
            resultCount.textContent = filteredRows.length
                ? `Menampilkan ${startIndex + 1}–${endIndex} dari ${filteredRows.length} siswa`
                : 'Menampilkan 0 dari 0 siswa';
        }
        if (pageInfo) pageInfo.textContent = `Halaman ${currentPage} dari ${totalPages}`;
        if (prevButton) prevButton.disabled = currentPage <= 1;
        if (nextButton) nextButton.disabled = currentPage >= totalPages;
    }

    searchInput?.addEventListener('input', () => render(true));
    levelFilter?.addEventListener('change', () => render(true));
    gradeFilter?.addEventListener('change', () => render(true));
    prevButton?.addEventListener('click', () => { currentPage--; render(); });
    nextButton?.addEventListener('click', () => { currentPage++; render(); });
    render();
})();
</script>

<?= view('layouts/footer') ?>
