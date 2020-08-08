<?php
header('Content-Type: text/html; charset=utf-8');
require 'classes/CommentClass.php';
$comments = new CommentClass();
if (isset($_GET)){
    echo $comments->query('insert into comments.comments (parent_id,topic_id,body) values (:parent,:topic,:comm)',[':parent'=>$_GET['parent_id'],':topic'=>$_GET['topic_id'],':comm'=>$_GET['comm']],2);
    $res = $comments->query('select * from comments.comments where topic_id = ? and create_at = (
                        select max(create_at) from comments.comments where topic_id = ?
                );',[$_GET['topic_id'],$_GET['topic_id']],1);
    $res[0]['color'] = $comments->rand_color();
    echo json_encode($res[0]);
}else{
    echo false;
}
