<?php
use Migrations\AbstractMigration;

class PayloadJsonTypeInEventsTable extends AbstractMigration
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
        $driverName = $this->getAdapter()->getConnection()->getAttribute(\PDO::ATTR_DRIVER_NAME);
        $serverVersion = $this->getAdapter()->getConnection()->getAttribute(\PDO::ATTR_SERVER_VERSION);
        if ($driverName === 'mysql' && version_compare($serverVersion, '5.7.0', '<')) {
            return;
        }

        if (! in_array($driverName, ['mysql', 'postgres'])) {
            return;
        }

        $this
            ->table('events')
            ->changeColumn('payload', 'json', [
                'null' => false,
            ])->save();
    }
}
