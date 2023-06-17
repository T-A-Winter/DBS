public class PlayerCharacter {
    private String name;
    private Integer characterOf;
    private String characterClass;
    private String race;
    private String party;
    private Integer alive;
    private Integer tradePartner;
    private Integer gold;
    private Integer level;

    private PlayerCharacter(String name, Integer characterOf, String characterClass, String race, String party, Integer alive, Integer tradePartner, Integer gold, Integer level) {
        this.name = name;
        this.characterOf = characterOf;
        this.characterClass = characterClass;
        this.race = race;
        this.party = party;
        this.alive = alive;
        this.tradePartner = tradePartner;
        this.gold = gold;
        this.level = level;
    }

    public static PlayerCharacter create(String name, Integer characterOf, String characterClass, String race, String party, Integer alive, Integer tradePartner, Integer gold, Integer level) {
        return new PlayerCharacter(name, characterOf, characterClass, race, party, alive, tradePartner, gold, level);
    }

    public String getName() {
        return name;
    }

    public Integer getCharacterOf() {
        return characterOf;
    }

    public String getCharacterClass() {
        return characterClass;
    }

    public String getRace() {
        return race;
    }

    public String getParty() {
        return party;
    }

    public Integer getAlive() {
        return alive;
    }

    public Integer getTradePartner() {
        return tradePartner;
    }

    public Integer getGold() {
        return gold;
    }

    public Integer getLevel() {
        return level;
    }
}
