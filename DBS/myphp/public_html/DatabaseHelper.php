<?php

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

    public function getRichestCharacters($limit) {
        $sql = "SELECT *
            FROM richest_player_character
            ORDER BY gold DESC
            FETCH FIRST {$limit} ROWS ONLY";
        $statement = oci_parse($this->conn, $sql);
        oci_execute($statement);
        oci_fetch_all($statement, $res, 0, 0, OCI_FETCHSTATEMENT_BY_ROW);
        return $res;
    }

    public function gethighestLevelPartys($limit){
        $sql = "SELECT * 
            FROM end_game_party
            ORDER BY average_level DESC
            FETCH FIRST {$limit} ROWS ONLY";
        $statement = oci_parse($this->conn, $sql);
        oci_execute($statement);
        oci_fetch_all($statement, $res, 0, 0, OCI_FETCHSTATEMENT_BY_ROW);
        return $res;
    }

    public function getRichestPartys($limit){
        $sql = "SELECT * 
            FROM party_gold_summary
            ORDER BY total_gold DESC
            FETCH FIRST {$limit} ROWS ONLY";
        $statement = oci_parse($this->conn, $sql);
        oci_execute($statement);
        oci_fetch_all($statement, $res, 0, 0, OCI_FETCHSTATEMENT_BY_ROW);
        return $res;
    }

    public function selectPlayer($userName){
        $sql = "SELECT * FROM player
            WHERE user_name = '%{$userName}%'";
            
        $statement = oci_parse($this->conn, $sql);
        oci_execute($statement);
        oci_fetch_all($statement, $res, 0, 0, OCI_FETCHSTATEMENT_BY_ROW);
        oci_free_statement($statement);
        return $res;
    }

    public function getDungeonMasterId($userName){
        $sql = "SELECT dungeon_master_id
            FROM dungeon_master 
            WHERE user_name = '%{$userName}%'";
        $statement = oci_parse($this->conn, $sql);
        oci_execute($statement);
        oci_fetch_all($statement, $res, 0, 0, OCI_FETCHSTATEMENT_BY_ROW);
        //echo "HII {$res[0]['dungeon_master_id']}";
        //echo "$sql";
        return $res;
    }

    public function getAdventureId($adventure){
        $sql = "SELECT adventure_id
            FROM adventure
            WHERE name = '%{$adventure}%'";
        
        $statement = oci_parse($this->conn, $sql);
        oci_execute($statement);
        oci_fetch_all($statement, $res, 0, 0, OCI_FETCHSTATEMENT_BY_ROW);
        //echo "HII {$res[0]['adventure_id']}";
        //echo "$sql";
        return $res;
    }

    public function insertIntoRuns($dungeonMasterId, $adventureId){
        $sql = "INSERT INTO runs (dungeon_master, adventure) VALUES ('{$dungeonMasterId}', '{$adventureId}')";

        $statement = oci_parse($this->conn, $sql);
		$success = oci_execute($statement) && oci_commit($this->conn);
        oci_free_statement($statement);

        echo "Inserted into RUNS: {$success}";
        return $success;
    }

    public function insertIntoAdventure($adventure, $recommendedLevel){
        if (isset($recommendedLevel)) {
            $sql = "INSERT INTO 
                adventure (name, recommended_level) 
                VALUES ('%{$adventure}%', '{$recommendedLevel}')";
        } else {
            $sql = "INSERT INTO adventure (name) VALUES ('%{$adventure}%')";
        }

        $statement = oci_parse($this->conn, $sql);
		$success = oci_execute($statement) && oci_commit($this->conn);
        oci_free_statement($statement);

        return $success;
    }

    public function insertIntoDungeonMaster($userName, $email, $adventure, $recommendedLevel){

        $sql = "INSERT INTO dungeon_master (user_name, e_mail) VALUES ('%{$userName}%', '%{$email}%')";
        $statement = oci_parse($this->conn, $sql);
        $success = oci_execute($statement) && oci_commit($this->conn);
        oci_free_statement($statement);



        $dmIdArray = $this->getDungeonMasterId($userName);
        $dmId = !empty($dmIdArray) ? $dmIdArray[0]['dungeon_master_id'] : null;

        $advId = null;
        if (isset($adventure)) {
            $success = $this->insertIntoAdventure($adventure, $recommendedLevel);

            $advIdArray = $this->getAdventureId($adventure);
            $advId = !empty($advIdArray) ? $advIdArray[0]['adventure_id'] : null;
        }

        if (!empty($dmId) && !empty($advId)) {
            $success = $this->insertIntoRuns($dmId, $advId);
        }

        return $success;
    }

    public function insertIntoPlayer($userName, $email){
        $sql = "INSERT INTO player (user_name, e_mail) VALUES ('%{$userName}%', '%{$email}%')";

        $statement = oci_parse($this->conn, $sql);
        $success = oci_execute($statement) && oci_commit($this->conn);
        oci_free_statement($statement);
        return $success;
    }
    
}