<?php

namespace LaravelEnso\Core\App\Services\Upgrades;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\Files\App\Models\File;
use LaravelEnso\Upgrade\App\Contracts\MigratesTable;
use LaravelEnso\Upgrade\App\Helpers\Table;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\Output;

class FilesIndex implements MigratesTable
{
    public function isMigrated(): bool
    {
        return Table::hasIndex('files', 'files_attachable_type_attachable_id_unique');
    }

    public function migrateTable(): void
    {
        $duplicated = $this->getDuplicates();

        if($duplicated->isNotEmpty()) {

            $this->logDuplicates($duplicated);

            return;
        }

        Schema::table('files', fn (Blueprint $table) => $table
            ->unique(['attachable_type','attachable_id']));
    }

    private function getDuplicates(): Collection
    {
        return File::selectRaw('attachable_id, attachable_type')
            ->groupBy('attachable_id','attachable_type')
            ->havingRaw('COUNT(attachable_id) > ?',[1])
            ->get();
    }

    private function logDuplicates(Collection $duplicated)
    {
        $out = new ConsoleOutput();

        $out->writeln("Unable to add unique index, the following id/type pair are duplicated");

        $duplicated->each(fn($file) => $out
            ->writeln("['attachable_type' => '{$file->attachable_type}', 'attachable_id' => '{$file->attachable_id}'],"));
    }
}
