<?php
        try {
            $cMonth= date("F");
            $cYear= date("Y");

            $q = "SELECT * FROM tbl_products ORDER BY id DESC ";
            $query = $db->prepare($q);
            $query->execute();
            if ($query->rowCount() > 0) {
                $p_result = $query->fetchAll(PDO::FETCH_ASSOC);
                //$p_count = $p_result->rowCount();
//insert code for rowCount to var
            } else { $p_result=null ;}
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
		//$count = $stmt->rowCount();
?>