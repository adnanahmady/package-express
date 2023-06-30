<?php

use App\Contracts\Models\CoverageAreaContract;
use App\Models\Partner;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration implements CoverageAreaContract {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create(self::TABLE, function (Blueprint $table): void {
            $table->id(self::ID);
            $table->string(self::PARTNER);
            $table->morphs(self::COVERAGE);
            $table->timestamps();

            $table->foreign(self::PARTNER)
                ->references(Partner::ID)
                ->on(Partner::TABLE);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table(self::TABLE, function (Blueprint $table): void {
            $table->dropForeign([self::PARTNER]);
        });
        Schema::dropIfExists(self::TABLE);
    }
};
