<?php

namespace Tests\Feature;

use App\Models\Laporan;
use App\Models\User;
use Database\Seeders\PetugasSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_tamu_diarahkan_ke_login_saat_membuka_daftar_laporan(): void
    {
        $this->get('/laporan')->assertRedirect('/login');
        $this->get('/profil')->assertRedirect('/login');
        $this->get('/daftar-laporan')->assertRedirect('/laporan'); // lalu ke /login
    }

    public function test_warga_tetap_bisa_melapor_tanpa_login(): void
    {
        $this->get('/lapor')->assertOk()->assertSee('Form Lapor Kejadian Banjir');

        $this->post('/lapor', [
            'nama_pelapor' => 'Warga Dayeuhkolot',
            'lokasi' => 'Dayeuhkolot',
            'tinggi_genangan' => 55,
            'tanggal_kejadian' => '2026-10-20',
        ])->assertOk()->assertSee('berhasil dikirim');

        $this->assertDatabaseHas('laporans', ['nama_pelapor' => 'Warga Dayeuhkolot']);
    }

    public function test_register_menyimpan_password_dalam_bentuk_hash(): void
    {
        $this->post('/register', [
            'name' => 'Petugas Baru',
            'email' => 'baru@bpbd.test',
            'password' => 'rahasia123',
            'password_confirmation' => 'rahasia123',
        ])->assertRedirect('/login');

        $user = User::where('email', 'baru@bpbd.test')->firstOrFail();
        $this->assertNotSame('rahasia123', $user->password);
        $this->assertTrue(Hash::check('rahasia123', $user->password));
    }

    public function test_register_menolak_input_tidak_valid(): void
    {
        User::factory()->create(['email' => 'ada@bpbd.test']);

        $this->from('/register')->post('/register', [
            'name' => '',
            'email' => 'ada@bpbd.test',
            'password' => 'pendek',
            'password_confirmation' => 'beda',
        ])->assertRedirect('/register')
          ->assertSessionHasErrors(['name', 'email', 'password']);
    }

    public function test_login_berhasil_dan_diarahkan_ke_halaman_tujuan_semula(): void
    {
        $user = User::factory()->create(['password' => Hash::make('rahasia123')]);
        Laporan::create(['nama_pelapor' => 'A', 'lokasi' => 'B', 'tinggi_genangan' => 10, 'tanggal_kejadian' => '2026-10-01']);

        $this->get('/laporan')->assertRedirect('/login');   // simpan "intended"
        $this->post('/login', ['email' => $user->email, 'password' => 'rahasia123'])
            ->assertRedirect('/laporan');

        $this->assertAuthenticatedAs($user);
        $this->get('/laporan')->assertOk()->assertSee('Daftar Laporan Kejadian Banjir');
    }

    public function test_login_gagal_menampilkan_pesan_galat(): void
    {
        $user = User::factory()->create();

        $this->from('/login')->post('/login', ['email' => $user->email, 'password' => 'salah-total'])
            ->assertRedirect('/login')
            ->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_navigasi_berubah_sesuai_status_login(): void
    {
        $this->get('/lapor')->assertSee('Login')->assertSee('Register')
            ->assertDontSee('Profil Petugas')->assertDontSee('Logout');

        $this->actingAs(User::factory()->create(['name' => 'Budi Santoso']))
            ->get('/lapor')->assertSee('Daftar Laporan')->assertSee('Profil Petugas')
            ->assertSee('Logout')->assertDontSee('>Register<', false);
    }

    public function test_profil_menampilkan_data_petugas_yang_login(): void
    {
        $user = User::factory()->create(['name' => 'Siti Aminah', 'email' => 'siti@bpbd.test']);

        $this->actingAs($user)->get('/profil')->assertOk()
            ->assertSee('Siti Aminah')->assertSee('siti@bpbd.test')->assertSee('WIB');
    }

    public function test_logout_mengakhiri_sesi(): void
    {
        $this->actingAs(User::factory()->create())->post('/logout')->assertRedirect('/login');
        $this->assertGuest();
        $this->get('/laporan')->assertRedirect('/login');
    }

    public function test_pengguna_yang_sudah_login_tidak_bisa_membuka_halaman_login(): void
    {
        $this->actingAs(User::factory()->create())->get('/login')->assertRedirect('/laporan');
    }

    public function test_seeder_petugas_membuat_admin_dan_minimal_5_akun_ber_hash(): void
    {
        $this->seed(PetugasSeeder::class);

        $this->assertGreaterThanOrEqual(6, User::count());
        $admin = User::where('email', 'admin@bpbd.bandungkab.go.id')->firstOrFail();
        $this->assertTrue(Hash::check('AdminBPBD#2026', $admin->password));
        $this->assertTrue(User::all()->every(fn ($u) => str_starts_with($u->password, '$2y$')));

        $this->post('/login', ['email' => 'admin@bpbd.bandungkab.go.id', 'password' => 'AdminBPBD#2026'])
            ->assertRedirect('/laporan');
    }
}
