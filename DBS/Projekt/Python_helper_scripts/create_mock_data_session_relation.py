from faker import Faker
import random

fake = Faker()
def create_mock_dm():
    name: str = fake.name()
    email: str = fake.email()
    return f"INSERT INTO dungeon_master (user_name, e_mail) VALUES ('{name}', '{email}');"

def create_mock_player():
    name: str = fake.name()
    email: str = fake.email()
    return f"INSERT INTO player (user_name, e_mail) VALUES ('{name}', '{email}');"

def create_mock_table():
    miniature = 'Y' if bool(random.getrandbits(1)) else 'N'
    capacity = random.randint(3, 10)
    dice = 'Y' if bool(random.getrandbits(1)) else 'N'
    return f"INSERT INTO dnd_table (miniatures, capacity, dice) VALUES ('{miniature}', {capacity}, '{dice}');"

def create_mock_game_date():
    game_datetime = fake.date_time_this_decade()
    return game_datetime.strftime("INSERT INTO game_date (game_datetime) VALUES ('%Y-%m-%d %H:%M:%S');")

if __name__ == '__main__':
    mock_sql_inserts_dm = [create_mock_dm() for _ in range(200)]
    mock_sql_inserts_player = [create_mock_player() for _ in range(2000)]
    mock_sql_inserts_table = [create_mock_table() for _ in range(2000)]
    mock_sql_inserts_dates = [create_mock_game_date() for _ in range(200)]

    with open('dm_inserts.sql', 'w') as file:
        for sql_insert in mock_sql_inserts_dm:
            file.write(sql_insert + '\n')
    with open('player_inserts.sql', 'w') as file:
        for sql_insert in mock_sql_inserts_player:
            file.write(sql_insert + '\n')
    with open('table_inserts.sql', 'w') as file:
        for sql_insert in mock_sql_inserts_table:
            file.write(sql_insert + '\n')
    with open('game_dates_inserts.sql', 'w') as file:
        for sql_insert in mock_sql_inserts_dates:
            file.write(sql_insert + '\n')
