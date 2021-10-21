<?php
	class DBquery {	
		private static $connect;

		//Run db connection 
		public function __construct(){
			self::$connect = Database::dbConnection();
		}

		//Grad rows based on a double condition
		public static function customQuery($query, $type){
			try	{
				$stmt = Database::dbConnection()->prepare("$query");
				$stmt->execute();
			}
			catch(PDOException $e){
				echo $e->getMessage();
			}
			
			if($type == 'Single'){
				$matches = $stmt->fetch(PDO::FETCH_ASSOC);
				if ($matches === false) return $matches;
				return $matches;				
			}
			elseif($type == 'All'){
				$matches = $stmt->fetchAll(PDO::FETCH_ASSOC);
				if ($matches === false) return $matches;
				return $matches;
			}
			elseif($type == 'Update'){
				return true;
			}
			elseif($type == 'Insert'){
				$insertID = Database::dbConnection()->lastInsertId();
				return $insertID;
			}
		}

	}
?>