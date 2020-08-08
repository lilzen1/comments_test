<?php
if (!isset($_GET['topic_id'])){
    header('location:index.php?topic_id=1');
}
header('Content-Type: text/html; charset=utf-8');
require 'classes/CommentClass.php';
$comments = new CommentClass();

?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="css/font-awesome.min.css" />
    <link rel="stylesheet" href="css/style.css"/>

    <title>Hello, world!</title>
</head>
<body>
<input type='hidden' name='topic_id' value='<?=$_GET['topic_id']?>'>"
<div class="container" style="margin-bottom: 50px">
    <div class="row" id="block">
        <div class="col-md-12">
            <div id="block-comment" class="container">
                <div class="row">
                    <?php
                    $comments->commentTree($comments->arr);
                    ?>
                </div>
            </div>
            <div id="form-comment" class="panel">
                <div class="panel-body">
                    <form id="form-add-comment">
                        <textarea class="form-control" rows="2" placeholder="Добавьте Ваш комментарий" name="comm"></textarea>
                        <div class="err"></div>
                        <div class="mar-top">
                            <button name="btnAdd" id="btnAddNewComm" class="btn btn-sm btn-primary pull-right mt-3" type="submit"><i class="fa fa-pencil fa-fw"></i> Добавить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="displayNone">
    <li class='li-sps li-shab' data-id=''>
        <div class="li-content">
            <div class="blockFoto"></div>
            <h4>Коментарий с id </h4>
            <span></span>
            <button type='button' class='btn btn-outline-secondary btn-sm commBtn' name='addComment' data-toggle='collapse' data-target=''>Ответить</button>
            <div class="collapse" id="">
                <form class='formAnswer' data-parent_id='' >
                    <textarea class='form-control' rows='2' placeholder='Добавьте Ваш комментарий' name='comm'></textarea>
                    <div class="err"></div>
                    <button class='btn btn-sm btn-primary pull-right mt-3 answerBtn' type='submit'><i class='fa fa-pencil fa-fw'></i> Добавить</button>
                </form>
            </div>
        </div>
    </li>
</div>

    <script src="js/jquery-3.4.1.min.js" type="text/javascript"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<script src="js/main.js" type="text/javascript"></script>
</body>
</html>



