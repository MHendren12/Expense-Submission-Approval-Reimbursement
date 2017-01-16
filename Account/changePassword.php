<?php
class db
{
    public $host;
    public $user;
    public $pass;
    public $data;
    public $con;
    public $table;
    function db()
    {
        $this->host="127.0.0.1";
        $this->user="mhendren12";
        $this->pass="";
        $this->data="expense_reimbursement";   
    }   
    public function connect()
    {
        $this->con=mysql_connect($this->host,$this->user,$this->pass);
        if(!$this->con)
        {
            echo mysql_error();
        }
        $sel=mysql_select_db($this->data, $this->con);
        if(!$sel)
        {
            echo mysql_error();
        }
    }
    public function insert($user_pass)
    {
        $sql=mysql_query("UPDATE user SET user_pass='" + $user_id + "' WHERE user_id='" + $_SESSION['userid'] + "'");
        echo "<meta http-equiv=\"refresh\" content=\"0; url=https://expense-submit-approve-reimburse-mhendren12.c9users.io/home.php\" />";
    }
}
    $user_id=$_POST['user_pass'];
    $n=new db();
    $n->connect();
    $n->insert($user_pass);

?>