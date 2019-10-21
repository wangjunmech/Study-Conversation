<?php
class MYPDO
{
    private static $object;
    private $PDO;
    private $prepare;
 
    /////单例模式 start
    private function __construct()
    {

    } 
    public static function newClass()
    {
        if(!(self::$object instanceof self))
        {
            self::$object = new self;
        }
        return self::$object;
    }
 
    public function __clone(){
        trigger_error('Clone is not allow!',E_USER_ERROR);
    }
    //////单例模式 end
 
    //连接pdo
    public function pdoConnect($address)
    {
        try{
            $this->PDO = new PDO($address[0],$address[1],$address[2]);
            $this->PDO->setAttribute(PDO::ATTR_PERSISTENT,true);
            //设置抛出错误
            $this->PDO->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            //设置当字符串为空时转换为sql的null
            $this->PDO->setAttribute(PDO::ATTR_ORACLE_NULLS,true);
            //由MySQL完成变量的转义处理
            $this->PDO->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        }catch (PDOException $e)
        {
          $this->Msg("PDO连接错误信息：".$e->getMessage());
        }
    }
 
    //错误提示
    private function Msg($the_error=""){
        $html="<html>
                  <head>
                    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'/>
                    <title>mysql error</title>
                  </head>
                  <body>
                    <div style='width: 50%; height: 200px; border: 1px solid red; font-size: 12px;'>
                       $the_error
                    </div>
                  </body>
               </html>
               ";
        echo $html;
        exit;
    }

    //自定义方法
    // public function sqlrun($sql){      
    //   $stmt = $this->PDO->prepare($sql); 
    //   $result = $stmt->execute();
    //   return $result;
    // }
 
    /*
     *
     * insert,delete,update操作
     *
     * */
    public function insert($table,$row)
    {
       $sql=$this->sqlCreate("insert",$table,$row);
       $result = $this->sqlExec($sql);
    }
 
    public function update($table,$row,$where)
    {
        $sql=$this->sqlCreate("update",$table,$row,$where);
        $result = $this->sqlExec($sql);
    }
 
    public function delete($table,$where)
    {
        $sql=$this->sqlCreate("delete",$table,"",$where);
        $result = $this->sqlExec($sql);
    }
 
    //服务与insert,update,delete，生成sql
    private function sqlCreate($action,$table,$row="",$where="")
    {
        $actionArr = array(
            "insert" => "insert into ",
            "update" => "update ",
            "delete" => "delete from "
        );
        $row = empty($row) ? "": $this->rowCreate($row);
        $where = empty($where) ? "":" where ".$where;
        $sql = $actionArr[$action].$table.$row.$where;
        return $sql;
    }
 
    //拼成row
    private function rowCreate($row)
    {
       $sql_row=" set";
       foreach($row as $key=>$val)
       {
          $sql_row.=" ".$key."='".$val."',";
       }
       return trim($sql_row,",");
    }
 
 
    //执行sql，返还影响行数
    private function sqlExec($sql)
    {
         try{
              $result=$this->PDO->exec($sql);
          }catch (PDOException $e)
          {
              $this->Msg($e->getMessage());
          }
         return $result;
    }
 
    //获取insert插入的id
    public function lastinsertid()
    {
       return $this->PDO->lastinsertid();
    }
 
  /*
   *
   * select 部分
   * */
    public function select($table,$fields="", $where="",$orderby="", $sort="",$limit="")
    {
        $fields = empty($fields) ? "*":$fields;
        $sqlSelect=$this->sqlCreateSelect($table,$fields,$where,$orderby,$sort,$limit);
        // echo $sqlSelect;
        $this->query($sqlSelect,$where);
        
    }
 
    //生成select sql
    private  function sqlCreateSelect($table,$fields="*", $where="",$orderby="", $sort="",$limit="")
    {
              // echo 'WWWWWWWWWWWWWWWWWWWWWWWWWWWWWWW';

        $whereSql = empty($where)? " 1=1 ":$this->whereCreate($where);
        $orderbySql = empty($orderby)? "":" order by ".$orderby." ".$sort;
        $limitSql = empty($limit)? "":" limit ".$limit;
        $sql="select $fields from $table where ".$whereSql.$orderbySql.$limitSql;
        // echo $sql;
        return $sql;
    }
 
    private function whereCreate($where)
    {
      $whereSql="";
      foreach($where as $key=>$val)
      {
         $whereSql.$key."=:".$key." and";
      }
      return $whereSql." 1=1 ";
    }
 
    //执行select sql
    public function query($sql,$where)
        {
       try{
           $this->prepare = $this->PDO->prepare($sql);
           // var_dump($sql);
           // die();
 
       }catch (PDOException $e)
       {
           $this->Msg("预处理sql出错信息:".$e->getMessage()."<br>sql:(".$sql.")");
       }
       empty($where)? "":$this->bind($where);
       $this->prepare->execute();
    }
    private function bind($where)
    {
        foreach($where as $key=>$val)
        {
            $this->prepare->bindValue(":".$key,$val);
        }
    }
 
    /*select获取数据*/
    //获取一条
    public function selectOne()
    {
        $result=$this->prepare->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    //获取全部数据
    public function selectAll()
    {
        $result=$this->prepare->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
     //获取查询记录数
    public function selectCount()
    {
        $total = $this->prepare->rowCount();
        return $total;
    }
 
}

// $pdo=array("mysql:host=localhost;dbname=demo;charset=utf8","root","");
// //开始连接数据库
// $db = Mysql::newClass();
// $db->pdoConnect($pdo);
 
 
// $updateRow = array(
//     "user_id" => "2",
//     "meta_key" => "username"
// );
 
//$db->select("wp_usermeta"); //发送sql
//$result=$db->selectOne(); //获取一条数据
//$db->selectCount(); //获取全部
 
//$db->update("wp_usermeta",$updateRow,"umeta_id=1"); //更新信息
//$db->insert("wp_usermeta",$updateRow); //插入数据
//echo $db->lastinsertid(); //获取插入后的id
//$db->delete("wp_usermeta","umeta_id>18"); //删除数据*/


// $db->insert("career",$data); //向表中插入数组
// echo $db->lastinsertid(); //返回受影响的行数
// $sql = 'select * from career';
// $arr= $db->select('feedback',"id<100");
// $arr=$db->selectCount();
// $db->select("career"); //发送sql
// $result=$db->selectOne(); //获取一条数据
// $db->selectCount(); //获取全部
// $db->select("feedback"); //发送sql
// $result=$db->selectAll(); //获取全部