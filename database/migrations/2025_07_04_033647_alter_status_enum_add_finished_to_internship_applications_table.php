<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        DB::statement("ALTER TABLE internship_applications DROP CONSTRAINT IF EXISTS internship_applications_status_check");
        
        DB::statement("ALTER TABLE internship_applications ADD CONSTRAINT internship_applications_status_check CHECK (status IN ('pending', 'approved', 'rejected', 'finished'))");
    }
    
    public function down()
    {
        DB::statement("ALTER TABLE internship_applications DROP CONSTRAINT IF EXISTS internship_applications_status_check");
        
        DB::statement("ALTER TABLE internship_applications ADD CONSTRAINT internship_applications_status_check CHECK (status IN ('pending', 'approved', 'rejected'))");
    }
};
