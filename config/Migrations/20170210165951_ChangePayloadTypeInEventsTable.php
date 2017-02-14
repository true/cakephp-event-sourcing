<?php
use Migrations\AbstractMigration;

class ChangePayloadTypeInEventsTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $this
            ->table('events')
            ->changeColumn('payload', 'longtext', [
                'null' => false,
            ])->save();
    }
}
