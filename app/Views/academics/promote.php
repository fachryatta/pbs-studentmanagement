<?= view('layouts/header') ?>

<?php
$promotionLevels = [];
$promotionGrades = [];
foreach (($students ?? []) as $studentRow) {
    $levelValue = trim((string) ($studentRow['grade_level'] ?? ''));
    $gradeIdValue = (int) ($studentRow['grade_id'] ?? 0);
    $gradeNameValue = trim((string) ($studentRow['grade_name'] ?? ''));

    if ($levelValue !== '') {
        $promotionLevels[$levelValue] = $levelValue;
    }
    if ($gradeIdValue > 0 && $gradeNameValue !== '') {
        $promotionGrades[$gradeIdValue] = $gradeNameValue;
    }
}
natcasesort($promotionLevels);
natcasesort($promotionGrades);
?>

<style>
    .academic-container{max-width:1550px;margin:0 auto;padding:38px 40px 50px}.page-header{display:flex;justify-content:space-between;gap:20px;align-items:flex-start;margin-bottom:25px}.page-title{margin:0 0 7px;font-size:34px;color:#172554}.page-description{margin:0;color:#64748b}.btn{display:inline-flex;align-items:center;justify-content:center;padding:11px 16px;border-radius:9px;text-decoration:none;font-weight:700;font-size:14px;border:1px solid transparent}.btn-primary{background:#2563eb;color:#fff}.btn-secondary{background:#fff;color:#334155;border-color:#cbd5e1}.control-card,.table-card{background:#fff;border:1px solid #e2e8f0;border-radius:14px}.control-card{padding:22px;margin-bottom:20px}.control-grid{display:grid;grid-template-columns:1fr 1fr;gap:15px}.field label{display:block;margin-bottom:7px;font-size:13px;font-weight:700;color:#334155}.select{width:100%;padding:11px 12px;border:1px solid #cbd5e1;border-radius:9px;background:#fff;font-size:14px}.info{margin-top:15px;padding:14px 16px;border-radius:10px;background:#eff6ff;border:1px solid #bfdbfe;color:#1e40af;line-height:1.55;font-size:14px}.table-head{padding:18px 20px;border-bottom:1px solid #e2e8f0;display:flex;justify-content:space-between;gap:15px;align-items:center;flex-wrap:wrap}.table-title{font-weight:800;color:#172554}.table-filters{display:flex;align-items:center;gap:10px;flex-wrap:wrap}.search{width:280px;max-width:100%;padding:10px 12px;border:1px solid #cbd5e1;border-radius:9px}.filter-select{min-width:155px;max-width:220px;padding:10px 12px;border:1px solid #cbd5e1;border-radius:9px;background:#fff;color:#0f172a}.table-wrapper{overflow-x:auto}.pagination-bar{display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;padding:14px 20px;border-top:1px solid #e2e8f0;color:#64748b;font-size:13px}.pagination-actions{display:flex;align-items:center;gap:8px}.page-btn{border:1px solid #cbd5e1;background:#fff;color:#334155;padding:7px 11px;border-radius:7px;font-weight:700;cursor:pointer}.page-btn:disabled{opacity:.45;cursor:not-allowed}table{width:100%;border-collapse:collapse;min-width:1100px}th{background:#f8fafc;color:#475569;font-size:12px;text-transform:uppercase;text-align:left;padding:13px 14px;border-bottom:1px solid #e2e8f0;white-space:nowrap}td{padding:12px 14px;border-bottom:1px solid #eef2f7;font-size:14px;vertical-align:middle}.grade-select,.status-select{width:100%;padding:9px 10px;border:1px solid #cbd5e1;border-radius:8px;background:#fff}.grade-select{min-width:180px}.status-select{min-width:125px}.action-bar{padding:18px 20px;background:#f8fafc;border-top:1px solid #e2e8f0;display:flex;justify-content:space-between;align-items:center;gap:15px}.action-note{color:#64748b;font-size:13px}.btn-process{border:0;background:#16a34a;color:#fff;padding:12px 18px;border-radius:9px;font-weight:800;cursor:pointer}.btn-process:hover{background:#15803d}.empty{text-align:center;padding:50px;color:#64748b}.status-active{background:#dcfce7;color:#166534}.status-out{background:#fee2e2;color:#991b1b}.status-graduate{background:#ede9fe;color:#6d28d9}@media(max-width:800px){.academic-container{padding:25px 20px 40px}.page-header{flex-direction:column}.control-grid{grid-template-columns:1fr}.table-head{flex-direction:column;align-items:flex-start}.table-filters{width:100%}.search,.filter-select{width:100%;max-width:none}.action-bar{flex-direction:column;align-items:stretch}}
</style>

<main class="academic-container">
    <div class="page-header">
        <div>
            <h1 class="page-title">Proses Tahun Pelajaran Baru</h1>
            <p class="page-description">Naikkan kelas siswa secara massal tanpa menghapus histori tahun sebelumnya.</p>
        </div>
        <a href="<?= base_url('/academics') ?>" class="btn btn-secondary">← Kembali</a>
    </div>

    <?php if (session()->getFlashdata('error')): ?><div class="alert alert-error"><?= esc(session()->getFlashdata('error')) ?></div><?php endif; ?>

    <div class="control-card">
        <div class="control-grid">
            <div class="field">
                <label for="source_year_id">Tahun Pelajaran Asal</label>
                <select class="select" id="source_year_id" onchange="changeSourceYear(this.value)">
                    <?php foreach ($academicYears as $year): ?>
                        <option value="<?= (int)$year['id'] ?>" <?= (int)$sourceYearId === (int)$year['id'] ? 'selected' : '' ?>>
                            <?= esc($year['year']) ?><?= (int)$year['is_active'] === 1 ? ' — Aktif' : '' ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="field">
                <label for="target_year_id">Tahun Pelajaran Tujuan</label>
                <select class="select" id="target_year_id" name="target_year_preview">
                    <?php if (!empty($targetYears)): ?>
                        <?php foreach ($targetYears as $year): ?>
                            <option value="<?= (int)$year['id'] ?>" <?= (int)$targetYearId === (int)$year['id'] ? 'selected' : '' ?>><?= esc($year['year']) ?></option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option value="">Belum ada tahun pelajaran berikutnya</option>
                    <?php endif; ?>
                </select>
            </div>
        </div>
        <div class="info">
            <strong>Catatan:</strong> kolom kelas sudah diisi otomatis satu tingkat di atas kelas sebelumnya. Jika siswa keluar atau lulus, ubah statusnya pada baris siswa. Histori tahun sebelumnya tetap aman.
            <?php if (empty($targetYears)): ?>
                <br><strong>Belum ada tahun tujuan.</strong> Tambahkan tahun pelajaran baru melalui menu Tahun Pelajaran terlebih dahulu.
            <?php endif; ?>
        </div>
    </div>

    <?php if (!empty($students) && !empty($targetYears)): ?>
        <form id="promotionForm" action="<?= base_url('/academics/process-promotion') ?>" method="post" onsubmit="return confirm('Yakin ingin memproses data siswa ke tahun pelajaran baru?');">
            <?= csrf_field() ?>
            <input type="hidden" name="source_year_id" value="<?= (int)$sourceYearId ?>">
            <input type="hidden" name="target_year_id" id="targetYearHidden" value="<?= (int)$targetYearId ?>">

            <div class="table-card">
                <div class="table-head">
                    <div class="table-title">Daftar Siswa — <?= esc($sourceYear['year']) ?></div>
                    <div class="table-filters">
                        <input class="search" type="search" id="studentSearch" placeholder="Cari nama, NIS, NISN...">
                        <select class="filter-select" id="promotionLevelFilter" aria-label="Filter jenjang">
                            <option value="">Semua Jenjang</option>
                            <?php foreach ($promotionLevels as $levelOption): ?>
                                <option value="<?= esc($levelOption) ?>"><?= esc($levelOption) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <select class="filter-select" id="promotionGradeFilter" aria-label="Filter kelas">
                            <option value="">Semua Kelas</option>
                            <?php foreach ($promotionGrades as $gradeIdOption => $gradeNameOption): ?>
                                <option value="<?= (int)$gradeIdOption ?>"><?= esc($gradeNameOption) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="table-wrapper">
                    <table id="promotionTable">
                        <thead><tr><th>No</th><th>NIS</th><th>NISN</th><th>Nama Siswa</th><th>Kelas Sekarang</th><th>Kelas Tahun Depan</th><th>Status</th></tr></thead>
                        <tbody>
                            <?php foreach ($students as $index => $student): ?>
                                <tr
                                    data-row="student"
                                    data-grade-id="<?= (int)($student['grade_id'] ?? 0) ?>"
                                    data-level="<?= esc($student['grade_level'] ?? '') ?>"
                                    data-search="<?= esc(implode(' ', [
                                        $student['student_name'] ?? '',
                                        $student['nis'] ?? '',
                                        $student['nisn'] ?? '',
                                        $student['gender'] ?? '',
                                        $student['grade_name'] ?? '',
                                        $student['grade_level'] ?? '',
                                    ])) ?>"
                                >
                                    <td><span class="row-number"><?= $index + 1 ?></span><input type="hidden" name="student_id[]" value="<?= (int)$student['student_id'] ?>"></td>
                                    <td><?= esc($student['nis'] ?? '-') ?></td>
                                    <td><?= esc($student['nisn'] ?? '-') ?></td>
                                    <td><strong><?= esc($student['student_name']) ?></strong></td>
                                    <td><?= esc($student['grade_name']) ?></td>
                                    <td>
                                        <select class="grade-select" name="grade_id[]" required>
                                            <?php foreach ($grades as $grade): ?>
                                                <option value="<?= (int)$grade['id'] ?>" <?= (int)$student['suggested_grade_id'] === (int)$grade['id'] ? 'selected' : '' ?>>
                                                    <?= esc($grade['name']) ?> — <?= esc($grade['level']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                    
<td>
    <?php if (($student['suggested_status'] ?? 'aktif') === 'lulus'): ?>

        <select class="status-select status-graduate" disabled>
            <option value="lulus" selected>Lulus</option>
        </select>

        <input type="hidden" name="status[]" value="lulus">

    <?php else: ?>

        <select
            class="status-select"
            name="status[]"
            onchange="colorStatus(this)"
        >
            <option value="aktif" selected>Aktif</option>
            <option value="keluar">Keluar</option>
            <option value="lulus">Lulus</option>
        </select>

    <?php endif; ?>
</td>

                                </tr>
                            <?php endforeach; ?>
                            <tr id="promotionNoResults" style="display:none;">
                                <td colspan="7" style="text-align:center;padding:30px;color:#64748b;">Tidak ada siswa yang cocok dengan pencarian atau filter.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="pagination-bar" id="promotionPagination">
                    <span id="promotionResultCount">Memuat data...</span>
                    <div class="pagination-actions">
                        <button type="button" class="page-btn" id="promotionPrev">← Sebelumnya</button>
                        <span id="promotionPageInfo">Halaman 1</span>
                        <button type="button" class="page-btn" id="promotionNext">Berikutnya →</button>
                    </div>
                </div>
                <div class="action-bar">
                    <div class="action-note">Total <?= count($students) ?> siswa akan diproses. Filter hanya mengatur tampilan; semua siswa tetap ikut diproses saat disimpan. Tahun tujuan akan menjadi tahun aktif setelah proses berhasil.</div>
                    <button class="btn-process" type="submit">✓ Simpan & Aktifkan Tahun Tujuan</button>
                </div>
            </div>
        </form>
    <?php else: ?>
        <div class="table-card"><div class="empty">
            <h3>Belum dapat memproses</h3>
            <p><?= empty($targetYears) ? 'Tambahkan tahun pelajaran berikutnya terlebih dahulu.' : 'Belum ada siswa aktif pada tahun pelajaran asal.' ?></p>
            <?php if (empty($targetYears)): ?><a href="<?= base_url('/academics/years') ?>" class="btn btn-primary" style="margin-top:15px;">📅 Kelola Tahun Pelajaran</a><?php endif; ?>
        </div></div>
    <?php endif; ?>
</main>

<script>
function changeSourceYear(id) {
    window.location.href = '<?= base_url('/academics/promote') ?>?source_year_id=' + encodeURIComponent(id);
}
document.getElementById('target_year_id')?.addEventListener('change', function(){ document.getElementById('targetYearHidden').value = this.value; });

(function () {
    const table = document.getElementById('promotionTable');
    if (!table) return;

    const rows = Array.from(table.querySelectorAll('tbody tr[data-row="student"]'));
    const searchInput = document.getElementById('studentSearch');
    const levelFilter = document.getElementById('promotionLevelFilter');
    const gradeFilter = document.getElementById('promotionGradeFilter');
    const noResults = document.getElementById('promotionNoResults');
    const resultCount = document.getElementById('promotionResultCount');
    const pageInfo = document.getElementById('promotionPageInfo');
    const prevButton = document.getElementById('promotionPrev');
    const nextButton = document.getElementById('promotionNext');
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

function colorStatus(select){ select.classList.remove('status-active','status-out','status-graduate'); if(select.value==='aktif') select.classList.add('status-active'); if(select.value==='keluar') select.classList.add('status-out'); if(select.value==='lulus') select.classList.add('status-graduate'); }
document.querySelectorAll('.status-select').forEach(colorStatus);
</script>

<?= view('layouts/footer') ?>
