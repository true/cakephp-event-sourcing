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
            ->changeColumn('payload', 'text', [
                'null' => false,
                'limit' => \Phinx\Db\Adapter\MysqlAdapter::TEXT_LONG
            ])->save();
    }
}
