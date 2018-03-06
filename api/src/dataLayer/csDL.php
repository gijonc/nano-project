<?php
require_once $ROOT_PATH . '../src/config/config.php';

class csDL{
    private $table_name = "Company_Settings";
    private $conn = null;
    private $ID;           

    // constructor with $db as database connection
    public function __construct(){
        $db = new Database();
        $this->conn = $db->connect();
        // date_default_timezone_set('America/Los_Angeles');
    }

    private function getID($id){
        return (int)$id;
    }
//****************************************************************************************

    public function read () {
        // SQL statements
        $query = "SELECT * FROM ".$this->table_name." ";
        
        $stmt = $this->conn->prepare($query);
    
        $stmt->execute();
    
        $count = $stmt->rowCount();

        // check if more than 0 record found
        if($count>0){
            $company_settings_arr = array();
            $company_settings_arr["company_settings"]=array();

            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                extract($row);

                $item=array(
                    "ID"		    		=> $ID,
                    "Company_Code"		    => $Company_Code,
                    "Company"		    	=> $Company,
                    "Company_Chinese_Name" 	=> $Company_Chinese_Name,
                    "Company_Address1"	   	=> $Company_Address1,
                    "Company_Address2"    	=> $Company_Address2,
                    "Company_Address3"	   	=> $Company_Address3,
                    "Contact_Person"    	=> $Contact_Person,
                    "Contact_Person_eMail"	=> $Contact_Person_eMail,
                    "Contact_Person_Tel"	=> $Contact_Person_Tel,
                    "Company_Logo_Path"	    => $Company_Logo_Path,
                    "Remarks"		    	=> $Remarks,
                    "YearEnd_Month"		    => $YearEnd_Month,
                    "CurrentYear"		    => $CurrentYear,
                    "Responsible"		    => $Responsible,
                    "CI_Date"		    	=> $CI_Date,
                    "BR_Number"		    	=> $BR_Number
                );
                array_push($company_settings_arr["company_settings"], $item);
            }
            return json_encode($company_settings_arr);

        } else {
            echo json_encode( array("message" => "No products found.") );
        }
    }



//****************************************************************************************

    public function create($data) {
        // $getMaxIdQuery = ""
        $query = "INSERT INTO 
                    " . $this->table_name . " 
                SET
                    ID=:ID,
                    Company_Code=:Company_Code,
                    Company=:Company,
                    Company_Chinese_Name=:Company_Chinese_Name, 
                    Company_Address1=:Company_Address1, 
                    Company_Address2=:Company_Address2, 
                    Company_Address3=:Company_Address3, 
                    Contact_Person=:Contact_Person, 
                    Contact_Person_Tel=:Contact_Person_Tel, 
                    Contact_Person_eMail=:Contact_Person_eMail,
                    Company_Logo_Path=:Company_Logo_Path, 
                    Remarks=:Remarks, 
                    YearEnd_Month=:YearEnd_Month, 
                    CurrentYear=:CurrentYear, 
                    Responsible=:Responsible, 
                    CI_Date=:CI_Date, 
                    BR_Number=:BR_Number"
                ;


        if($stmt = $this->conn->prepare($query)){
            $stmt->bindParam(":ID", $this->getID("88"));
            $stmt->bindParam(":Company_Code",  $data->Company_Code);
            $stmt->bindParam(":Company",  $data->Company);
            $stmt->bindParam(":Company_Chinese_Name",  $data->Company_Chinese_Name);
            $stmt->bindParam(":Company_Address1",  $data->Company_Address1);
            $stmt->bindParam(":Company_Address2", $data->Company_Address2);
            $stmt->bindParam(":Company_Address3",  $data->Company_Address3);
            $stmt->bindParam(":Contact_Person",  $data->Contact_Person);
            $stmt->bindParam(":Contact_Person_eMail",  $data->Contact_Person_eMail);
            $stmt->bindParam(":Contact_Person_Tel",  $data->Contact_Person_Tel);
            $stmt->bindParam(":Company_Logo_Path",  $data->Company_Logo_Path);
            $stmt->bindParam(":Remarks",  $data->Remarks);
            $stmt->bindParam(":YearEnd_Month",  $data->yearEnd_month);
            $stmt->bindParam(":CurrentYear",  date("Y"));
            $stmt->bindParam(":Responsible",  $data->Responsible);
            $stmt->bindParam(":CI_Date",  $data->cur_time);
            $stmt->bindParam(":BR_Number",  $data->BR_Number);

            if($stmt->execute()){
                return true;
            }
        }
        return false;
    }

//****************************************************************************************

    public function update($data) {

        $query = "UPDATE 
                    " . $this->table_name . " 
                SET
                    Company_Code=:Company_Code,
                    Company=:Company, 
                    Company_Chinese_Name=:Company_Chinese_Name, 
                    Company_Address1=:Company_Address1, 
                    Company_Address2=:Company_Address2, 
                    Company_Address3=:Company_Address3, 
                    Contact_Person=:Contact_Person, 
                    Contact_Person_Tel=:Contact_Person_Tel, 
                    Contact_Person_eMail=:Contact_Person_eMail,
                    Company_Logo_Path=:Company_Logo_Path, 
                    Remarks=:Remarks, 
                    YearEnd_Month=:YearEnd_Month, 
                    CurrentYear=:CurrentYear, 
                    Responsible=:Responsible, 
                    CI_Date=:CI_Date, 
                    BR_Number=:BR_Number
                WHERE
                    ID = :ID"; 

        if ($stmt = $this->conn->prepare($query)) {

            $stmt->bindParam(":ID", $this->getID($data->ID));
            $stmt->bindParam(":Company_Code",  $data->Company_Code);
            $stmt->bindParam(":Company",  $data->Company);
            $stmt->bindParam(":Company_Chinese_Name",  $data->Company_Chinese_Name);
            $stmt->bindParam(":Company_Address1",  $data->Company_Address1);
            $stmt->bindParam(":Company_Address2", $data->Company_Address2);
            $stmt->bindParam(":Company_Address3",  $data->Company_Address3);
            $stmt->bindParam(":Contact_Person",  $data->Contact_Person);
            $stmt->bindParam(":Contact_Person_eMail",  $data->Contact_Person_eMail);
            $stmt->bindParam(":Contact_Person_Tel",  $data->Contact_Person_Tel);
            $stmt->bindParam(":Company_Logo_Path",  $data->Company_Logo_Path);
            $stmt->bindParam(":Remarks",  $data->Remarks);
            $stmt->bindParam(":YearEnd_Month",  $data->yearEnd_month);
            $stmt->bindParam(":CurrentYear",  date("Y"));
            $stmt->bindParam(":Responsible",  $data->Responsible);
            $stmt->bindParam(":CI_Date",  $data->cur_time);
            $stmt->bindParam(":BR_Number",  $data->BR_Number);

            if($stmt->execute()){
                return true;
            }
            $stmt->close();
        }
        return false;

    }

//****************************************************************************************

    public function delete($data) {
        $query = "DELETE FROM 
                    " . $this->table_name . " 
                WHERE ID = :ID";

        if ($stmt = $this->conn->prepare($query)) {

            $stmt->bindParam(":ID",  $this->getID($data->ID));
            
            if($stmt->execute()){

                return true;
            }
            $stmt->close();
        }
        return false;
    }


};

?>
