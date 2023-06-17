import java.io.PrintWriter;
import java.sql.*;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.LinkedHashMap;

public class DatabaseHelper {
    // Database connection info
    private static final String DB_CONNECTION_URL = "jdbc:oracle:thin:@oracle19.cs.univie.ac.at:1521:orclcdb";
    private static final String USER = "a12028429";
    private static final String PASS = "dbs23";

    private static Statement statement;
    private static Connection connection;

    //CREATE CONNECTION
    DatabaseHelper(){
        try {
            connection = DriverManager.getConnection(DB_CONNECTION_URL, USER, PASS);
            statement = connection.createStatement();
        }catch (SQLException esql){
            while(esql != null) {
                System.out.println("Error from DatabaseHelper:");
                System.out.println(esql.toString());
                System.out.println("SQL-State: " + esql.getSQLState());
                System.out.println("ErrorCode: " + esql.getErrorCode());
                esql = esql.getNextException();
            }
        }
    }
    ////////////////////////////////////    INSERTS    /////////////////////////////////////////////////////////
    void insertIntoPlayer(String command){
        try {
            statement.execute(command);
        }catch (SQLException esql){
            while(esql != null) {
                System.out.println("Error from insertIntoPlayer:");
                System.out.println(esql.toString());
                System.out.println("SQL-State: " + esql.getSQLState());
                System.out.println("ErrorCode: " + esql.getErrorCode());
                esql = esql.getNextException();
            }
        }
    }
    void insertIntoDM(String command){
        try {
            statement.execute(command);
        }catch (SQLException esql){
            while(esql != null) {
                System.out.println("Error from insertIntoDM:");
                System.out.println(esql.toString());
                System.out.println("SQL-State: " + esql.getSQLState());
                System.out.println("ErrorCode: " + esql.getErrorCode());
                esql = esql.getNextException();
            }
        }
    }
    void insertIntoTable(String command){
        try {
            statement.execute(command);
        }catch (SQLException esql){
            while(esql != null) {
                System.out.println("Error from insertIntoTable");
                System.out.println(esql.toString());
                System.out.println("SQL-State: " + esql.getSQLState());
                System.out.println("ErrorCode: " + esql.getErrorCode());
                esql = esql.getNextException();
            }
        }
    }
    void insertIntoGameDates(String command){
        try {
            statement.execute(command);
        }catch (SQLException esql){
            while(esql != null) {
                System.out.println("Error from insertIntoGameDates:");
                System.out.println(esql.toString());
                System.out.println("SQL-State: " + esql.getSQLState());
                System.out.println("ErrorCode: " + esql.getErrorCode());
                esql = esql.getNextException();
            }
        }
    }

    void insertIntoDndSession(int tableId, int playerId, int dungeonMasterId, int gameDateId){
        String command = "INSERT INTO dnd_session (table_id, player_id, dungeon_master_id, game_date_id) VALUES (?, ?, ?, ?)";
        try (PreparedStatement pstmt = connection.prepareStatement(command)) {
            pstmt.setInt(1, tableId);
            pstmt.setInt(2, playerId);
            pstmt.setInt(3, dungeonMasterId);
            pstmt.setInt(4, gameDateId);

            pstmt.executeUpdate();
        } catch (SQLException esql) {
            while(esql != null) {
                System.out.println("Error from insertIntoDndSession:");
                System.out.println(esql.toString());
                System.out.println("SQL-State: " + esql.getSQLState());
                System.out.println("ErrorCode: " + esql.getErrorCode());
                esql = esql.getNextException();
            }
        }
    }

    void insertIntoAdventure(String name, Integer randomNum) {
        String command = "INSERT INTO adventure (name, recommended_level) VALUES (?, ?)";
        try (PreparedStatement pstmt = connection.prepareStatement(command)) {
            pstmt.setString(1, name);
            pstmt.setInt(2, randomNum);

            pstmt.executeUpdate();
        } catch (SQLException esql) {
            while (esql != null) {
                System.out.println("Error from insertIntoAdventure:");
                System.out.println(esql.toString());
                System.out.println("SQL-State: " + esql.getSQLState());
                System.out.println("ErrorCode: " + esql.getErrorCode());
                esql = esql.getNextException();
            }
        }
    }

    void insertIntoRun(Integer dmId, Integer advId){
        String command = "INSERT INTO runs (dungeon_master, adventure) VALUES(?, ?)";
        try (PreparedStatement pstmt = connection.prepareStatement(command)){
            pstmt.setInt(1, dmId);
            pstmt.setInt(2, advId);

            pstmt.executeUpdate();
        } catch (SQLException esql) {
            while (esql != null) {
                System.out.println("Error from insertIntoRun:");
                System.out.println(esql.toString());
                System.out.println("SQL-State: " + esql.getSQLState());
                System.out.println("ErrorCode: " + esql.getErrorCode());
                esql = esql.getNextException();
            }
        }
    }

