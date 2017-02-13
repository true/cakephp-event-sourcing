<?php
use Migrations\AbstractMigration;

class AddCreatedToEventsTable extends AbstractMigration
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
            ->addColumn('created', 'datetime', [
                'default' => null,
                'null' => true,
            ])->save();
    }
}
