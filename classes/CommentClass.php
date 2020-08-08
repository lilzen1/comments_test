<?php

class CommentClass
{
    private $host;
    private $db;
    private $user;
    private $pass;
    private $charset;
    private $port;
    public $pdo;
    public $arr;

    public function __construct()
    {
        $this->host = 'localhost';
        $this->db = 'comments';
        $this->user = 'root';
        $this->pass = '';
        $this->charset = 'utf8';
        $this->port = '3306/test_db?serverTimezone=UTC&useJDBCCompliantTimeZoneShift=true';

        $dsn = "mysql:host={$this->host};dbname={$this->db};charset={$this->charset}";
        //$dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->db};charset={$this->charset}";
        $opt = [
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
          PDO::ATTR_EMULATE_PREPARES => false
        ];
        $this->pdo = new PDO($dsn,$this->user,$this->pass,$opt);
        $this->arr = $this->query('select * from comments.comments where topic_id = :topic_id order by topic_id,id,parent_id',[':topic_id' => $_GET['topic_id']]);
/*        echo '<pre>';
        var_dump($this->arr);
        echo '</pre>';*/
    }
    public function rand_color() {
    return sprintf('#%02X%02X%02X', rand(0, 255), rand(0, 255), rand(0, 255));
    }
    public function query($sql,$param = [],$type=1 /* 1 : select; 2 : insert; 3: update; 4: deletel;*/){
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($param);
        if ($type == 1){
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (count($result) > 0){
                return $result;
            }else{
                return false;
            }
        }
    }
    public function commentTree($arr){
        if ($arr == false){
            echo '<ul class="comm-list">';
            echo '<div id="comm-none" style="width: 200px;text-align: center;margin: auto">Нет новых коментариев</div>';
            echo '</ul>';
        }else{
            $parentMass = [];
            foreach ($arr as $key => $value){
                $id = $value['id'];
                $parentMass[$value['parent_id']][$id] = $value;
            }
            $tree = $parentMass[0];
            $this->showTree($tree,$parentMass);
        }
    }
    private function showTree(&$tree,$parentMass){
        echo '<ul class="comm-list">';
        foreach ($tree as $key => $value){
            echo "<li class='li-sps' data-id={$value['id']} >";
            echo '<div class="li-content">';
                echo "<div class='blockFoto' style='background-color: {$this->rand_color()}'></div>";
                    echo "<h4>Коментарий с id {$value['id']}</h4>";
                    echo '<span>'.$value['body'].'</span>';
                    echo "<button type='button' class='btn btn-outline-secondary btn-sm commBtn' name='addComment' data-toggle='collapse' data-target='#collapseBlock{$value['id']}'>Ответить</button>";
                    echo "<div class='collapse' id='collapseBlock{$value['id']}'>";
                        echo "<form class='formAnswer' data-parent_id='{$value['id']}' >";
                            echo "<textarea class='form-control' rows='2' placeholder='Добавьте Ваш комментарий' name='comm'></textarea>";
                            echo "<div class='err'></div>";
                            echo "<button class='btn btn-sm btn-primary pull-right mt-3 answerBtn' type='submit'><i class='fa fa-pencil fa-fw'></i> Добавить</button>";
                        echo "</form>";
                    echo "</div>";
                echo '</div>';

                if (array_key_exists($key,$parentMass)){
                    $tree = $parentMass[$key];
                    $this->showTree($tree,$parentMass);
                }else{
                    echo '</li>';
                }
        }
        echo '</ul>';
    }
}