<?php

namespace LaravelEnso\Core\Services\Upgrades;

use Illuminate\Support\Facades\DB;
use LaravelEnso\Upgrade\Contracts\MigratesData;

class RenameMigrations implements MigratesData
{
    private array $migrations = [
        //Commercials
        '2019_03_20_131330_create_purchases_table' => '2019_03_20_100000_create_purchases_table',
        '2019_03_20_140921_create_structure_for_commercial' => '2019_03_20_101000_create_structure_for_commercial',
        '2019_03_20_141356_create_purchase_lines_table' => '2019_03_20_102000_create_purchase_lines_table',
        '2019_03_20_145202_create_purchase_returns_table' => '2019_03_20_103000_create_purchase_returns_table',
        '2019_03_21_103041_create_purchase_return_lines_table' => '2019_03_21_104000_create_purchase_return_lines_table',
        '2019_03_21_104915_create_sales_table' => '2019_03_21_105000_create_sales_table',
        '2019_03_21_114031_create_sale_lines_table' => '2019_03_21_106000_create_sale_lines_table',
        '2019_03_21_122724_create_sale_returns_table' => '2019_03_21_107000_create_sale_returns_table',
        '2019_03_21_140311_create_sale_return_lines_table' => '2019_03_21_108000_create_sale_return_lines_table',
        '2019_03_21_160417_create_structure_for_purchases' => '2019_03_21_109000_create_structure_for_purchases',
        '2019_03_21_182152_create_structure_for_purchase_returns' => '2019_03_21_110000_create_structure_for_purchase_returns',
        '2019_03_22_130907_create_structure_for_sale_returns' => '2019_03_22_111000_create_structure_for_sale_returns',
        '2019_03_22_133921_create_structure_for_sales' => '2019_03_22_112000_create_structure_for_sales',
        '2019_03_22_142842_create_sale_histories_table' => '2019_03_22_113000_create_sale_histories_table',
        '2019_03_22_144443_create_sale_line_histories_table' => '2019_03_22_114000_create_sale_line_histories_table',
        '2019_03_22_150940_create_sale_return_histories_table' => '2019_03_22_115000_create_sale_return_histories_table',
        '2019_03_22_175544_create_sale_return_line_histories_table' => '2019_03_22_116000_create_sale_return_line_histories_table',
        '2019_03_22_180204_create_purchase_histories_table' => '2019_03_22_117000_create_purchase_histories_table',
        '2019_03_22_180836_create_purchase_line_histories_table' => '2019_03_22_118000_create_purchase_line_histories_table',
        '2019_03_22_181531_create_purchase_return_histories_table' => '2019_03_22_119000_create_purchase_return_histories_table',
        '2019_03_22_182034_create_purchase_return_line_histories_table' => '2019_03_22_120000_create_purchase_return_line_histories_table',
        '2019_06_03_163948_add_permissions_to_inventory_structure' => '2019_06_03_121000_add_permissions_to_inventory_structure',
        '2019_08_16_170345_create_client_stocks_table' => '2019_08_16_122000_create_client_stocks_table',
        '2019_08_16_171143_create_structure_for_audit' => '2019_08_16_123000_create_structure_for_audit',
        '2019_08_17_151058_alter_inventory_stocks_table' => '2019_08_17_124000_alter_inventory_stocks_table',
        '2020_04_13_145637_create_structure_for_stats' => '2020_04_13_125000_create_structure_for_stats',

        //contracts
        '2018_11_30_115541_create_contracts_table' => '2018_11_30_100000_create_contracts_table',
        '2018_11_30_131945_create_structure_for_contracts' => '2018_11_30_101000_create_structure_for_contracts',
        '2019_11_15_131248_create_additional_acts_table' => '2019_11_15_102000_create_additional_acts_table',
        '2019_11_15_131248_create_structure_for_additional_acts' => '2019_11_15_103000_create_structure_for_additional_acts',
        '2019_11_21_121253_contract_project_pivot_table' => '2019_11_21_104000_contract_project_pivot_table',

        //currencies
        '2018_06_25_100001_create_exchange_rates_table' => '2018_06_25_100250_create_exchange_rates_table',
        '2018_06_26_100000_create_structure_for_exchange_rates' => '2018_06_26_100750_create_structure_for_exchange_rates',

        //departments
        '2017_11_30_213527_create_departments_table' => '2017_11_30_100000_create_departments_table',
        '2017_11_30_213527_create_structure_for_departments' => '2017_11_30_101000_create_structure_for_departments',

        //discounts
        '2018_11_07_104351_create_supplier_discounts_table' => '2018_11_07_100000_create_supplier_discounts_table',
        '2018_11_07_174224_create_client_discounts_table' => '2018_11_07_101000_create_client_discounts_table',
        '2018_11_13_112258_create_structure_for_discounts' => '2018_11_13_102000_create_structure_for_discounts',
        '2018_11_13_112940_create_structure_for_supplier_discounts' => '2018_11_13_103000_create_structure_for_supplier_discounts',
        '2018_11_13_124228_create_structure_for_client_discounts' => '2018_11_13_104000_create_structure_for_client_discounts',
        '2020_02_04_102149_create_supplier_product_discounts_table' => '2020_02_04_105000_create_supplier_product_discounts_table',
        '2020_02_04_102208_create_supplier_service_discounts_table' => '2020_02_04_106000_create_supplier_service_discounts_table',
        '2020_02_04_102222_create_client_product_discounts_table' => '2020_02_04_107000_create_client_product_discounts_table',
        '2020_02_04_102231_create_client_service_discounts_table' => '2020_02_04_108000_create_client_service_discounts_table',
        '2020_02_04_103653_create_structure_for_supplier_product_discounts' => '2020_02_04_109000_create_structure_for_supplier_product_discounts',
        '2020_02_04_103705_create_structure_for_supplier_service_discounts' => '2020_02_04_110000_create_structure_for_supplier_service_discounts',
        '2020_02_04_103716_create_structure_for_client_product_discounts' => '2020_02_04_111000_create_structure_for_client_product_discounts',
        '2020_02_04_103727_create_structure_for_client_service_discounts' => '2020_02_04_112000_create_structure_for_client_service_discounts',

        //emag
        '2019_08_15_142444_alter_sales_table' => '2019_08_15_100000_alter_sales_table',
        '2019_12_20_102511_create_structure_for_emag' => '2019_12_20_101000_create_structure_for_emag',
        '2019_12_20_112710_create_emag_offers_table' => '2019_12_20_102000_create_emag_offers_table',
        '2020_02_17_122535_update_sales_structure' => '2020_02_17_103000_update_sales_structure',
        '2020_04_23_165607_create_emag_products_table' => '2020_04_23_104000_create_emag_products_table',

        //financials
        '2019_01_18_170702_create_supplier_invoices_table' => '2019_01_18_100000_create_supplier_invoices_table',
        '2019_01_18_173942_create_client_invoices_table' => '2019_01_18_101000_create_client_invoices_table',
        '2019_01_18_174216_create_supplier_payments_table' => '2019_01_18_102000_create_supplier_payments_table',
        '2019_01_18_180458_create_client_payments_table' => '2019_01_18_103000_create_client_payments_table',
        '2019_01_21_123352_create_invoice_lines_table' => '2019_01_21_104000_create_invoice_lines_table',
        '2019_01_21_161819_create_structure_for_financials' => '2019_01_21_105000_create_structure_for_financials',
        '2019_01_21_163050_create_structure_for_supplier_invoices' => '2019_01_21_106000_create_structure_for_supplier_invoices',
        '2019_01_22_172629_create_structure_for_client_invoices' => '2019_01_22_107000_create_structure_for_client_invoices',
        '2019_02_07_140117_create_structure_for_client_payments' => '2019_02_07_108000_create_structure_for_client_payments',
        '2019_02_07_143214_create_structure_for_supplier_payments' => '2019_02_07_109000_create_structure_for_supplier_payments',
        '2020_04_13_175534_create_structure_for_financials_stats' => '2020_04_13_110000_create_structure_for_financials_stats',

        //how-to
        '2017_01_01_149125_create_how_to_posters_table' => '2017_01_01_100000_create_how_to_posters_table',
        '2017_01_01_149250_create_how_to_tags_table' => '2017_01_01_101000_create_how_to_tags_table',
        '2017_01_01_149750_create_structure_for_how_to' => '2017_01_01_102000_create_structure_for_how_to',
        '2017_01_01_149000_create_how_to_videos_table' => '2017_01_01_103000_create_how_to_videos_table',
        '2017_01_01_149500_create_how_to_tag_how_to_video_pivot_table' => '2017_01_01_104000_create_how_to_tag_how_to_video_pivot_table',

        //inventory
        '2018_11_26_095047_create_warehouses_table' => '2018_11_26_100000_create_warehouses_table',
        '2018_11_26_102356_create_structure_for_inventory' => '2018_11_26_101000_create_structure_for_inventory',
        '2018_11_26_103510_create_structure_for_positions' => '2018_11_26_102000_create_structure_for_positions',
        '2018_11_26_142610_create_inventory_positions_table' => '2018_11_26_103000_create_inventory_positions_table',
        '2018_11_26_160951_create_inventory_ins_table' => '2018_11_26_104000_create_inventory_ins_table',
        '2018_11_26_171616_create_inventory_outs_table' => '2018_11_26_105000_create_inventory_outs_table',
        '2018_12_10_124131_create_inventory_reservations_table' => '2018_12_10_106000_create_inventory_reservations_table',
        '2018_12_11_100024_create_structure_for_inventories' => '2018_12_11_107000_create_structure_for_inventories',
        '2018_12_12_105146_create_structure_for_inventory_ins' => '2018_12_12_108000_create_structure_for_inventory_ins',
        '2018_12_12_105747_create_inventory_stocks_table' => '2018_12_12_109000_create_inventory_stocks_table',
        '2018_11_26_143500_create_structure_for_labels' => '2018_11_26_110000_create_structure_for_labels',
        '2018_11_26_143500_create_structure_for_warehouses' => '2018_11_26_111000_create_structure_for_warehouses',

        //projects
        '2018_11_01_161945_create_structure_for_project_splits' => '2018_11_01_100000_create_structure_for_project_splits',
        '2018_11_01_161945_create_structure_for_projects' => '2018_11_01_101000_create_structure_for_projects',
        '2018_12_01_152541_create_projects_table' => '2018_12_01_102000_create_projects_table',
        '2019_11_14_111253_create_business_domains_table' => '2019_11_14_103000_create_business_domains_table',
        '2019_11_14_111253_create_structure_for_business_domains' => '2019_11_14_104000_create_structure_for_business_domains',
        '2019_11_14_121253_business_domain_project_pivot_table' => '2019_11_14_105000_business_domain_project_pivot_table',
        '2019_12_12_142000_create_project_splits_table' => '2019_12_12_106000_create_project_splits_table',

        //Hr
        '2018_12_03_102356_create_structure_for_hr' => '2018_12_03_000000_create_structure_for_hr',
        '2018_12_03_141934_create_positions_table' => '2018_12_03_001000_create_positions_table',
        '2018_12_03_141935_create_employees_table' => '2018_12_03_002000_create_employees_table',
        '2018_12_05_141934_create_payrolls_table' => '2018_12_05_003000_create_payrolls_table',
        '2018_12_19_125508_create_structure_for_hr_positions' => '2018_12_19_004000_create_structure_for_hr_positions',
        '2018_12_19_125508_create_structure_for_payrolls' => '2018_12_19_005000_create_structure_for_payrolls',
        '2018_12_19_132511_create_structure_for_employees' => '2018_12_19_006000_create_structure_for_employees',
        '2018_12_24_113141_employee_project_pivot_table' => '2018_12_24_007000_employee_project_pivot_table',

        //measurement-units
        '2018_11_01_095226_create_measurement_units_table' => '2018_11_01_000000_create_measurement_units_table',
        '2018_11_01_095226_create_structure_for_measurement_units' => '2018_11_01_001000_create_structure_for_measurement_units',

        //categories
        '2018_11_01_180754_create_categories_table' => '2018_11_01_103000_create_categories_table',
        '2018_11_01_180755_create_structure_for_categories' => '2018_11_01_104000_create_structure_for_categories',

        //services
        '2019_03_20_102819_create_services_table' => '2019_03_20_000000_create_services_table',
        '2019_03_20_102819_create_structure_for_services' => '2019_03_20_001000_create_structure_for_services',
    ];

    public function migrateData(): void
    {
        DB::beginTransaction();
        foreach ($this->migrations as $old => $new) {
            DB::table('migrations')
                ->whereMigration($old)
                ->update([
                    'migration' => $new,
                ]);
        }
        DB::rollBack();
    }

    public function isMigrated(): bool
    {
        return DB::table('migrations')
            ->whereIn('migration', array_keys($this->migrations))
            ->exists();
    }
}
