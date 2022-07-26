<?php
if (!isset($_SESSION)) {
    session_start();
}
require_once 'dbconfig.php';
class USER
{
    private $conn;
    public function __construct()
    {
        $database = new Database();
        $db = $database->dbConnection();
        $this->conn = $db;
        //
        $this->currentYear = date("Y");
        $this->currentMonth = date("F");
        $this->currentDay = date("l");
        //set default site title
        $this->siteName = "XXV OnPoint";
        $this->siteTitle = "XX%";
        $this->siteAddress1= "#25, Osuntokun Avenue, Bodija,";
        $this->siteAddress2= "Ibadan North, Ibadan";
        $this->siteCountry= "Nigeria";
        $this->siteEmail= "info@onpoint.com";
        $this->siteEmailOther= "onpoint@gmail.com";
        $this->siteTel= "+234 8027711648";
        $this->siteTelOther= "+234 8168239441";
        //
        // $this->siteIcon = "images/site/siteicon.ico";
        $this->siteIcon = "assets/img/favicon.jpg";
        $this->siteDescription ="";
        $this->siteKeywords ="Nigeria";
        //
 //
    }
    
public function read_more($string)
    {
      // strip tags to avoid breaking any html
        $string = strip_tags($string);
        if (strlen($string) > 30) {

            // truncate string
            $stringCut = substr($string, 0, 30);
            $endPoint = strrpos($stringCut, ' ');

            //if the string doesn't contain any space then it will cut without word basis.
            $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
            $string .= '...';
        }
        return $string;
    }
    
