<div class="content-box">
    <h3 class="centered"><strong>M E M U T U S K A N :</strong></h3>
    <table class="decision-table">
        <tr><td class="label">Menetapkan</td><td class="colon">:</td><td></td></tr>
        <tr><td class="label">KESATU</td><td class="colon">:</td><td>Mengangkat dosen sebagai Pengampu Mata Kuliah / Pengajar <?= $form_data['perihal3'] ?? '' ?>;</td></tr>
        <tr><td class="label">KEDUA</td><td class="colon">:</td><td>Biaya ditanggung oleh anggaran UNISSULA;</td></tr>
        <tr><td class="label">KETIGA</td><td class="colon">:</td><td>Berlaku mulai <?= $form_data['perihal5'] ?? '' ?> M, dengan koreksi jika ada kekeliruan.</td></tr>
    </table>

    <div class="signature">
        <p>Ditetapkan di Semarang,<br>Pada tanggal : <u><?= $form_data['tglhjr'] ?? '' ?></u><br><?= $form_data['tglsr'] ?? '' ?><br><br>
        Rektor,<br><br><br>
        Prof. Dr. H. Gunarto., S.H., M.H.<br>
        NIK. 210 389 016</p>
    </div>

    <h4><strong><u>Salinan Keputusan Disampaikan Kepada:</u></strong></h4>
    <ol>
        <li>Wakil Rektor I, II & III UNISSULA</li>
        <li><?= $form_data['dekan_fakultas'] ?? '' ?> UNISSULA</li>
        <li><?= $form_data['ka_prodi'] ?? '' ?> UNISSULA</li>
        <li>Ka. Biro Akademik</li>
        <li>Ka. Biro Keuangan</li>
        <li>Ka. Biro SDI</li>
        <li>Yang bersangkutan</li>
    </ol>
</div>
