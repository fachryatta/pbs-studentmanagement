<?= view('layouts/header') ?>

<style>
    .academic-container{max-width:1200px;margin:0 auto;padding:38px 40px 50px}.page-header{display:flex;justify-content:space-between;gap:20px;align-items:flex-start;margin-bottom:25px}.page-title{margin:0 0 7px;font-size:32px;color:#172554}.page-description{margin:0;color:#64748b}.btn{display:inline-flex;padding:11px 16px;border-radius:9px;text-decoration:none;font-weight:700;font-size:14px;border:1px solid #cbd5e1;background:#fff;color:#334155}.student-card,.table-card{background:#fff;border:1px solid #e2e8f0;border-radius:14px}.student-card{padding:20px;margin-bottom:20px}.student-name{font-size:21px;font-weight:800;color:#172554;margin-bottom:5px}.student-meta{color:#64748b;font-size:14px}.table-card{overflow:hidden}.table-wrapper{overflow-x:auto}table{width:100%;border-collapse:collapse}th{background:#f8fafc;color:#475569;font-size:12px;text-transform:uppercase;text-align:left;padding:13px 14px;border-bottom:1px solid #e2e8f0}td{padding:14px;border-bottom:1px solid #eef2f7;font-size:14px}.badge{display:inline-flex;padding:5px 10px;border-radius:999px;font-size:12px;font-weight:800}.grade{background:#dbeafe;color:#1d4ed8}.active{background:#dcfce7;color:#166534}.out{background:#fee2e2;color:#991b1b}.graduate{background:#ede9fe;color:#6d28d9}.empty{text-align:center;padding:45px;color:#64748b}@media(max-width:700px){.academic-container{padding:25px 20px}.page-header{flex-direction:column}}
</style>

<main class="academic-container">
    <div class="page-header"><div><h1 class="page-title">Riwayat Akademik Siswa</h1><p class="page-description">Perjalanan kelas dan status siswa dari tahun ke tahun.</p></div><a class="btn" href="<?= base_url('/academics') ?>">← Kembali</a></div>
    <div class="student-card"><div class="student-name"><?= esc($student['name']) ?></div><div class="student-meta">NIS: <?= esc($student['nis'] ?? '-') ?> &nbsp;•&nbsp; NISN: <?= esc($student['nisn'] ?? '-') ?></div></div>
    <div class="table-card"><div class="table-wrapper"><table><thead><tr><th>No</th><th>Tahun Pelajaran</th><th>Kelas</th><th>Jenjang</th><th>Status</th></tr></thead><tbody>
        <?php if (!empty($history)): ?>
            <?php foreach ($history as $index => $row): ?><tr><td><?= $index + 1 ?></td><td><strong><?= esc($row['academic_year']) ?></strong></td><td><span class="badge grade"><?= esc($row['grade_name']) ?></span></td><td><?= esc($row['grade_level'] ?? '-') ?></td><td><?php if($row['status']==='aktif'): ?><span class="badge active">Aktif</span><?php elseif($row['status']==='keluar'): ?><span class="badge out">Keluar</span><?php elseif($row['status']==='lulus'): ?><span class="badge graduate">Lulus</span><?php else: ?><span class="badge"><?= esc($row['status']) ?></span><?php endif; ?></td></tr><?php endforeach; ?>
        <?php else: ?><tr><td colspan="5" class="empty">Belum ada histori akademik.</td></tr><?php endif; ?>
    </tbody></table></div></div>
</main>

<?= view('layouts/footer') ?>