    public function runQuery($sql)
    {
        $stmt = $this->conn->prepare($sql);
        return $stmt;
    }
    public function lasdID()
    {
        $stmt = $this->conn->lastInsertId();
        return $stmt;
    }
    public function register($username, $hash_password, $phone, $cust_status, $cust_id)
    {
        try {
            $stmt = $this->conn->prepare("INSERT INTO tbl_customer (custName,custPass,custTel,custStatus)
                                                VALUES(:custName, :custPass,:custTel, :custStatus)");
            $stmt->bindparam(":custName", $username);
            $stmt->bindparam(":custPass", $hash_password);
            $stmt->bindparam(":custTel", $phone);
            $stmt->bindparam(":custStatus", $cust_status);
            //$stmt->bindparam(":custID", $cust_id);
            if ($stmt->execute()) {
                $newID=$this->lasdID();
                $_SESSION['cust_id']=$newID;
                $data['newID'] = $newID;
                $data['register'] = "success";
                $data['register_msg'] = "You have successfully registered.";

                echo json_encode($data);
                
                
                
                
                
                
                
                
                
                
                return ;
            }
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
    public function login($email, $upass)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM tbl_customer WHERE custEmail=:email_id");
            $stmt->execute(array(":email_id" => $email));
            $userRow = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($stmt->rowCount() == 0) {
                $_SESSION['userSession'] = $userRow['custEmail'];
                return false;
            }
            if ($stmt->rowCount() == 1) {
                if ($userRow['custPass'] == $upass) {
                    $_SESSION['userSession'] = $userRow['custEmail'];
                    return true;
                } else {
                    header("Location: signin.php?error=password");
                    exit;
                }
            } else {
                header("Location: signin.php?user=inactive");
                exit;
            }
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
    public function is_logged_in()
    {
        if (isset($_SESSION['cust_id'])) {
            return true;
        }
    }
    public function redirect($url)
    {
        header("Location: $url");
    }
    public function logout()
    {
        session_destroy();
    }
//
    public function createTableName($length)
    {
        $firstLetter=1;
        $createCode = '';
        $characters = 'BCDFGHJKLMNPRSTWY';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $firstLetter; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        $firstLetter = $randomString;
        //
        $ndLetter=1;
        $createCode = '';
        $characters = 'aaaaaaaiiiiiiieeeeeeoooooouuaaaaaaaiiiiiiieeeeeeoooooouu';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $ndLetter; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        $ndLetter = $randomString;
        //
        $createCode = '';
        $characters = 'aaaaaaaaabcdeeeeeeeeefghiiiiiiiiijklmnoooooooooprssstuuuuwy';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        $createCode = $randomString;
        
        
        
        return $firstLetter.$ndLetter.$createCode;
    }
    
    //
    public function wcartTotal($cust_id)
    {
        $total_cart = $this->conn->query("SELECT count(1) FROM tbl_cust_cart WHERE id ='$cust_id' ")->fetchColumn();
        return $total_cart;
    }

    public function get_time_ago($time)
    {
        $ntime=strtotime($time) ;
        $time_difference = time() - $ntime;

        if ($time_difference < 1) {
            return 'less than 1s';
        }
        $condition = array(
                12 * 30 * 24 * 60 * 60 =>  'y',
                30 * 24 * 60 * 60       =>  'm',
                24 * 60 * 60            =>  'd',
                60 * 60                 =>  'h',
                60                      =>  'm',
                1                       =>  's'
            );

        foreach ($condition as $secs => $str) {
            $d = $time_difference / $secs;

            if ($d >= 1
            ) {
                $t = round($d);
                //return 'about ' . $t . ' ' . $str . ($t > 1 ? 's' : '') . ' ago';
                //  return $t . ' ' . $str . ($t > 1 ? 's' : '') . '';
                return $t . ' ' . $str . ($t > 1 ? '' : '') . '';
            }
        }
    }
//












    public function check_cartid()
    {
        if (isset($_SESSION['cart_id'])) {
            $cart_id=$_SESSION['cart_id'];

            $_SESSION['cart_id']=null;
            $_SESSION['table_name']=null;
            $cart_id= $this->createCode(8);
            $_SESSION['cart_id']=$cart_id;

            return $cart_id;
        }
    }
    //
    public function getUserData($cust_id)
    {
        $stmt = $this->conn->query("SELECT * FROM tbl_customer WHERE id=$cust_id");
        //      $stmt->execute(array(":reg_check"=>$cust_id));
        $stmt->execute();
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);
        return $userData;
        //
    }
    //
    public function getClientName($cust_id)
    {
        $stmt = $this->conn->query("SELECT id, custName FROM tbl_customer WHERE id=$cust_id");
        $stmt->execute();
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);
        $name=$userData['custName'];
        return $name;
    }
    //
    public function getClientPhone($cust_id)
    {
        $stmt = $this->conn->query("SELECT id, custTel FROM tbl_customer WHERE id=$cust_id");
        $stmt->execute();
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);
        $phone=$userData['custTel'];
        return $phone;
    }    /// getting various totals
    public function get_total_msgs($cust_email)
    {
        $total_msgs = $this->conn->query("SELECT count(1) FROM tbl_messages WHERE cust_email ='$cust_email' ")->fetchColumn();
        echo $total_msgs;
    }
    //
    public function get_total_products()
    {
        $total_products = $this->conn->query("SELECT count(1) FROM tbl_products  ")->fetchColumn();
        return $total_products;
    }
    //
    public function get_total_from_cat($selector)
    {
        $total_products = $this->conn->query("SELECT count(1) FROM tbl_products WHERE category ='$selector' ")->fetchColumn();
        return $total_products;
        //
    }
    //
    public function getProdName($prod_id)
    {
        $stmt = $this->conn->query("SELECT * FROM tbl_products WHERE id={$prod_id} ");
        $stmt->execute();
        //$stmt->execute(array(":reg_check"=>$prod_id));
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);
		$prod_name=$userData['prod_name'];
        return $prod_name;
        //
    }
    //
    public function get_twaitercart($id)
    {
        $total_cart = $this->conn->query("SELECT count(1) FROM tbl_cust_cart WHERE waiter_id ='$id' ")->fetchColumn();
        return $total_cart;
    }
    //
    public function get_total_cart($id)
    {
        $total_cart = $this->conn->query("SELECT count(1) FROM tbl_cust_cart WHERE cust_id ='$id' ")->fetchColumn();
        return $total_cart;
    }
    //
    public function get_current_cart($cust_id, $cart_id)
    {
        $total_cart = $this->conn->query("SELECT count(1) FROM tbl_cust_cart WHERE cust_id ='$cust_id' AND cart_id='$cart_id' AND cart_stat='y' ")->fetchColumn();
        // $total_cart = $this->conn->query("SELECT count(1) FROM tbl_cust_cart WHERE cust_id='$cust_id' ")->fetchColumn();
        return $total_cart;
    }
    //
    public function getCartLabel($cid)
    {
        $stmt = $this->conn->query("SELECT id,cart_id,label FROM tbl_cust_cart WHERE cart_id='$cid' ");
        $stmt->execute(array(":reg_check"=>$cid));
        $cartData = $stmt->fetch(PDO::FETCH_ASSOC);
        $thelabel=$cartData['label'];
        if ($thelabel=="") {
            $thelabel="Guest";
        }
        return $thelabel;
    }
    //
    public function getCartTlabel($id)
    {
        $stmt = $this->conn->query("SELECT id,cart_id,label FROM tbl_cust_cart WHERE id='$id' ");
        //$stmt->execute(array(":reg_check"=>$cid));
        $stmt->execute();
        $cartData = $stmt->fetch(PDO::FETCH_ASSOC);
        $thelabel=$cartData['label'];
        if ($thelabel=="") {
            $thelabel="Guest";
        }
        return $thelabel;
    }
    //
    public function get_user_cart($table_name, $client_name)
    {
        $total_cart = $this->conn->query("SELECT count(1) FROM tbl_cust_cart WHERE label='{$table_name}' AND tlabel='{$client_name}' AND dev_stat!='Closed' ")->fetchColumn();
        // $total_cart = $this->conn->query("SELECT count(1) FROM tbl_cust_cart WHERE cust_id='$cust_id' ")->fetchColumn();
        
        return $total_cart;
    }

    //
    public function accountCode($length)
    {
        $accountCode = '';
        $characters = '01234567890123456789ABCDEFGHIJKLMNOPQRSTUVWQYZ01234567890123456789';
        //   $characters = '0123456789012345678901234567890123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        $accountCode = $randomString;
        //if (isset($accountCode)) {
        // $_SESSION["accountCode"] = $accountCode;
        // }
        //  echo $accountCode;
        return $accountCode;
    }
    public function create_cart_id($length)
    {
        $createCode = '';
        $characters = '01234567890123456789ABCDEFGHIJKLMNOPQRSTUVWQYZ01234567890123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        $createCode = $randomString;
        return $createCode;
    }

    
    //
    public function getCurrentYear()
    {
        $currentYear = date("Y"); // formating for web display
        echo $currentYear;
    }
//

//
    public function fmtCurDisp($toformat)
    {
        $toformatn = "&#8358; " . number_format($toformat); // formating for web display
        echo $toformatn;
    }
    public function fmtCur($toformat)
    {
        $toformatn = "&#8358; " . number_format($toformat); // formating for web display
        echo $toformatn;
    }
//
    public function getProdInfo($prod_cat)
    {
        try {
            $stmt = $this->conn->query("SELECT * FROM tbl_products WHERE prod_cat='$prod_cat'");
            //      $stmt->execute(array(":reg_check"=>$cust_id));
            $stmt->execute();
            $prod_result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
        return $prod_result;
    }
//



//
}
