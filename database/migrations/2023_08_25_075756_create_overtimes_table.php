<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    protected $butuhPersetujuan = 'butuh persetujuan';
    protected $enumApproved = ['butuh persetujuan', 'disetujui', 'ditolak'];
    /**
     * Run the migrations.
     */
    public function up(): void
    {


        Schema::create('overtimes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->date('tanggal');
            $table->enum('shift', ['pagi', 'siang']);
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->integer('jumlah_jam');
            $table->enum('approved_user', $this->enumApproved)->default($this->butuhPersetujuan);
            $table->enum('approved_pengawas', $this->enumApproved)->default($this->butuhPersetujuan);
            $table->enum('approved_manajer', $this->enumApproved)->default($this->butuhPersetujuan);
            $table->unsignedBigInteger('pengawas_id')->nullable();
            $table->unsignedBigInteger('manajer_id')->nullable();
            $table->string("jumlah_operator");
            $table->string("alasan");
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('pengawas_id')->references('id')->on('users');
            $table->foreign('manajer_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('overtimes');
    }
};