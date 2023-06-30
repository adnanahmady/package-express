<?php

use App\Contracts\Models\PartnerContract;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration implements PartnerContract {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create(self::TABLE, function (Blueprint $table): void {
            $table->string(self::ID)->primary();
            $table->string(self::OWNER_NAME);
            $table->string(self::TRADING_NAME);
            $table->string(self::DOCUMENT)->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(self::TABLE);
    }
};
