<?php

namespace LaravelEnso\Core\app\Commands\DatabaseUpgrades;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\Menus\app\Models\Menu;
use Illuminate\Database\Schema\Blueprint;
use LaravelEnso\Calendar\app\Enums\Colors;
use LaravelEnso\Calendar\app\Models\Event;
use LaravelEnso\Calendar\app\Models\Calendar;
use LaravelEnso\Permissions\app\Models\Permission;
use LaravelEnso\Calendar\app\Contracts\Calendar as CalendarInterface;

class CalendarUpgrade extends DatabaseUpgrade
{
    const NEW_PERMISSION = 'core.calendar.index';
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

        return $hasNewPermission || ! $hasNewPackage || ! $hasOldEvents;
    }

    public function migrateTable()
    {
        (new AddNewCalendarPermissions())->migrate();

        $this
            ->updateMenu()
            ->createCalendarsTable()
            ->createDefaultCalendar()
            ->dropPivotConstraints()
            ->startEventsTableUpdate()
            ->setDefaultValues()
            ->enforceRequiredColumns()
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
            '--path' => 'vendor/laravel-enso/calendar/src/database/migrations/2019_03_20_100000_create_calendars_table.php',
            '--force' => true,
        ]);

        return $this;
    }

    public function createDefaultCalendar()
    {
        $this->defaultCalendar = Calendar::create([
            'name' => 'Default',
            'color' => Colors::Blue,
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

    private function startEventsTableUpdate()
    {
        Schema::rename('events', 'calendar_events');

        Schema::table('calendar_events', function (Blueprint $table) {
            $table->dropColumn('calendar');

            $table->renameColumn('starts_at', 'starts_date');
            $table->renameColumn('ends_at', 'ends_date');

            $table->integer('calendar_id')->unsigned()->index()
                ->nullable()->after('id');
            $table->foreign('calendar_id')->index()
                ->references('id')->on('calendars')->onDelete('cascade');
            $table->integer('parent_id')->nullable()->unsigned()
                ->index()->after('id');
        });

        Schema::table('calendar_events', function (Blueprint $table) {
            $table->date('starts_date')->index()->change();
            $table->date('ends_date')->index()->change();

            $table->time('starts_time')->nullable();
            $table->time('ends_time')->nullable();
        });

        return $this;
    }

    private function setDefaultValues()
    {
        Event::query()
            ->update([
                'calendar_id' => $this->defaultCalendar->id,
                'starts_time' => '11:00',
                'ends_time' => '12:00',
            ]);

        return $this;
    }

    private function enforceRequiredColumns()
    {
        Schema::table('calendar_events', function (Blueprint $table) {
            $table->integer('calendar_id')->unsigned()
                ->nullable(false)->change();
            $table->time('starts_time')->nullable(false)->change();
            $table->time('ends_time')->nullable(false)->change();
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
        Schema::table('event_user', function (Blueprint $table) {
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
    }
}
