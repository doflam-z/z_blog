<?php
    class UserSection{
        //显示文章总数
        function article_count(){
            $pdo=$this->mysqlCont();
            $sql="select * from article";
            $rows=$pdo->query($sql)->fetchAll();
            $result=count($rows);
            return $result;
        }

        //显示所有评论总数
        function comment_count(){
            $pdo=$this->mysqlCont();
            $sql="select * from comment";
            $rows=$pdo->query($sql)->fetchAll();
            $result=count($rows);
            return $result;
        }
        //显示文章评论总数
        function comment_num($article_id){
            $pdo=$this->mysqlCont();
            $sql="select id from comment where article_id='$article_id'";
            $rows=$pdo->query($sql)->fetchAll();
            $result=count($rows);
            return $result;
        }

        //显示文章访问数
        function article_read(){
            $pdo=$this->mysqlCont();
            $sql="select sum(article_views) from article";
            $result=$pdo->query($sql)->fetch();
            return $result["0"];
        }

        //连接数据库方法
        function mysqlCont()
        {
            try {
                $pdo = new PDO("mysql:host=localhost;dbname=phptest1", "root", "root");
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   //设置PDO显示异常
            } catch (PDOException $e) {
                echo '数据库连接失败' . $e->getMessage();
            }
            return $pdo;
        }
    }

/*    $a=new UserSection();
    echo $a->article_read();*/