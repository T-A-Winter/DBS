<?php
//hi
class DatabaseHelper
{
    // Since the connection details are constant, define them as const
    // We can refer to constants like e.g. DatabaseHelper::username
    const username = 'a12028429'; // use a + your matriculation number
    const password = 'dbs23'; // use your oracle db password
    const con_string = 'oracle19.cs.univie.ac.at:1521/orclcdb';  //on almighty "lab" is sufficient

    // Since we need only one connection object, it can be stored in a member variable.
    // $conn is set in the constructor.
    protected $conn;

    // Create connection in the constructor
    public function __construct()
    {
        try {
            // Create connection with the command oci_connect(String(username), String(password), String(connection_string))
            // The @ sign avoids the output of warnings
            // It could be helpful to use the function without the @ symbol during developing process
            $this->conn = oci_connect(
                DatabaseHelper::username,
                DatabaseHelper::password,
                DatabaseHelper::con_string
            );

            //check if the connection object is != null
            if (!$this->conn) {
                // die(String(message)): stop PHP script and output message:
                die("DB error: Connection can't be established!");
            }

        } catch (Exception $e) {
            die("DB error: {$e->getMessage()}");
        }
    }

    // Used to clean up
    public function __destruct()
    {
        // clean up
        oci_close($this->conn);
    }
    //https://www.php.net/manual/de/function.oci-bind-by-name.php
    public function getRichestCharacters($limit) {
        $sql = "SELECT *
            FROM richest_player_character
            ORDER BY gold DESC
            FETCH FIRST :limit ROWS ONLY";
        $statement = oci_parse($this->conn, $sql);
        oci_bind_by_name($statement, ":limit", $limit, -1, SQLT_INT);
        oci_execute($statement);
        oci_fetch_all($statement, $res, 0, 0, OCI_FETCHSTATEMENT_BY_ROW);
        return $res;
    }

    public function gethighestLevelPartys($limit){
        $sql = "SELECT * 
            FROM end_game_party
            ORDER BY average_level DESC
            FETCH FIRST :limit ROWS ONLY";
        $statement = oci_parse($this->conn, $sql);
        oci_bind_by_name($statement, ":limit", $limit, -1, SQLT_INT);
        oci_execute($statement);
        oci_fetch_all($statement, $res, 0, 0, OCI_FETCHSTATEMENT_BY_ROW);
        return $res;
    }

    public function getRichestPartys($limit){
        $sql = "SELECT * 
            FROM party_gold_summary
            WHERE total_gold IS NOT NULL
            ORDER BY total_gold DESC
            FETCH FIRST :limit ROWS ONLY";
        $statement = oci_parse($this->conn, $sql);
        oci_bind_by_name($statement, ":limit", $limit, -1, SQLT_INT);
        oci_execute($statement);
        oci_fetch_all($statement, $res, 0, 0, OCI_FETCHSTATEMENT_BY_ROW);
        return $res;
    }

    public function selectPlayer($userName){
        $sql = "SELECT * FROM player
            WHERE upper(user_name) LIKE upper(:userName)";
            
        $statement = oci_parse($this->conn, $sql);
        oci_bind_by_name($statement, ":userName", $userName);
        oci_execute($statement);
        oci_fetch_all($statement, $res, 0, 0, OCI_FETCHSTATEMENT_BY_ROW);
        oci_free_statement($statement);
        return $res;
    }

    public function selectDungeonMaster($userName){
        //$sql = "SELECT * FROM dungeon_master
            //WHERE upper(user_name) LIKE upper('%{$userName}%')";

        $sql = "SELECT * 
            FROM dungeon_master
            WHERE upper(user_name)
            LIKE upper(:userName)";

        $statement = oci_parse($this->conn, $sql);
        oci_bind_by_name($statement, ":userName", $userName);
        oci_execute($statement);
        oci_fetch_all($statement, $res, 0, 0, OCI_FETCHSTATEMENT_BY_ROW);
        oci_free_statement($statement);
        return $res;
    }

