<?php

namespace LaravelEnso\Core\app\Commands\DatabaseUpgrades;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\Calendar\app\Contracts\Calendar as CalendarInterface;
use LaravelEnso\Calendar\app\Enums\Colors;
use LaravelEnso\Calendar\app\Models\Calendar;
use LaravelEnso\Calendar\app\Models\Event;
use LaravelEnso\Menus\app\Models\Menu;
use LaravelEnso\Permissions\app\Models\Permission;
use LaravelEnso\Roles\app\Models\Role;

class CalendarUpgrade extends DatabaseUpgrade
{

    const NEW_PERMISSION = 'core.calendar.create';
    private $defaultCalendar;

    protected function isMigrated() //skip
    {
        $hasNewPermission = Permission::whereName(self::NEW_PERMISSION)->first() !== null;

        $hasNewPackage = interface_exists(CalendarInterface::class);

        $hasOldEvents = Schema::hasTable('events')
            && Schema::hasColumn('events', 'lat')
            && Schema::hasColumn('events', 'frequence')
            && Schema::hasColumn('events', 'location')
            && Schema::hasColumn('events', 'recurrence_ends_at');

        return $hasNewPermission || !$hasNewPackage || !$hasOldEvents;
    }

    public function migrateTable()
    {
        (new AddNewCalendarPermissions())->migrate();

        $this
            ->addOptionalPermission()
            ->updateMenu()
            ->createCalendarsTable()
            ->createDefaultCalendar()
            ->dropPivotConstraints()
            ->renamePivotTable()
            ->startEventsTableUpdate()
            ->setDefaultValues()
            ->enforceRequiredColumns()
            ->setForeignKey()
            ->updateRemindersTable()
            ->createPivotConstraints()
            ->updateMigrations();
    }

    private function updateMenu()
    {
        Menu::whereName('Calendar')->update([
            'permission_id' => Permission::whereName('core.calendar.index')->first()->id,
        ]);

        return $this;
    }

    private function createCalendarsTable()
    {
        \Artisan::call('migrate', [
            '--path'  => 'vendor/laravel-enso/calendar/src/database/migrations/2019_03_20_100000_create_calendars_table.php',
            '--force' => true,
        ]);

        return $this;
    }

    private function createDefaultCalendar()
    {
        $this->defaultCalendar = Calendar::create([
            'name'    => 'Default',
            'color'   => Colors::Blue,
            'private' => false,
        ]);

        return $this;
    }

    private function dropPivotConstraints()
    {
        Schema::table('event_user', function (Blueprint $table) {
            $table->dropForeign(['event_id']);
            $table->dropForeign(['user_id']);
        });

        return $this;
    }

    private function renamePivotTable()
    {
        Schema::rename('event_user', 'calendar_event_user');

        return $this;
    }

    private function startEventsTableUpdate()
    {
        Schema::rename('events', 'calendar_events');

        Schema::table('calendar_events', function (Blueprint $table) {
            $table->dropColumn('calendar');

            $table->renameColumn('starts_at', 'start_date');
            $table->renameColumn('ends_at', 'end_date');

            $table->unsignedInteger('calendar_id')->index()
                ->nullable()->after('id');
            $table->unsignedInteger('parent_id')->index()
                ->nullable()->after('calendar_id');
        });

        Schema::table('calendar_events', function (Blueprint $table) {
            $table->time('start_time')->nullable()->after('start_date');
            $table->time('end_time')->nullable()->after('end_date');
        });

        return $this;
    }

    private function setDefaultValues()
    {
        Event::each(function ($event) {
            $event->update([
                'calendar_id' => $this->defaultCalendar->id,
                'start_time'  => $event->start_date->format('H:i'),
                'end_time'    => $event->end_date->format('H:i'),
            ]);
        });

        return $this;
    }

    private function enforceRequiredColumns()
    {
        Schema::table('calendar_events', function (Blueprint $table) {
            $table->unsignedInteger('calendar_id')->nullable(false)->change();

            $table->date('start_date')->index()->change();
            $table->date('end_date')->index()->change();

            $table->time('start_time')->nullable(false)->change();
            $table->time('end_time')->nullable(false)->change();
        });

        return $this;
    }

    private function setForeignKey()
    {
        Schema::table('calendar_events', function (Blueprint $table) {
            $table->foreign('calendar_id')->index()
                ->references('id')->on('calendars')->onDelete('cascade');
        });

        return $this;
    }

    private function updateRemindersTable()
    {
        Schema::rename('reminders', 'calendar_reminders');

        Schema::table('calendar_reminders', function (Blueprint $table) {
            $table->renameColumn('remind_at', 'scheduled_at');
            $table->renameColumn('reminded_at', 'sent_at');
        });

        return $this;
    }

    private function createPivotConstraints()
    {
        Schema::table('calendar_event_user', function (Blueprint $table) {
            $table->foreign('event_id')->references('id')->on('calendar_events')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        return $this;
    }

    private function updateMigrations()
    {
        DB::table('migrations')
            ->whereMigration('2019_03_21_100000_create_events_table')
            ->update(['migration' => '2019_03_21_100000_create_calendar_events_table']);

        DB::table('migrations')
            ->whereMigration('2019_03_21_100100_create_reminders_table')
            ->update(['migration' => '2019_03_21_100100_create_calendar_reminders_table']);

        DB::table('migrations')
            ->whereMigration('2019_03_21_100200_create_event_user_pivot_table')
            ->update(['migration' => '2019_03_21_100200_create_calendar_event_user_pivot_table']);
    }

    private function addOptionalPermission()
    {
        $permission = Permission::updateOrCreate([
            'name' => 'core.calendar.events.index',
        ], [
            'description' => 'Get events',
            'type'        => 0,
            'is_default'  => true,
        ]);

        $permission->roles()->sync(Role::pluck('id'));

        return $this;
    }
}
