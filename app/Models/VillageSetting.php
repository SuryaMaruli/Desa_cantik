<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VillageSetting extends Model
{
    public function up()
{
    Schema::create('village_settings', function (Blueprint $table) {
        $table->id();
        $table->string('key'); // Contoh: kepadatan_penduduk
        $table->string('value'); // Contoh: 2,981 jiwa/km²
        $table->timestamps();
    });
}
}
