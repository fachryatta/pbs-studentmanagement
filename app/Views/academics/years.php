<?= view('layouts/header') ?>

<style>
    .academic-container{max-width:1200px;margin:0 auto;padding:38px 40px 50px}.page-header{display:flex;justify-content:space-between;align-items:flex-start;gap:20px;margin-bottom:25px}.page-title{margin:0 0 7px;font-size:34px;color:#172554}.page-description{margin:0;color:#64748b}.btn{display:inline-flex;align-items:center;justify-content:center;padding:11px 16px;border-radius:9px;text-decoration:none;font-weight:700;font-size:14px;border:1px solid transparent}.btn-primary{background:#2563eb;color:#fff}.btn-secondary{background:#fff;color:#334155;border-color:#cbd5e1}.card{background:#fff;border:1px solid #e2e8f0;border-radius:14px;margin-bottom:20px}.form-card{padding:22px}.form-card h3{margin:0 0 6px;color:#172554}.muted{color:#64748b;font-size:14px;margin-bottom:16px}.form-row{display:flex;gap:12px;align-items:end;max-width:620px}.field{flex:1}.field label{display:block;margin-bottom:7px;font-size:13px;font-weight:700;color:#334155}.input{width:100%;padding:11px 12px;border:1px solid #cbd5e1;border-radius:9px;font-size:14px}.table-wrapper{overflow-x:auto}.table-card{overflow:hidden}.table-title{padding:18px 20px;font-weight:800;color:#172554;border-bottom:1px solid #e2e8f0}table{width:100%;border-collapse:collapse}th{background:#f8fafc;color:#475569;font-size:12px;text-transform:uppercase;text-align:left;padding:13px 14px;border-bottom:1px solid #e2e8f0}td{padding:14px;border-bottom:1px solid #eef2f7;font-size:14px}.badge{display:inline-flex;padding:5px 10px;border-radius:999px;font-size:12px;font-weight:800}.badge-success{background:#dcfce7;color:#166534}.badge-muted{background:#f1f5f9;color:#64748b}.action{display:flex;gap:8px;flex-wrap:wrap}.activate{border:1px solid #bbf7d0;background:#f0fdf4;color:#166534;padding:7px 10px;border-radius:7px;font-size:12px;font-weight:800;cursor:pointer}.empty{text-align:center;padding:45px;color:#64748b}@media(max-width:700px){.academic-container{padding:25px 20px}.page-header{flex-direction:column}.form-row{flex-direction:column;align-items:stretch;max-width:none}}

    .delete-year {
    border: 1px solid #fecaca;
    background: #fef2f2;
    color: #b91c1c;
    padding: 7px 10px;
    border-radius: 7px;
    font-size: 12px;
    font-weight: 800;
    cursor: pointer;
}

.delete-year:hover {
    background: #fee2e2;
}
</style>

<main class="academic-container">
    <div class="page-header">
        <div><h1 class="page-title">Tahun Pelajaran</h1><p class="page-description">Kelola daftar tahun pelajaran dan tentukan tahun yang sedang aktif.</p></div>
        <a href="<?= base_url('/academics') ?>" class="btn btn-secondary">← Kembali</a>
    </div>

    <?php if (session()->getFlashdata('success')): ?><div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div><?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?><div class="alert alert-error"><?= esc(session()->getFlashdata('error')) ?></div><?php endif; ?>

    <div class="card form-card">
        <h3>Tambah Tahun Pelajaran</h3>
        <div class="muted">Gunakan format YYYY/YYYY, misalnya 2027/2028.</div>
        <form method="post" action="<?= base_url('/academics/years/store') ?>">
            <?= csrf_field() ?>
            <div class="form-row">
                <div class="field"><label for="year">Tahun Pelajaran</label><input class="input" type="text" id="year" name="year" value="<?= old('year') ?>" placeholder="2027/2028" maxlength="9" required></div>
                <button type="submit" class="btn btn-primary">+ Tambah</button>
            </div>
        </form>
    </div>

    <div class="card table-card">
        <div class="table-title">Daftar Tahun Pelajaran</div>
        <?php if (!empty($academicYears)): ?>
            <div class="table-wrapper"><table><thead><tr><th>No</th><th>Tahun Pelajaran</th><th>Status</th><th>Aksi</th></tr></thead><tbody>
                <?php foreach ($academicYears as $index => $year): ?>
                    <tr>
                        <td><?= $index + 1 ?></td><td><strong><?= esc($year['year']) ?></strong></td>
                        <td><?php if ((int)$year['is_active'] === 1): ?><span class="badge badge-success">Aktif</span><?php else: ?><span class="badge badge-muted">Tidak Aktif</span><?php endif; ?></td>
                        
<td>
    <?php if ((int) $year['is_active'] === 1): ?>

        <span style="color:#64748b;font-size:12px;">
            Sedang digunakan
        </span>

    <?php else: ?>

        <div class="action">
            <form
                method="post"
                action="<?= base_url('/academics/years/activate/' . $year['id']) ?>"
                onsubmit="return confirm('Yakin ingin menjadikan tahun pelajaran <?= esc($year['year']) ?> sebagai tahun aktif?');"
            >
                <?= csrf_field() ?>

                <button type="submit" class="activate">
                    Jadikan Aktif
                </button>
            </form>

            <form
                method="post"
                action="<?= base_url('/academics/years/delete/' . $year['id']) ?>"
                onsubmit="return confirm('PERINGATAN: Hapus tahun pelajaran <?= esc($year['year']) ?> beserta seluruh histori akademik pada tahun tersebut? Data yang dihapus tidak dapat dipulihkan.');"
            >
                <?= csrf_field() ?>

                <button type="submit" class="delete-year">
                    Hapus
                </button>
            </form>
        </div>

    <?php endif; ?>
</td>

                    </tr>
                <?php endforeach; ?>
            </tbody></table></div>
        <?php else: ?><div class="empty">Belum ada tahun pelajaran.</div><?php endif; ?>
    </div>
</main>

<?= view('layouts/footer') ?>