    //is never called from outside
    private function getDungeonMasterId($userName){
        $sql = "SELECT dungeon_master_id
            FROM dungeon_master 
            WHERE user_name = '{$userName}'";
        $statement = oci_parse($this->conn, $sql);
        oci_execute($statement);
        oci_fetch_all($statement, $res, 0, 0, OCI_FETCHSTATEMENT_BY_ROW);
        #echo "$sql";
        return $res;
    }

    //is never called from outside
    private function getAdventureId($adventure){
        $sql = "SELECT adventure_id
            FROM adventure
            WHERE name = '{$adventure}'";
        
        $statement = oci_parse($this->conn, $sql);
        oci_execute($statement);
        oci_fetch_all($statement, $res, 0, 0, OCI_FETCHSTATEMENT_BY_ROW);
        //echo "HII {$res[0]['adventure_id']}";
        //echo "$sql";
        return $res;
    }

    private function insertIntoRuns($dungeonMasterId, $adventureId){
        $sql = "INSERT INTO runs (dungeon_master, adventure) VALUES ('{$dungeonMasterId}', '{$adventureId}')";

        $statement = oci_parse($this->conn, $sql);
		$success = oci_execute($statement) && oci_commit($this->conn);
        oci_free_statement($statement);

        #echo "Inserted into RUNS: {$success}";
        return $success;
    }

    private function insertIntoAdventure($adventure, $recommendedLevel){
        if (isset($recommendedLevel)){
            $sql = "INSERT INTO 
                adventure (name, recommended_level) 
                VALUES (:adventure, :recommendedLevel)";
        } else {
            $sql = "INSERT INTO adventure (name) VALUES ('{$adventure}')";
        }
        $statement = oci_parse($this->conn, $sql);

        oci_bind_by_name($statement, ':adventure', $adventure);
        if (isset($recommendedLevel)){
            oci_bind_by_name($statement, ':recommendedLevel', $recommendedLevel);
        }

       
		$success = oci_execute($statement) && oci_commit($this->conn);
        oci_free_statement($statement);

        return $success;
    }

    public function insertIntoDungeonMaster($userName, $email, $adventure, $recommendedLevel){

        $sql = "INSERT INTO dungeon_master (user_name, e_mail) VALUES (:userName, :email)";
        $statement = oci_parse($this->conn, $sql);
        oci_bind_by_name($statement, ':userName', $userName);
        oci_bind_by_name($statement, ':email', $email);
        $success = oci_execute($statement) && oci_commit($this->conn);
        oci_free_statement($statement);



        $dmIdArray = $this->getDungeonMasterId($userName);
        $dmId = !empty($dmIdArray) ? $dmIdArray[0]['DUNGEON_MASTER_ID'] : null;

        $advId = null;
        if (isset($adventure)){
            $success = $this->insertIntoAdventure($adventure, $recommendedLevel);

            $advIdArray = $this->getAdventureId($adventure);
            $advId = !empty($advIdArray) ? $advIdArray[0]['ADVENTURE_ID'] : null;
        }

        if (!empty($dmId) && !empty($advId)){
            $success = $this->insertIntoRuns($dmId, $advId);
        }

        return $success;
    }

    public function insertIntoPlayer($userName, $email){
        if(isset($email) && !empty($email)){
            $sql = "INSERT INTO player (user_name, e_mail) VALUES (:userName, :email)";
        }else{
            $sql = "INSERT INTO player (user_name) VALUES (:userName)";
        }
        $statement = oci_parse($this->conn, $sql);
        oci_bind_by_name($statement, ':userName', $userName);
        if (isset($email) && !empty($email)){
            oci_bind_by_name($statement, ':email', $email);
        }
        $success = oci_execute($statement) && oci_commit($this->conn);
        oci_free_statement($statement);
        return $success;
    }

