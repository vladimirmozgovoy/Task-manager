<?php
namespace App\Core;

use App\Helpers\ApiHelper;

/**
 * @class Model
 */
class Model
{

    private $query;
    private $orderString = ' ORDER BY ';
    private $pageString = ' LIMIT ';
    private $filterString = ' WHERE ';
    private static $insertString = 'INSERT INTO ';
    private static $updateString = 'UPDATE ';
    private $db;
    protected $table;
    protected $order;
    protected $join;
    protected $paging;
    protected $select = '*';
    protected $filter;
    const COUNT = 3;

    public function __construct()
    {
        $this->setDB();
        $this->setQuery();
    }

    private function __clone() {}

    private function setQuery()
    {
        $this->query = 'SELECT '.$this->select.' FROM `'.$this->table.'` ';
    }

    public function setOrder($order)
    {
        if(empty($order['sortField']) || empty($order['sortDirection'])){
            return $this;
        }
        $this->order = $order;
        return $this;
    }

    public function setPage($page)
    {
        if((int)$page < 1){
            return $this;
        }

        $this->paging = [
            'start' => ($page - 1) * self::COUNT,
            'limit' => self::COUNT
        ];
        return $this;
    }

    public function setSelect($select)
    {
        $this->select = implode(',', $select);
        $this->setQuery();
        return $this;
    }

    public function setFilter($filter)
    {
        if(empty($filter)){
            return $this;
        }
        $operator = 'AND';
        if(!empty($filter['operator'])){
            $operator = $filter['operator'];
            unset($filter['operator']);
        }
        $i = 1;
        $count = count($filter);

        foreach ($filter as $key => $value) {
            $this->filterString .= "`$key`=" . $this->db->quote($value);
            if($i < $count){
                $this->filterString .= ' ' . $operator . ' ';
            }
            $i++;
        }

        $this->filter = $filter;
        $this->setQuery($this->filterString);
        return $this;
    }

    protected function setJoin($join)
    {
        $this->join = $join;
        return $this;
    }

    private function setDB()
    {
        $host = DB_HOST;
        $db   = DB_NAME;
        $user = DB_USER;
        $pass = DB_PASS;
        $charset = DB_CHARSET;

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $opt = [
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $this->db = new \PDO($dsn, $user, $pass, $opt);
        return $this;
    }

    public static function create($data)
    {
        try{
            $model = new static();
            $db = (new self())
                ->setDB()
                ->db
            ;

            $db->beginTransaction();

            $keys = [];
            $values = [];

            foreach($data as $key => $value){
                $keys[] = "`$key`";
                $values[] = $db->quote($value);
            }

            $keys = '(' . implode(', ', $keys) . ')';
            $values = '(' . implode(', ', $values) . ')';
            $sql = self::$insertString . $model->table . ' ' . $keys . ' VALUES ' . $values;

            $sth = $db->prepare($sql);
            $sth->execute();

            $db->commit();

            return $db->lastInsertId();

        } catch(\PDOException $e){
            $db->rollback();
            echo ApiHelper::sendError(['error' => 'Во время добавления записи воззникла ошибка.']);
            die;
        }
    }

    public static function update($id, $data)
    {
        try{
            $model = new static();
            $db = (new self())
                ->setDB()
                ->db
            ;
            $db->beginTransaction();

            $i = 1;
            $count = count($data);
            $fields = '';

            foreach ($data as $key => $value) {
                $fields .= "`$key`=" . $db->quote($value);
                if($i < $count){
                    $fields .= ', ';
                }
                $i++;
            }

            $sql = self::$updateString . $model->table . ' SET ' . $fields . $model->filterString . '`id`='.$id;

            $sth = $db->prepare($sql);
            $sth->execute();

            $db->commit();

        } catch(\PDOException $e){
            $db->rollback();
            echo ApiHelper::sendError(['error' => 'Во время редактирования записи возникла ошибка.']);
            die;
        }
    }

    public function get()
    {
        $this->query .= $this->join ?: '';

        $field = $this->order['sortField'] ?: '';
        $direction = $this->order['sortDirection'] ?: '';

        $this->query .= !empty($this->filter) ? $this->filterString : '';
        $this->query .= !empty($this->order) ? $this->orderString . $field . ' ' . $direction : '';
        $this->query .= !empty($this->paging) ? $this->pageString . $this->paging['start'] . ', ' . $this->paging['limit'] : '';

        $sth = $this->db->prepare($this->query);
        $sth->execute();

        return $sth->fetchAll();
    }

    public function count()
    {

        $query = 'SELECT '.$this->select.' FROM `'.$this->table.'` ' . $this->join;
        $sth = $this->db->prepare($query);
        $sth->execute();

        return count($sth->fetchAll());
    }

}
