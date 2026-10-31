<?php

namespace Database\Seeders;

use App\Models\KategoriProduk;
use App\Models\Produk;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class AgrilinkSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Buat Kategori Contoh
        $kategoriList = [
            ['nama_kategori' => 'Beras & Biji-bijian', 'deskripsi' => 'Hasil panen padi dan biji-bijian berkualitas tinggi.'],
            ['nama_kategori' => 'Sayuran Segar', 'deskripsi' => 'Sayuran hijau dan umbi-umbian segar langsung dari kebun.'],
            ['nama_kategori' => 'Buah-buahan', 'deskripsi' => 'Buah lokal segar khas daerah Indramayu dan sekitarnya.'],
            ['nama_kategori' => 'Rempah & Bumbu', 'deskripsi' => 'Bumbu dapur dan rempah-rempah alami.'],
        ];

        $kategoriIds = [];
        foreach ($kategoriList as $kat) {
            $createdKat = KategoriProduk::create($kat);
            $kategoriIds[] = $createdKat->id;
        }

        // Daftar nama produk khas pertanian Indramayu
        $sampleProduk = [
            'Beras Pandan Wangi 5kg', 'Beras Merah Organik', 'Mangga Gedong Gincu Indramayu',
            'Bawang Merah Lokal', 'Cabai Merah Keriting', 'Tomat Segar 1kg',
            'Bawang Putih Honan', 'Jagung Manis Segar', 'Kacang Tanah Kupas',
            'Ubi Jalar Cilembu', 'Kunyit Segar', 'Jahe Gajah 500g'
        ];

        $kecamatanIndramayu = [
            'Jatibarang', 'Kertasemaya', 'Sliyeg', 'Karangampel',
            'Indramayu', 'Kandanghaur', 'Losarang', 'Widasari'
        ];

        // Buat minimal 12 data dummy produk
        foreach ($sampleProduk as $nama) {
            Produk::create([
                'kategori_id'   => $faker->randomElement($kategoriIds),
                'nama_produk'   => $nama,
                'harga'         => $faker->numberBetween(10000, 120000),
                'stok'          => $faker->numberBetween(10, 200),
                'deskripsi'     => $faker->paragraph(2),
                'lokasi_petani' => 'Kec. ' . $faker->randomElement($kecamatanIndramayu) . ', Indramayu',
            ]);
        }
    }
}