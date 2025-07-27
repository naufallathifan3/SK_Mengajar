<div class="lamp">
    <div><strong>LAMPIRAN</strong></div>
    <div>KEPUTUSAN REKTOR UNISSULA NOMOR <?= $form_data['nomor_agenda'] ?? '' ?></div>
    <div class="section"><strong>TENTANG</strong></div>
    <div><?= $form_data['perihal6'] ?? '' ?></div>
</div>

<div class="judul-daftar">
    DAFTAR DOSEN PENGAMPU MATA KULIAH / PENGAJAR MODUL<br>
    PROGRAM STUDI <?= strtoupper($form_data['nama_prodi_display'] ?? '') ?><br>
    SEMESTER <?= strtoupper($form_data['semester'] ?? '') ?> TAHUN AKADEMIK <?= $form_data['tahun_akademik'] ?? '' ?>
</div>

<table class="tabel-dosen">
    <thead>
        <tr>
            <th>No</th>
            <th >Nama Dosen</th>
            <th>Nama Mata Kuliah</th>
            <th>SKS</th>
            <th>Total SKS</th>
        </tr>
    </thead>
    <tbody>
    <?php $no = 1; foreach ($data_final_dosen as $data): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($data['nama_dosen']) ?></td>
            <?php if (!empty($data['matakuliah'])): ?>
                <td><?= implode('<br>', array_map('htmlspecialchars', array_column($data['matakuliah'], 'nama_mk'))) ?></td>
                <td><?= implode('<br>', array_map('htmlspecialchars', array_column($data['matakuliah'], 'sks'))) ?></td>
                <td><?= array_sum(array_column($data['matakuliah'], 'sks')) ?></td>
            <?php else: ?>
                <td colspan="3" class="center-align"><i>Tidak ada data</i></td>
            <?php endif; ?>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<div class="signature">
    <p>Ditetapkan di Semarang,<br>
    Tanggal: <u><?= $form_data['tglhjr'] ?? '' ?></u><br><?= $form_data['tglsr'] ?? '' ?><br><br>
    Rektor,<br><br><br>
    Prof. Dr. H. Gunarto., S.H., M.H.<br>
    NIK. 210 389 016</p>
</div>
