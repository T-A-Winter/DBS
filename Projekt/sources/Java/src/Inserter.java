import java.io.BufferedReader;
import java.io.FileReader;
import java.util.Random;
import java.util.*;
import java.util.regex.Matcher;
import java.util.regex.Pattern;


public class Inserter {
    public static void main(String[] args){
        DatabaseHelper databaseHelper = new DatabaseHelper();

        // inserting to session relation
        String path = "C:\\Users\\Tobi\\Desktop\\Uni\\DBS\\Projekt\\sources\\Python-Helper-script\\SQL_Inserts\\";
        // inserting to dungeon_master
        try(BufferedReader reader = new BufferedReader(new FileReader(path + "session_relation\\dm_inserts.sql"))){
            String line;
            while ((line = reader.readLine()) != null) {
                databaseHelper.insertIntoDM(line);
            }
        }catch (Exception e){
            e.printStackTrace();
        }

        // inserting player
        try(BufferedReader reader = new BufferedReader(new FileReader(path + "session_relation\\player_inserts.sql"))){
            String line;
            while ((line = reader.readLine()) != null) {
                databaseHelper.insertIntoPlayer(line);
            }
        }catch (Exception e){
            e.printStackTrace();
        }

        // inserting game_dates
        try(BufferedReader reader = new BufferedReader(new FileReader(path + "session_relation\\game_dates_inserts.sql"))){
            String line;
            while ((line = reader.readLine()) != null) {
                databaseHelper.insertIntoGameDates(line);
            }
        } catch (Exception e){
            e.printStackTrace();
        }

        // inserting tables
        try(BufferedReader reader = new BufferedReader(new FileReader(path + "session_relation\\table_inserts.sql"))){
            String line;
            while ((line = reader.readLine()) != null) {
                databaseHelper.insertIntoTable(line);
            }
        }catch (Exception e){
            e.printStackTrace();
        }

        // inserting into dnd_session
        try{
            ArrayList<Integer> players = databaseHelper.selectPlayerIds();
            ArrayList<Integer> dms = databaseHelper.selectDMIds();
            LinkedHashMap<Integer, Integer> tables = databaseHelper.selectTableIdAndCap();
            ArrayList<Integer> dateIds = databaseHelper.selectGameDateId();

            Iterator<Integer> playerIterator = players.iterator();
            Iterator<Integer> dmIterator = dms.iterator();
            Iterator<Integer> dateIterator = dateIds.iterator();

            for (Map.Entry<Integer, Integer> table : tables.entrySet()) {
                int tableId = table.getKey();
                int capacity = table.getValue();

                if (!dmIterator.hasNext() || !dateIterator.hasNext()) {
                    break;
                }

                int dmId = dmIterator.next();
                int dateId = dateIterator.next();

                for (int i = 0; i < capacity-1; i++) { // cap -1 -> dungeon_master also takes a seat
                    if (!playerIterator.hasNext()) {
                        break;
                    }

                    int playerId = playerIterator.next();

                    databaseHelper.insertIntoDndSession(tableId, playerId, dmId, dateId);
                }
            }
        } catch (Exception e){
            e.printStackTrace();
        }

        // inserting into adventure table
        // since name can't be random and i can't find a list with Adventure names, the names shall be "actual_dm_name_adventure"

        try{
            ArrayList<String> dmNames = databaseHelper.selectDMNames();
            Random rand = new Random();
            for(String name : dmNames){
                int randomNum = rand.nextInt(20) + 1;
                databaseHelper.insertIntoAdventure(name, randomNum);
            }
        }
        catch (Exception e){
            e.printStackTrace();
        }

        // inserting into run table

        try {
            ArrayList<Integer> dmIds = databaseHelper.selectDMIds();
            ArrayList<Integer> advIds = databaseHelper.selectAdventureID();

            int min = Math.min(dmIds.size(), advIds.size());

            for(int i = 0; i < min; ++i){
                databaseHelper.insertIntoRun(dmIds.get(i), advIds.get(i));
            }

        }catch (Exception e){
            e.printStackTrace();
        }

        // inserting into party

        try (BufferedReader reader = new BufferedReader(new FileReader(path + "plays_relation\\party_names.txt"))){
            String line;
            while ((line = reader.readLine()) != null){
                databaseHelper.insertIntoParty(line);
            }
        }catch (Exception e){
            e.printStackTrace();
        }

        // inserting into player_charaters
        //
        // creating playerCharacter obj.
        try(BufferedReader reader = new BufferedReader(new FileReader(path + "plays_relation\\player_character.txt"))){
            ArrayList<String> partys = databaseHelper.selectPartyName();
            ArrayList<Integer> players = databaseHelper.selectPlayerIds();
            ArrayList<PlayerCharacter> playerCharacters = new ArrayList<>();

            // every player has 2 p pcs
            String line;
            Pattern pattern = Pattern.compile("[\\w]+ [\\w]+|[0-9]+|BARBARIAN|BARD|CLERIC|DRUID|FIGHTER|MONK|PALADIN|RANGER|ROGUE|SORCERER|WARLOCK|WIZARD|ARTIFICER|DRAGONBORN|DWARF|ELF|GNOME|HALF_ELF|HALFLING|HALF_ORC|HUMAN|TIEFLING");
            while ((line = reader.readLine()) != null) {
                Matcher matcher = pattern.matcher(line);
                int matchCounter = 0;

                String name = null;
                String characterClass = null;
                String race = null;
                Integer gold = null;
                Integer level = null;

                while (matcher.find()){
                    matchCounter++;
                    String matchedValue = matcher.group();
                    try {
                        switch (matchCounter) {
                            case 1:
                                name = matchedValue;
                                break;
                            case 2:
                                characterClass = matchedValue;
                                break;
                            case 3:
                                race = matchedValue;
                                break;
                            case 4:
                                gold = Integer.valueOf(String.valueOf(matchedValue));
                                break;
                            case 5:
                                level = Integer.valueOf(String.valueOf(matchedValue));
                                break;
                        }
                    }catch (Exception e){
                        System.out.println(name);
                        System.out.println(characterClass);
                        System.out.println(race);
                        System.out.println(matchedValue);
                    }
                }
                PlayerCharacter pc = PlayerCharacter.create(name, null, characterClass, race, null, 1, null, gold, level);
                playerCharacters.add(pc);
            }

            // pairing playerCharacter obj. to players and partys

            int charIndex = 0;
            for(int i = 0; i < players.size(); i++){
                int playerId = players.get(i);
                for(int j = 0; j < 2; ++j){
                    PlayerCharacter pc = playerCharacters.get(charIndex);
                    String party = partys.get(charIndex / 8);
                    try {
                        databaseHelper.insertIntoPlayerCharacter(
                                pc.getName(),
                                playerId,
                                pc.getCharacterClass(),
                                pc.getRace(),
                                party,
                                1,
                                null,
                                pc.getGold(),
                                pc.getLevel()
                        );
                        charIndex++;
                    }catch (Exception e){
                        e.printStackTrace();
                    }
                }
            }

            // second iteration to update the trade_partner column
            ArrayList<Integer> characterIds = databaseHelper.selectPlayerCharacterID();
            for (int i = 0; i < characterIds.size(); i++) {
                Integer currentCharacterId = characterIds.get(i);

                // Start the inner loop at i + 1 to avoid assigning a character as its own trade partner
                for (int j = i + 1; j < characterIds.size();) {
                    Integer potentialTradePartnerId = characterIds.get(j);

                    // Update the trade partner of the current character and the potential trade partner
                    databaseHelper.updatePlayerCharacterTradePartner(currentCharacterId, potentialTradePartnerId);
                    databaseHelper.updatePlayerCharacterTradePartner(potentialTradePartnerId, currentCharacterId);

                    // Remove the potential trade partner from the list and break out of the inner loop
                    characterIds.remove(j);
                    break;
                }
            }

        }catch (Exception e){
            e.printStackTrace();
        }

        databaseHelper.close();
    }
}
