<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('visitor_hits');
        Schema::dropIfExists('visitor_stats');
    }

    public function down(): void
    {
        // Visitor tracking has been removed from the application.
    }
};