    void insertIntoParty(String partName){
        String command = "INSERT INTO party (party_name) VALUES(?)";
        try (PreparedStatement pstmt = connection.prepareStatement(command)){
            pstmt.setString(1, partName);
            pstmt.executeUpdate();
        }catch (SQLException esql) {
            while (esql != null) {
                System.out.println("Error from insertIntoParty:");
                System.out.println(esql.toString());
                System.out.println("SQL-State: " + esql.getSQLState());
                System.out.println("ErrorCode: " + esql.getErrorCode());
                esql = esql.getNextException();
            }
        }
    }

    void insertIntoPlayerCharacter(String name, Integer character_of, String dnd_class, String race, String party,
                                   Integer alive, Integer trade_partner, Integer gold, Integer character_level){
        String command = "INSERT INTO player_character (name, character_of, class, race, party, alive, trade_partner, gold, character_level) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)";
        try (PreparedStatement pstmt = connection.prepareStatement(command)){
            pstmt.setString(1, name);
            pstmt.setInt(2, character_of);
            pstmt.setString(3, dnd_class);
            pstmt.setString(4, race);
            pstmt.setString(5, party);
            pstmt.setInt(6, alive); // alive
            if (trade_partner == null) {
                pstmt.setNull(7, java.sql.Types.INTEGER);
            } else {
                pstmt.setInt(7, trade_partner);
            }
            if (gold == null) {
                pstmt.setNull(8, java.sql.Types.INTEGER);
            } else {
                pstmt.setInt(8, gold);
            }
            pstmt.setInt(9, character_level);

            pstmt.executeUpdate();
        }catch (SQLException esql) {
            while (esql != null) {
                System.out.println("Error from insertIntoPlayerCharacter:");
                System.out.println(esql.toString());
                System.out.println("SQL-State: " + esql.getSQLState());
                System.out.println("ErrorCode: " + esql.getErrorCode());
                esql = esql.getNextException();
            }
        }
    }

    void updatePlayerCharacterTradePartner(Integer charId, Integer tradePartnerId){
        String command = "UPDATE player_character SET trade_partner = ? WHERE player_character_id = ?";
        try(PreparedStatement pstmt = connection.prepareStatement(command)){
            pstmt.setInt(1, tradePartnerId);
            pstmt.setInt(2, charId);

            pstmt.executeUpdate();
        }catch (SQLException esql) {
            while (esql != null) {
                System.out.println("Error from updatePlayerCharacterTradePartner:");
                System.out.println(esql.toString());
                System.out.println("SQL-State: " + esql.getSQLState());
                System.out.println("ErrorCode: " + esql.getErrorCode());
                esql = esql.getNextException();
            }
        }
    }


    ////////////////////////////////////    SELECTS    /////////////////////////////////////////////////////////

    ArrayList<Integer>selectPlayerCharacterID(){
        ArrayList<Integer> IDs = new ArrayList<>();
        try{
            ResultSet result = statement.executeQuery("SELECT player_character_id FROM player_character ORDER BY player_character_id");
            while (result.next()){
                IDs.add(result.getInt("player_character_id"));
            }
        }catch (SQLException esql){
            while(esql != null) {
                System.out.println("Error from selectPlayerCharacterID");
                System.out.println(esql.toString());
                System.out.println("SQL-State: " + esql.getSQLState());
                System.out.println("ErrorCode: " + esql.getErrorCode());
                esql = esql.getNextException();
            }
        }
        return IDs;
    }

    ArrayList<Integer> selectPlayerIds(){
        ArrayList<Integer> IDs = new ArrayList<>();
        try{
            ResultSet result = statement.executeQuery("SELECT player_id FROM player ORDER BY player_id");
            while (result.next()){
                IDs.add(result.getInt("PLAYER_ID"));
            }
            result.close();
        }catch (SQLException esql){
            while(esql != null) {
                System.out.println("Error from selectPlayerIds");
                System.out.println(esql.toString());
                System.out.println("SQL-State: " + esql.getSQLState());
                System.out.println("ErrorCode: " + esql.getErrorCode());
                esql = esql.getNextException();
            }
        }
        return IDs;
    }

    ArrayList<Integer> selectDMIds(){
        ArrayList<Integer> IDs = new ArrayList<>();

        try{
            ResultSet result = statement.executeQuery("SELECT dungeon_master_id FROM dungeon_master ORDER BY dungeon_master_id");
            while (result.next()){
                IDs.add(result.getInt("DUNGEON_MASTER_ID"));
            }
            result.close();
        }catch (SQLException esql){
            while(esql != null) {
                System.out.println("Error from selectDMIds:");
                System.out.println(esql.toString());
                System.out.println("SQL-State: " + esql.getSQLState());
                System.out.println("ErrorCode: " + esql.getErrorCode());
                esql = esql.getNextException();
            }
        }
        return IDs;
    }

