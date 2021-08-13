<?php
namespace App\Models;

use App\Core\Model;

/**
 * @class User
 */
class User extends Model
{
    protected $table = 'users';
    const JOIN_STATEMENT = 'RIGHT JOIN tasks ON users.id = tasks.userId';

    public function joinToTasks()
    {
        $this->setJoin(self::JOIN_STATEMENT);
        return $this;
    }

}
