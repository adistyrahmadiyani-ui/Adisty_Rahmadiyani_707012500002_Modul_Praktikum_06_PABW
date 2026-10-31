<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Password dummy untuk semua petugas hasil Faker (hanya untuk pengujian).
     */
    private const PASSWORD_USER = 'user12345';

    /**
     * Akun admin BPBD dengan email & password tetap.
     */
    private const ADMIN_EMAIL    = 'admin@agrilink.id';
    private const ADMIN_PASSWORD = 'AdminAgrilink#2026';

    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // 1 akun admin (updateOrCreate -> aman dijalankan berulang kali)
        User::updateOrCreate(
            ['email' => self::ADMIN_EMAIL],
            [
                'name'     => 'Admin Agrilink ID',
                'password' => Hash::make(self::ADMIN_PASSWORD),
            ]
        );

        // 6 akun pengguna dummy (minimal 5) dengan data Faker locale id_ID
        $akunDummy = [];
        for ($i = 0; $i < 6; $i++) {
            $user = User::create([
                'name'     => $faker->name(),
                'email'    => $faker->unique()->safeEmail(),
                'password' => Hash::make(self::PASSWORD_USER),
            ]);
            $akunDummy[] = [$user->name, $user->email, self::PASSWORD_USER];
        }

        // Tampilkan kredensial untuk keperluan uji login.
        $this->command?->info('Akun hasil seeder (gunakan untuk uji login):');
        $this->command?->table(
            ['Nama', 'Email', 'Password'],
            array_merge(
                [['Admin Agrilink ID', self::ADMIN_EMAIL, self::ADMIN_PASSWORD]],
                $akunDummy
            )
        );
    }
}
