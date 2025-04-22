<?php
namespace controllers;
use Aura\SqlQuery\QueryFactory;
use PDO;
class QueryBuilder{
   private $pdo;
   private $queryFactory;
    

    public function __construct()
    {
       $this->pdo = new PDO('mysql:host=MySQL-8.0;dbname=data',"root","");
       $this->queryFactory=new QueryFactory('mysql');
    }

    public function getAll(){
        global $pdo;
        $select = $this->queryFactory->newSelect();
        $select->cols(['*'])
        ->from('users'); 
        $sth = $this->pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }


public function update($data,$id,$table){
        
    $update = $this->queryFactory->newUpdate(); 
    $update
    ->table($table)                  // update this table
    ->cols($data)
    ->where('id = :id')           // AND WHERE these conditions
    ->bindValue('id', $id);
    $sth = $this->pdo->prepare($update->getStatement());
    $sth->execute($update->getBindValues());

    }

public function delete($id){
    global $pdo;
     $delete = $this->queryFactory->newDelete();
     $delete
    ->from('users')                   // FROM this table
    ->where('id = :id')           // AND WHERE these conditions
    ->bindValue('id', $id);
    $sth = $this->pdo->prepare($delete->getStatement());
    $sth->execute($delete->getBindValues());
    $sth->fetch(PDO::FETCH_ASSOC);
    }
     
       
       
public function getOne($table,$id){

        $select2 = $this->queryFactory->newSelect();
        $select2->cols(['*'])
       ->from($table)
       ->where('id = :id')
       ->bindValue('id',$id);
        $sth = $this->pdo->prepare($select2->getStatement());
        $sth->execute($select2->getBindValues());
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

public function get_user_by_id($id){
        global $pdo;
        $select2 = $this->queryFactory->newSelect();
        $select2->cols(['*'])
       ->from('users')
       ->where('id = :id')
       ->bindValue('id',$id);
        $sth = $this->pdo->prepare($select2->getStatement());
        $sth->execute($select2->getBindValues());
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        return $result;   
    }

    function get_user_by_email($email){
        global $pdo;
        $select2 = $this->queryFactory->newSelect();
        $select2->cols(['*'])
       ->from('users')
       ->where('email = :email')
       ->bindValue('id',$id);
        $sth = $this->pdo->prepare($select2->getStatement());
        $sth->execute($select2->getBindValues());
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        return $result;
        }
    

        public function insert($data,$table){

            $insert = $this->queryFactory->newInsert();
            $insert
            ->into($table)                   // INTO this table
            ->cols($data);
             $sth = $this->pdo->prepare($insert->getStatement());
             $sth->execute($insert->getBindValues());
            }

    public function add_user($email,$password){
    global $pdo;
    $insert = $this->queryFactory->newInsert();
    $insert
    ->into('users')                   // INTO this table
    ->cols($data);
     $sth = $this->pdo->prepare($insert->getStatement());
     $sth->execute($insert->getBindValues());


     $select2 = $this->queryFactory->newSelect();
     $select2->cols(['id'])
    ->from('users')
    ->where('email = :email')
    ->bindValue('id',$id);
     $sth = $this->pdo->prepare($select2->getStatement());
     $sth->execute($select2->getBindValues());
     $result = $sth->fetch(PDO::FETCH_ASSOC);
     return $result['id'];
    
    }
    
    function set_flash_message($name,$message){
    
        $_SESSION[$name]=$message;
    }
    function display_flash_message($name){
    
        echo $_SESSION[$name];
    }
    function redirect_to($path){
        header("location:/$path");
    }
    
    function login($email,$password){
        global $pdo;
        $select2 = $this->queryFactory->newSelect();
        $select2->cols(['id','email','roles','password'])
       ->from('users')
       ->where('email = :email','password = :password')
       ->bindValue('id',$id);
        $sth = $this->pdo->prepare($select2->getStatement());
        $sth->execute($select2->getBindValues());
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        $_SESSION['user']=$result;
        return $result;  
        
    } 
    
    function is_logged_in(){
    
        if(isset($_SESSION['user'])){
            return true;
        }
          else {
            return false;
        } 
        }
    
    function is_not_logged_in(){
        return !is_logged_in();
    }
    
   
    
    function get_authenticated_user(){
    
        if(is_logged_in()){
            return $_SESSION['user'];
        }
       else {
            return false;
        }
        
    }
    
    function is_admin($user){
    
        
          if($user['roles']==="admin"){
            return true;
          }
          else{
          return false;
        }
    
    }
    
    function is_equal($user, $current_user){
    
        return $user["id"]===$current_user["id"];
    }
    
    function edit_Information($username,$job_title,$phone,$address,$id){
    global $pdo;

    $update = $this->queryFactory->newUpdate(); 
    $update
    ->table('users')                  // update this table
    ->cols($username,$job_title,$phone,$address)
    ->where('id = :id')           // AND WHERE these conditions
    ->bindValue('id', $id);
    $sth = $this->pdo->prepare($update->getStatement());
    $sth->execute($update->getBindValues());
    $sth->fetch(PDO::FETCH_ASSOC); 
    }


    function set_status($status,$id){
    global $pdo;

    $update = $this->queryFactory->newUpdate(); 
        $update
        ->table('users')                  // update this table
        ->cols($status)
        ->where('id = :id')           // AND WHERE these conditions
        ->bindValue('id', $id);
        $sth = $this->pdo->prepare($update->getStatement());
        $sth->execute($update->getBindValues());
        $sth->fetch(PDO::FETCH_ASSOC); 

    }
    
    function upload_avatar($image,$id){
        global $pdo;

        $update = $this->queryFactory->newUpdate(); 
        $update
        ->table('users')                  // update this table
       // ->cols('img/demo/avatars/':$image)
       ->cols($image)
        ->where('id = :id')           // AND WHERE these conditions
        ->bindValue('id', $id);
        $sth = $this->pdo->prepare($update->getStatement());
        $sth->execute($update->getBindValues());
        $sth->fetch(PDO::FETCH_ASSOC);   
    
    }
    
    function add_social_links($telegram,$instagram,$vk,$id){
    global $pdo;

    $update = $this->queryFactory->newUpdate(); 
    $update
    ->table('users')                  // update this table
    ->cols($telegram,$instagram,$vk)
    ->where('id = :id')           // AND WHERE these conditions
    ->bindValue('id', $id);
    $sth = $this->pdo->prepare($update->getStatement());
    $sth->execute($update->getBindValues());
    $sth->fetch(PDO::FETCH_ASSOC);
    }
    
    function is_author($logged_user_id,$edit_user_id){
        if($logged_user_id===$edit_user_id){
            return true;
        }
        else{
            return false;
        }
    }
    
    
    
    function edit__info($username,$job_title,$phone,$address,$id){
    global $pdo;
         
    $update = $this->queryFactory->newUpdate(); 
    $update
    ->table('users')                  // update this table
    ->cols($username,$job_title,$phone,$address)
    ->where('id = :id')           // AND WHERE these conditions
    ->bindValue('id', $id);
    $sth = $this->pdo->prepare($update->getStatement());
    $sth->execute($update->getBindValues());
    $sth->fetch(PDO::FETCH_ASSOC);
    
    }
    
    function edit__credentials($email,$password,$id){
        global $pdo;

             
    $update = $this->queryFactory->newUpdate(); 
    $update
    ->table('users')                  // update this table
    ->cols($email,$password)
    ->where('id = :id')           // AND WHERE these conditions
    ->bindValue('id', $id);
    $sth = $this->pdo->prepare($update->getStatement());
    $sth->execute($update->getBindValues());
    $sth->fetch(PDO::FETCH_ASSOC);
    
    
    }    

}
?>