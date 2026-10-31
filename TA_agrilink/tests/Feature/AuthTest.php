<?php

namespace Tests\Feature;

use App\Models\KategoriProduk;
use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_halaman_wajib_login_mengarahkan_tamu_ke_login(): void
    {
        $this->get('/agrilink/petani')->assertRedirect('/login');
        $this->get('/profil')->assertRedirect('/login');
        $this->post('/agrilink/simpan', [])->assertRedirect('/login');
    }

    public function test_katalog_tetap_publik_dan_form_tambah_tersembunyi_untuk_tamu(): void
    {
        $this->get('/agrilink')->assertOk()
            ->assertDontSee('Simpan Produk Ke Katalog')->assertSee('Login')->assertSee('Register');
    }

    public function test_register_menyimpan_password_ter_hash(): void
    {
        $this->post('/register', [
            'name' => 'Pengguna Baru', 'email' => 'baru@agrilink.test',
            'password' => 'rahasia123', 'password_confirmation' => 'rahasia123',
        ])->assertRedirect('/login');

        $user = User::where('email', 'baru@agrilink.test')->firstOrFail();
        $this->assertNotSame('rahasia123', $user->password);
        $this->assertTrue(Hash::check('rahasia123', $user->password));
    }

    public function test_register_menolak_input_tidak_valid(): void
    {
        User::factory()->create(['email' => 'ada@agrilink.test']);

        $this->from('/register')->post('/register', [
            'name' => '', 'email' => 'ada@agrilink.test',
            'password' => 'pendek', 'password_confirmation' => 'beda',
        ])->assertRedirect('/register')->assertSessionHasErrors(['name', 'email', 'password']);
    }

    public function test_login_berhasil_lalu_logout(): void
    {
        $user = User::factory()->create(['password' => Hash::make('rahasia123')]);

        $this->get('/agrilink/petani')->assertRedirect('/login');
        $this->post('/login', ['email' => $user->email, 'password' => 'rahasia123'])
            ->assertRedirect('/agrilink/petani');
        $this->assertAuthenticatedAs($user);

        $this->get('/agrilink')->assertSee('Logout')->assertSee('Simpan Produk Ke Katalog');

        $this->post('/logout')->assertRedirect('/login');
        $this->assertGuest();
    }

    public function test_login_gagal_menampilkan_pesan_galat(): void
    {
        $user = User::factory()->create();

        $this->from('/login')->post('/login', ['email' => $user->email, 'password' => 'salah-total'])
            ->assertRedirect('/login')->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_pengguna_login_dapat_menambah_produk(): void
    {
        $kat = KategoriProduk::create(['nama_kategori' => 'Sayuran']);

        $this->actingAs(User::factory()->create())->post('/agrilink/simpan', [
            'kategori_id' => $kat->id, 'nama_produk' => 'Tomat', 'harga' => 12000,
            'stok' => 50, 'lokasi_petani' => 'Kec. Sliyeg',
        ])->assertRedirect('/agrilink');

        $this->assertDatabaseHas('produk', ['nama_produk' => 'Tomat']);
    }

    public function test_profil_menampilkan_data_pengguna(): void
    {
        $user = User::factory()->create(['name' => 'Siti Aminah', 'email' => 'siti@agrilink.test']);

        $this->actingAs($user)->get('/profil')->assertOk()
            ->assertSee('Siti Aminah')->assertSee('siti@agrilink.test')->assertSee('WIB');
    }

    public function test_seeder_membuat_admin_dan_minimal_5_akun_ber_hash(): void
    {
        $this->seed(UserSeeder::class);

        $this->assertGreaterThanOrEqual(6, User::count());
        $this->assertTrue(User::all()->every(fn ($u) => str_starts_with($u->password, '$2y$')));
        $this->post('/login', ['email' => 'admin@agrilink.id', 'password' => 'AdminAgrilink#2026'])
            ->assertRedirect('/agrilink');
    }
}
