<?php

namespace Modules\Enquiry\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Enquiry\Entities\EnquiryStatus;

class EnquiryStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Model::unguard();

        EnquiryStatus::create([
            'title' => 'Awaiting Payment'
        ]);
        EnquiryStatus::create([
            'title' => 'Awaiting Stock Arrival'
        ]);
        EnquiryStatus::create([
            'title' => 'Warehouse Processing'
        ]);
        EnquiryStatus::create([
            'title' => 'Dispatched'
        ]);
        EnquiryStatus::create([
            'title' => 'Complete'
        ]);
        
    }
}
