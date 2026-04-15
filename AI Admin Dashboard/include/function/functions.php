<?php
/*
****
**** Title Function
**** Uses $pagetitle variable
*/
function getTitle(){
    global $pagetitle;
    if (isset($pagetitle)) {
        echo $pagetitle;
    } else {
        echo 'AI Admin Panel';
    }
}

/*
**** Function v2.0
**** Redirect Function [Parameters]
**** $themsg = Echo the error message
**** $url = The link you want to redirect to
**** $seconds = Wait time before redirecting
*/
function redirectHome($themsg, $url = null, $seconds = 1)
{
    if ($url === null || $url === "back") {
        $url = isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '' ? $_SERVER['HTTP_REFERER'] : "index.php";
    } elseif ($url === "home") {
        $url = "index.php";
    }
    //هي ترويسة (HTTP header) يرسلها المتصفح تلقائيًا عند الانتقال من صفحة إلى أخرى.

    echo "<div class='alert alert-success'>$themsg</div>";
    echo "<div class='alert alert-info'>You will be redirected in $seconds second(s)...</div>";

    header("refresh:$seconds;url=$url");
    exit();
}

/*  
**Count number of post Function v1.0
**Functiont to count Number of post Rows
**$comp=post to count
**$table=to chosoe from 
*/

function countPost($comp , $table ,$where){
    global $con;

    $stmt2=$con->prepare("SELECT COUNT($comp) FROM $table  Where cat_status =$where");
        $stmt2->execute();
          return $stmt2->fetchColumn();
}


function countData($comp , $table){
    global $con;

    $stmt2=$con->prepare("SELECT COUNT($comp) FROM $table ");
        $stmt2->execute();
          return $stmt2->fetchColumn();
}

/*
**Get Latest Records Functions v1.0
**Function to Get Latest Complains From DataBase[Usernam , Complain]
**$select=Field To Select
**$table=The Table to Choose From
**$limit=Number Of Record To Get
*/
function getLatest($select,$table,$order,$limit=5){
    global $con;
    $getstmt=$con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");
    $getstmt->execute();
    $rows=$getstmt->fetchAll();
    return $rows;
}

/*
****Function to Check Items in DataBase
****Function Accept Parameter
****$select = The Item To Select [Example : user, item , category]
****$from= The Table To Select From [Example : user, item , category ]
****$value= The Value of Select [Example : Odai , Box , Clothes]
*/
function checkitem($select , $from , $value){
    global $con;
    $statement=$con->prepare("SELECT $select FROM $from WHERE $select=?");
    $statement->execute(array($value));
    $count=$statement->rowCount();
    return $count;
}


?>