    ArrayList<String> selectDMNames(){
        ArrayList<String> dmNames = new ArrayList<>();
        try{
            ResultSet result = statement.executeQuery("SELECT user_name FROM dungeon_master");
            while (result.next()){
                String name = result.getString("user_name");
                dmNames.add(name);
            }
        }catch (SQLException esql) {
            while (esql != null) {
                System.out.println("Error from selectDMNames:");
                System.out.println(esql.toString());
                System.out.println("SQL-State: " + esql.getSQLState());
                System.out.println("ErrorCode: " + esql.getErrorCode());
                esql = esql.getNextException();
            }
        }
        return dmNames;
    }

    HashMap<Integer, String> selectDMNIdsAndNames() {
        HashMap<Integer, String> dmIdAndName = new HashMap<>();
        try {
            ResultSet result = statement.executeQuery("SELECT dungeon_master_id, user_name FROM dungeon_master ORDER BY dungeon_master_id");
            while (result.next()) {
                int id = result.getInt("dungeon_master_id");
                String name = result.getString("user_name");
                dmIdAndName.put(id, name);
            }
        } catch (SQLException esql) {
            while (esql != null) {
                System.out.println("Error from selectDMNIdsAndNames:");
                System.out.println(esql.toString());
                System.out.println("SQL-State: " + esql.getSQLState());
                System.out.println("ErrorCode: " + esql.getErrorCode());
                esql = esql.getNextException();
            }
        }
        return dmIdAndName;
    }

    LinkedHashMap<Integer, Integer> selectTableIdAndCap(){
        LinkedHashMap<Integer, Integer> table = new LinkedHashMap<>();
        try{
            ResultSet result = statement.executeQuery("SELECT table_id, capacity FROM dnd_table ORDER BY table_id");
            while(result.next()){
                int tableId = result.getInt("table_id");
                int cap = result.getInt("capacity");
                table.put(tableId, cap);
            }
        }catch (SQLException esql){
            while(esql != null) {
                System.out.println("Error from selectTableIdAndCap:");
                System.out.println(esql.toString());
                System.out.println("SQL-State: " + esql.getSQLState());
                System.out.println("ErrorCode: " + esql.getErrorCode());
                esql = esql.getNextException();
            }
        }
        return table;
    }

    ArrayList<Integer> selectGameDateId(){
        ArrayList<Integer> gameDateIds = new ArrayList<>();
        try{
            ResultSet result = statement.executeQuery("SELECT game_date_id FROM game_date ORDER BY game_date_id");
            while(result.next()){
                gameDateIds.add(result.getInt("GAME_DATE_ID"));
            }
        }catch (SQLException esql){
            while(esql != null) {
                System.out.println("Error from selectGameDateId:");
                System.out.println(esql.toString());
                System.out.println("SQL-State: " + esql.getSQLState());
                System.out.println("ErrorCode: " + esql.getErrorCode());
                esql = esql.getNextException();
            }
        }
        return gameDateIds;
    }

    ArrayList<Integer> selectAdventureID(){
        ArrayList<Integer> advIDs = new ArrayList<>();
        try {
            ResultSet result = statement.executeQuery("SELECT adventure_id FROM adventure ORDER BY adventure_id");
            while (result.next()){
                advIDs.add(result.getInt("adventure_id"));
            }
        }catch (SQLException esql){
            while(esql != null) {
                System.out.println("Error from selectAdventureID:");
                System.out.println(esql.toString());
                System.out.println("SQL-State: " + esql.getSQLState());
                System.out.println("ErrorCode: " + esql.getErrorCode());
                esql = esql.getNextException();
            }
        }
        return  advIDs;
    }

    ArrayList<String> selectPartyName(){
        ArrayList<String> partyNames = new ArrayList<>();
        try {
            ResultSet result = statement.executeQuery("SELECT party_name FROM party");
            while (result.next()){
                partyNames.add(result.getString("party_name"));
            }
        }catch (SQLException esql){
            while(esql != null) {
                System.out.println("Error from selectPartyName:");
                System.out.println(esql.toString());
                System.out.println("SQL-State: " + esql.getSQLState());
                System.out.println("ErrorCode: " + esql.getErrorCode());
                esql = esql.getNextException();
            }
        }
        return partyNames;
    }

    public void close()  {
        try {
            statement.close(); //clean up
            connection.close();
        } catch (Exception ignored) {
        }
    }

}
