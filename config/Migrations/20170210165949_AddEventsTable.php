<?php
use Migrations\AbstractMigration;

class AddEventsTable extends AbstractMigration
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
        $table = $this->table('events', ['id' => false, 'primary_key' => ['id']]);

        $table->addColumn('id', 'uuid');

        $table->addColumn('entity_id', 'uuid', [
            'null' => false,
        ]);
        $table->addColumn('version', 'integer', [
            'null' => false,
        ]);
        $table->addColumn('type', 'string', [
            'null' => false,
        ]);
        $table->addColumn('payload', 'text', [
            'null' => false,
        ]);

        $table->addIndex(
            ['entity_id', 'version'],
            [
                'unique' => true,
            ]
        );

        $table->create();
    }
}