    public function deletePlayer($userName){
        $errorcode = 0;
        $sql = "DELETE FROM player WHERE user_name = :userName";
        $statement = oci_parse($this->conn, $sql);
        oci_bind_by_name($statement, ':userName', $userName);
        oci_execute($statement);
        oci_free_statement($statement);
        return $errorcode;
    }

    private function getPlayerEmail($userName){
        $sql = "SELECT e_mail 
            FROM player
            WHERE user_name = ':userName";
        $statement = oci_parse($this->conn, $sql);
        oci_bind_by_name($statement, ':userName', $userName);
        oci_execute($statement);
        oci_fetch_all($statement, $res, 0, 0, OCI_FETCHSTATEMENT_BY_ROW);
        return $res;
    }

    public function updateDungeonMaster($newUserName, $oldUserName, $newEmail){
        if(isset($newEmail)){
            $sql = "UPDATE dungeon_master
                SET e_mail = :newEmail
                WHERE user_name = :oldUserName";
            $statement = oci_parse($this->conn, $sql);
            oci_bind_by_name($statement, ':newEmail', $newEmail);
            oci_bind_by_name($statement, ':oldUserName', $oldUserName);
            $success = oci_execute($statement) && oci_commit($this->conn);
            oci_free_statement($statement);
        }
        $errorcode = 0;
        $sql = "UPDATE dungeon_master
            SET user_name = :newUserName
            WHERE user_name = :oldUserName";
        $statement = oci_parse($this->conn, $sql);
        oci_bind_by_name($statement, ':newUserName', $newUserName);
        oci_bind_by_name($statement, ':oldUserName', $oldUserName);
        $success = oci_execute($statement) && oci_commit($this->conn);
        oci_free_statement($statement);
        return $success;
    }

    public function updatePlayer($newUserName, $oldUserName, $newEmail){
        //echo"from updatePlayer, {$newUserName}, {$oldUserName}, {$newEmail}, \n";
        if(isset($newEmail)){
            //$oldEmailArray = this->getPlayerEmail($userName);
            //$oldEmail = !empty($oldEmailArray)[0]['E_MAIL'] : null;
            $sql = "UPDATE player
                SET e_mail = :newEmail
                WHERE user_name = :oldUserName";
            $statement = oci_parse($this->conn, $sql);
            oci_bind_by_name($statement, ':newEmail', $newEmail);
            oci_bind_by_name($statement, ':oldUserName', $oldUserName);
            $success = oci_execute($statement) && oci_commit($this->conn);
            oci_free_statement($statement);
        }

        $errorcode = 0;
        $sql = "UPDATE player
            SET user_name = :newUserName
            WHERE user_name = :oldUserName";
        
        $statement = oci_parse($this->conn, $sql);
        oci_bind_by_name($statement, ':newUserName', $newUserName);
        oci_bind_by_name($statement, ':oldUserName', $oldUserName);
        $success = oci_execute($statement) && oci_commit($this->conn);
        oci_free_statement($statement);
        return $success;
    }


    private function deleteAdventuresRunsTable($dmId){
        $sql = "DELETE FROM runs WHERE dungeon_master = {$dmId}";
        $statement = oci_parse($this->conn, $sql);
        oci_execute($statement);
        oci_free_statement($statement);
        //return $errorcode;
    }

    public function deleteDungeonMaster($userName){
        // need to delete any adventures from runs table
        $dmIdArray = $this->getDungeonMasterId($userName);
        $dmId = !empty($dmIdArray) ? $dmIdArray[0]['DUNGEON_MASTER_ID'] : null;
        $this->deleteAdventuresRunsTable($dmId);

        $sql = "DELETE FROM dungeon_master WHERE user_name = :userName";
        $statement = oci_parse($this->conn, $sql);
        oci_bind_by_name($statement, ':userName', $userName);
        oci_execute($statement);
        
        oci_free_statement($statement);
        return $errorcode;
    }
    
}