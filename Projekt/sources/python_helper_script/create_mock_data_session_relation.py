from faker import Faker
import random

fake = Faker()

"""
HAD A HUGE BUG SINCE FAKER HAS A SMALL CHANGE TO CREATE A NAME WITH A TITLE. 
EG.: "MARKUS HEINZ PROF. DR. MED.
BUT MY REGEX ONLY INCLUDED \\w+ \\w+
"""
def create_mock_dm(dm) -> str:
    name, email = dm
    name = ' '.join(name.split()[:2])
    return f"INSERT INTO dungeon_master (user_name, e_mail) VALUES ('{name}', '{email}')"


def create_mock_player(player) -> str:
    name, email = player
    name = ' '.join(name.split()[:2])
    return f"INSERT INTO player (user_name, e_mail) VALUES ('{name}', '{email}')"


def create_mock_table():
    miniature = 'Y' if bool(random.getrandbits(1)) else 'N'
    capacity = random.randint(3, 10)
    dice = 'Y' if bool(random.getrandbits(1)) else 'N'
    return f"INSERT INTO dnd_table (miniatures, capacity, dice) VALUES ('{miniature}', {capacity}, '{dice}')"


def create_mock_game_date():
    game_datetime = fake.date_time_this_decade()
    return game_datetime.strftime("INSERT INTO game_date (game_datetime) VALUES (TO_TIMESTAMP('%Y-%m-%d %H:%M:%S', 'YYYY-MM-DD HH24:MI:SS'))")


def create_mock_party_name() -> str:
    """returns string that fits in a varchar(255)"""
    lorem_text = fake.unique.paragraph()
    return lorem_text[:255]


def create_mock_pc() -> (str, str, str, int, int, int):
    """returns name, class, race, dead/alive, gold, level
    """
    classes = ['BARBARIAN', 'BARD', 'CLERIC', 'DRUID', 'FIGHTER', 'MONK', 'PALADIN', 'RANGER', 'ROGUE', 'SORCERER', 'WARLOCK', 'WIZARD', 'ARTIFICER']
    races = ['DRAGONBORN', 'DWARF', 'ELF', 'GNOME', 'HALF_ELF', 'HALFLING', 'HALF_ORC', 'HUMAN', 'TIEFLING']
    name = fake.name()
    chosen_class = random.choice(classes)
    chosen_race = random.choice(races)
    gold = random.randint(0, 20000)
    character_level = random.randint(1, 20)
    return name, chosen_class, chosen_race, gold, character_level


"""def create_mock_adventures() -> str:
    adventure = fake.unique.paragraph()
    return f"INSERT INTO adventure (name, recommended_level) VALUES('{adventure}', {random.randint(1,20)})"
"""

if __name__ == '__main__':
    mock_name_dm = set()
    mock_email_dm = set()
    while len(mock_name_dm) < 500:
        mock_name_dm.add(fake.name())
    while len(mock_email_dm) < 500:
        mock_email_dm.add(fake.email())
    mock_dm_details = list(zip(mock_name_dm, mock_email_dm))
    mock_sql_inserts_dm = [create_mock_dm(details) for details in mock_dm_details]

    mock_name_player = set()
    mock_email_player = set()
    while len(mock_name_player) < 2000:
        mock_name_player.add(fake.name())
    while len(mock_email_player) < 2000:
        mock_email_player.add(fake.email())
    mock_player_details = list(zip(mock_name_player, mock_email_player))
    mock_sql_inserts_player = [create_mock_player(details) for details in mock_player_details]

    """mock_player_name_mock_player_email = set()
    while len(mock_player_name_mock_player_email) < 2000:
        mock_name_player = fake.name()
        mock_email_player = fake.email()
        player = (mock_name_player, mock_email_player)
        mock_player_name_mock_player_email.add(player)
    mock_sql_inserts_player = [create_mock_player(details) for details in mock_player_name_mock_player_email]"""

    with open('dm_inserts.sql', 'w') as file:
        for sql_insert in mock_sql_inserts_dm:
            file.write(sql_insert + '\n')

    with open('player_inserts.sql', 'w') as file:
        for sql_insert in mock_sql_inserts_player:
            file.write(sql_insert + '\n')

    mock_sql_inserts_table = [create_mock_table() for _ in range(2000)]
    with open('table_inserts.sql', 'w') as file:
        for sql_insert in mock_sql_inserts_table:
            file.write(sql_insert + '\n')

    mock_sql_inserts_dates = [create_mock_game_date() for _ in range(500)]
    with open('game_dates_inserts.sql', 'w') as file:
        for sql_insert in mock_sql_inserts_dates:
            file.write(sql_insert + '\n')

    mock_party_names = [create_mock_party_name() for _ in range(800)]
    with open('party_names.txt', 'w') as file:
        for party_name in mock_party_names:
            file.write(party_name + '\n')

    player_chars = [create_mock_pc() for _ in range(4000)]
    with open('player_character.txt', 'w') as file:
        for pc in player_chars:
            file.write(str(pc) + '\n')