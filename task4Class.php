<?php

interface Box {
    function setData($key, $value);
    function getData($key);
    function save();
    function load();
}

abstract class AbstractBox implements Box {
    protected $info = [];
    public function setData($key, $value) {
        $this->info[$key] = $value;
    }
    public function getData($key){
        if (!($this->data[$key] == null))
            return $this->data[$key];
    }

    public abstract function save();
    public abstract function load();

}

class FileBox extends AbstractBox {
    private $out_file;


    public function __construct($out_file) {
        $this->out_file = $out_file;
    }

    public function save() {
        $check_infoFile =  unserialize(file_get_contents($this->out_file));
        if (!($check_infoFile == null)) {
            foreach ($this->info as $keyinfo => $valueinfo) {
                if (array_key_exists($keyinfo, $check_infoFile)) {
                    $this->keyinfo++;
                }
            }
        }
        file_put_contents($this->out_file, serialize($this->info));
    }

    public function load() {
        $this->info = unserialize(file_get_contents($this->out_file));
    }
}

class DbBox extends AbstractBox
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function save()
    {
        try {
            $this->pdo->beginTransaction();

            $this->pdo->query('DELETE FROM tasktest')->execute();

            $stmt = $this->pdo->prepare("INSERT INTO tasktest (key, value) VALUES (:key, :value)");

            foreach ($this->data as $key => $value) {
                $stmt->bindValue(':key', $key);
                $stmt->bindValue(':value', serialize($value));
                $stmt->execute();
            }
            $this->pdo->commit();
        } catch (Exception $e){
            $this->pdo->rollback();
            throw $e;
        }
    }

    public function load()
    {
        $stmt = $this->pdo->query('SELECT key, value FROM tasktest');

        $data = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[$row['key']] = unserialize($row['value']);
        }

        $this->data = $data;
    }
}
$dbh = new PDO("mysql:host=localhost;dbname=Task4", "root", "");
$box = new DbBox($dbh);
$box->setData(12, 'ttt1');
$box->save();

$box = new FileBox('data.txt');
$box->load();
$box->setData(12, 'ttt1');
$box->save();