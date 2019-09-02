<?php

namespace LaravelEnso\Core\app\Commands\DatabaseUpgrades;

class AddingInvoiceLinePermissions extends StructureUpgrade
{
    protected $permissions = [
        ['name' => 'financials.clients.invoices.lines.show', 'description' => 'Get one invoice line', 'type' => 0, 'is_default' => false],
        ['name' => 'financials.clients.invoices.lines.store', 'description' => 'Store invoice line', 'type' => 0, 'is_default' => false],
        ['name' => 'financials.clients.invoices.lines.update', 'description' => 'Edit invoice line', 'type' => 0, 'is_default' => false],
        ['name' => 'financials.clients.invoices.lines.destroy', 'description' => 'Delete invoice line', 'type' => 0, 'is_default' => false],
    ];
}
