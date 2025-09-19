<?php

use Phinx\Migration\AbstractMigration;

class CreateUsersTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('users');
        $table->addColumn('name', 'string', ['limit' => 255])
              ->addColumn('email', 'string', ['limit' => 255])
              ->addColumn('password', 'string', ['limit' => 255])
              ->addColumn('remember_token', 'string', ['limit' => 100, 'null' => true])
              ->addColumn('email_verified_at', 'datetime', ['null' => true])
              ->addColumn('created_at', 'datetime')
              ->addColumn('updated_at', 'datetime')
              ->addIndex(['email'], ['unique' => true])
              ->create();
    }
}