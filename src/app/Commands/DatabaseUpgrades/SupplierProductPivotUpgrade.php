<?php

namespace LaravelEnso\Core\app\Commands\DatabaseUpgrades;

use App\Enums\VatValues;
use Carbon\Carbon;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\Permissions\app\Models\Permission;
use LaravelEnso\Products\app\Models\Product;
use LaravelEnso\Products\app\Models\ProductSupplier;
use LaravelEnso\Roles\app\Models\Role;

class SupplierProductPivotUpgrade extends DatabaseUpgrade
{
    private const Roles = ['admin', 'supervisor'];
    protected $title = 'adding part_number to product_supplier';

    protected function isMigrated()
    {
        return ! Schema::hasTable('product_supplier')
            || Schema::hasColumn('product_supplier', 'part_number');
    }

    protected function migrateTable()
    {
        Schema::table('product_supplier', function (Blueprint $table) {
            $table->string('part_number')->after('acquisition_price')
                ->nullable();
            $table->timestamps();
        });
    }

    protected function migrateData()
    {
        $this->updatePivot();
        $this->addPermission();
    }

    protected function postMigrateTable()
    {
        //
    }

    protected function rollbackMigrateTable()
    {
        Schema::table('product_supplier', function (Blueprint $table) {
            $table->dropColumn(['part_number', 'created_at', 'updated_at']);
        });
    }

    public function updatePivot(): void
    {
        $now = Carbon::now();

        Product::has('suppliers')
            ->with(['suppliers'])
            ->chunkById(500, function ($products) use ($now) {
                $products->each(function ($product) use ($now) {
                    $product->suppliers()
                        ->sync($this->payload($now, $product));
                });
            });
    }

    private function payload($now, $product)
    {
        return $product->suppliers->reduce(function ($arr, $supplier) use ($now, $product) {
            $arr[$supplier->id] = [
                'part_number' => $product->part_number,
                'created_at' => $now,
                'updated_at' => $now,
            ];

            return $arr;
        });
    }

    protected function addPermission(): void
    {
        $permission = Permission::create([
            'name' => 'products.suppliers',
            'description' => 'Get product supplier options for select',
            'type' => 0,
            'is_default' => false,
        ]);

        $roles = Role::whereIn('name', self::Roles)->get();

        $permission->roles()->attach($roles->pluck('id'));
    }
}
