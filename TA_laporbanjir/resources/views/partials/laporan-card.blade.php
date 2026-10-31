<div class="card">
    <h3>Lokasi Kejadian: {{ $laporan->lokasi }}</h3>
    <p><strong>Nama Pelapor:</strong> {{ $laporan->nama_pelapor }}</p>
    <p><strong>Tinggi Genangan Air:</strong> {{ $laporan->tinggi_genangan }} cm</p>
    <p><strong>Tanggal Kejadian:</strong> {{ \Carbon\Carbon::parse($laporan->tanggal_kejadian)->format('d-m-Y') }}</p>
    <p>
        <strong>Status Genangan:</strong>
        @if($laporan->tinggi_genangan < 30)
            <span class="badge bg-waspada">Waspada</span>
        @elseif($laporan->tinggi_genangan <= 70)
            <span class="badge bg-siaga">Siaga</span>
        @else
            <span class="badge bg-awas">Awas</span>
        @endif
    </p>
</div>
