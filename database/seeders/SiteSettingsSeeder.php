<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiteSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = DB::table('site_settings')->count();
        if ($count == 0) {
            DB::table('site_settings')->insert(
                [
                    [
                        'title'             => 'OSHIT SD',
                        'short_title'       => 'OSD',
                        'contact_email'     => 'oshitsd@gmail.com',
                        'feedback_email'    => 'oshitsd@gmail.com',
                        'mobile1'           => '01883847733',
                        'mobile2'           => '01883847733',
                        'address'           => 'Dhaka',
                        'developed_by'      => 'OSHIT SUTRA DAR',
                        'created_at'        => now(),
                        'updated_at'        => now(),
                    ]
                ]
            );
        }
    }
}
