-- try script
-- Befüllung der Tabelle dnd_table
INSERT INTO dnd_table (miniatures, capacity, dice)
VALUES ('A', 4, 'Y');

INSERT INTO dnd_table (miniatures, capacity, dice)
VALUES ('B', 6, 'N');

INSERT INTO dnd_table (miniatures, capacity, dice)
VALUES ('C', 8, 'Y');

INSERT INTO dnd_table (miniatures, capacity, dice)
VALUES ('D', 6, 'Y');

INSERT INTO dnd_table (miniatures, capacity, dice)
VALUES ('E', 4, 'N');

-- Befüllung der Tabelle player
INSERT INTO player (e_mail, password, user_name)
VALUES ('player1@example.com', 'pass1', 'Player1');

INSERT INTO player (e_mail, password, user_name)
VALUES ('player2@example.com', 'pass2', 'Player2');

INSERT INTO player (e_mail, password, user_name)
VALUES ('player3@example.com', 'pass3', 'Player3');

INSERT INTO player (e_mail, password, user_name)
VALUES ('player4@example.com', 'pass4', 'Player4');

INSERT INTO player (e_mail, password, user_name)
VALUES ('player5@example.com', 'pass5', 'Player5');

-- Befüllung der Tabelle dungeon_master
INSERT INTO dungeon_master (dungeon_master_id, e_mail, password, user_name)
VALUES (1, 'dm1@example.com', 'dmpass1', 'DM1');

INSERT INTO dungeon_master (dungeon_master_id, e_mail, password, user_name)
VALUES (2, 'dm2@example.com', 'dmpass2', 'DM2');

INSERT INTO dungeon_master (dungeon_master_id, e_mail, password, user_name)
VALUES (3, 'dm3@example.com', 'dmpass3', 'DM3');

INSERT INTO dungeon_master (dungeon_master_id, e_mail, password, user_name)
VALUES (4, 'dm4@example.com', 'dmpass4', 'DM4');

INSERT INTO dungeon_master (dungeon_master_id, e_mail, password, user_name)
VALUES (5, 'dm5@example.com', 'dmpass5', 'DM5');

-- Befüllung der Tabelle game_date
INSERT INTO game_date (game_datetime)
VALUES (TIMESTAMP '2023-05-01 10:00:00');

INSERT INTO game_date (game_datetime)
VALUES (TIMESTAMP '2023-05-02 14:30:00');

INSERT INTO game_date (game_datetime)
VALUES (TIMESTAMP '2023-05-03 19:15:00');

INSERT INTO game_date (game_datetime)
VALUES (TIMESTAMP '2023-05-04 16:45:00');

INSERT INTO game_date (game_datetime)
VALUES (TIMESTAMP '2023-05-05 20:00:00');

-- Befüllung der Tabelle dnd_session
INSERT INTO dnd_session (table_id, player_id, dungeon_master_id, game_datetime)
VALUES (1, 1, 1, TIMESTAMP '2023-05-01 10:00:00');

INSERT INTO dnd_session (table_id, player_id, dungeon_master_id, game_datetime)
VALUES (2, 2, 2, TIMESTAMP '2023-05-02 14:30:00');

INSERT INTO dnd_session (table_id, player_id, dungeon_master_id, game_datetime)
VALUES (3, 3, 3, TIMESTAMP '2023-05-03 19:15:00');

INSERT INTO dnd_session (table_id, player_id, dungeon_master_id, game_datetime)
VALUES (4, 4, 4, TIMESTAMP '2023-05-04 16:45:00');

INSERT INTO dnd_session (table_id, player_id, dungeon_master_id, game_datetime)
VALUES (5, 5, 5, TIMESTAMP '2023-05-05 20:00:00');

-- Befüllung der Tabelle adventure
INSERT INTO adventure (name, recommended_level, creator)
VALUES ('Adventure1', 5, 1);

INSERT INTO adventure (name, recommended_level, creator)
VALUES ('Adventure2', 3, 2);

INSERT INTO adventure (name, recommended_level, creator)
VALUES ('Adventure3', 8, 3);

INSERT INTO adventure (name, recommended_level, creator)
VALUES ('Adventure4', 6, 4);

INSERT INTO adventure (name, recommended_level, creator)
VALUES ('Adventure5', 4, 5);

-- Befüllung der Tabelle loot
INSERT INTO loot (description)
VALUES ('Loot1');

INSERT INTO loot (description)
VALUES ('Loot2');

INSERT INTO loot (description)
VALUES ('Loot3');

INSERT INTO loot (description)
VALUES ('Loot4');

INSERT INTO loot (description)
VALUES ('Loot5');

-- Befüllung der Tabelle non_player_character
INSERT INTO non_player_character (name, challenge_rating, experience_points, alive, world)
VALUES ('NPC1', 1.5, 100, 'Y', 'Adventure1');

INSERT INTO non_player_character (name, challenge_rating, experience_points, alive, world)
VALUES ('NPC2', 2.0, 150, 'Y', 'Adventure2');

INSERT INTO non_player_character (name, challenge_rating, experience_points, alive, world)
VALUES ('NPC3', 3.5, 200, 'Y', 'Adventure3');

INSERT INTO non_player_character (name, challenge_rating, experience_points, alive, world)
VALUES ('NPC4', 2.5, 180, 'Y', 'Adventure4');

INSERT INTO non_player_character (name, challenge_rating, experience_points, alive, world)
VALUES ('NPC5', 4.0, 250, 'Y', 'Adventure5');

-- Befüllung der Tabelle drop_table
INSERT INTO drop_table (loot, drops_form)
VALUES ('Loot1', 'NPC1');

INSERT INTO drop_table (loot, drops_form)
VALUES ('Loot2', 'NPC2');

INSERT INTO drop_table (loot, drops_form)
VALUES ('Loot3', 'NPC3');

INSERT INTO drop_table (loot, drops_form)
VALUES ('Loot4', 'NPC4');

INSERT INTO drop_table (loot, drops_form)
VALUES ('Loot5', 'NPC5');

-- Befüllung der Tabelle party
INSERT INTO party (party_name)
VALUES ('Party1');

INSERT INTO party (party_name)
VALUES ('Party2');

INSERT INTO party (party_name)
VALUES ('Party3');

INSERT INTO party (party_name)
VALUES ('Party4');

INSERT INTO party (party_name)
VALUES ('Party5');

-- Befüllung der Tabelle player_character
INSERT INTO player_character (name, character_of, class, race, party, alive, trade_partner, gold, character_level)
VALUES ('Character1', 1, 'BARBARIAN', 'HUMAN', 'Party1', 'Y', NULL, 100, 15);

INSERT INTO player_character (name, character_of, class, race, party, alive, trade_partner, gold, character_level)
VALUES ('Character8', 1, 'BARBARIAN', 'HUMAN', 'Party1', 'Y', NULL, 100, 15);

INSERT INTO player_character (name, character_of, class, race, party, alive, trade_partner, gold, character_level)
VALUES ('Character9', 1, 'BARBARIAN', 'HUMAN', 'Party1', 'Y', NULL, 100, 18);

INSERT INTO player_character (name, character_of, class, race, party, alive, trade_partner, gold, character_level)
VALUES ('Character2', 2, 'BARD', 'ELF', 'Party2', 'Y', NULL, 200, 1);

INSERT INTO player_character (name, character_of, class, race, party, alive, trade_partner, gold, character_level)
VALUES ('Character3', 3, 'CLERIC', 'DWARF', 'Party3', 'Y', NULL, 300, 1);

INSERT INTO player_character (name, character_of, class, race, party, alive, trade_partner, gold, character_level)
VALUES ('Character4', 4, 'DRUID', 'HALFLING', 'Party4', 'Y', NULL, 400, 1);

INSERT INTO player_character (name, character_of, class, race, party, alive, trade_partner, gold, character_level)
VALUES ('Character5', 5, 'FIGHTER', 'DRAGONBORN', 'Party5', 'Y', NULL, 500, 1);

INSERT INTO player_character (name, character_of, class, race, party, alive, trade_partner, gold, character_level)
VALUES ('Character6', 5, 'FIGHTER', 'DRAGONBORN', 'Party5', 'Y', NULL, 500, 1);

INSERT INTO player_character (name, character_of, class, race, party, alive, trade_partner, gold, character_level)
VALUES ('Character7', 5, 'FIGHTER', 'DRAGONBORN', 'Party5', 'Y', NULL, 600, 1);

-- Befüllung der Tabelle equipment
INSERT INTO equipment (description)
VALUES ('Equipment1');

INSERT INTO equipment (description)
VALUES ('Equipment2');

INSERT INTO equipment (description)
VALUES ('Equipment3');

INSERT INTO equipment (description)
VALUES ('Equipment4');

INSERT INTO equipment (description)
VALUES ('Equipment5');

-- Befüllung der Tabelle has_equipment
INSERT INTO has_equipment (description, owned_by)
VALUES ('Equipment1', 'Character1');

INSERT INTO has_equipment (description, owned_by)
VALUES ('Equipment2', 'Character2');

INSERT INTO has_equipment (description, owned_by)
VALUES ('Equipment3', 'Character3');

INSERT INTO has_equipment (description, owned_by)
VALUES ('Equipment4', 'Character4');

INSERT INTO has_equipment (description, owned_by)
VALUES ('Equipment5', 'Character5');

-- Befüllung der Tabelle spell
INSERT INTO spell (description)
VALUES ('Spell1');

INSERT INTO spell (description)
VALUES ('Spell2');

INSERT INTO spell (description)
VALUES ('Spell3');

INSERT INTO spell (description)
VALUES ('Spell4');

INSERT INTO spell (description)
VALUES ('Spell5');

-- Befüllung der Tabelle has_spell
INSERT INTO has_spell (description, casted_by)
VALUES ('Spell1', 'Character1');

INSERT INTO has_spell (description, casted_by)
VALUES ('Spell2', 'Character2');

INSERT INTO has_spell (description, casted_by)
VALUES ('Spell3', 'Character3');

INSERT INTO has_spell (description, casted_by)
VALUES ('Spell4', 'Character4');

INSERT INTO has_spell (description, casted_by)
VALUES ('Spell5', 'Character5');

-- Befüllung der Tabelle runs
INSERT INTO runs (dungeon_master, adventure)
VALUES (1, 'Adventure1');

INSERT INTO runs (dungeon_master, adventure)
VALUES (2, 'Adventure2');

INSERT INTO runs (dungeon_master, adventure)
VALUES (3, 'Adventure3');

INSERT INTO runs (dungeon_master, adventure)
VALUES (4, 'Adventure4');

INSERT INTO runs (dungeon_master, adventure)
VALUES (5, 'Adventure5');

-- Befüllung der Tabelle fight
INSERT INTO fight (player_character, non_player_character, pc_won)
VALUES ('Character1', 'NPC1', 'Y');

INSERT INTO fight (player_character, non_player_character, pc_won)
VALUES ('Character2', 'NPC2', 'N');

INSERT INTO fight (player_character, non_player_character, pc_won)
VALUES ('Character3', 'NPC3', 'Y');

INSERT INTO fight (player_character, non_player_character, pc_won)
VALUES ('Character4', 'NPC4', 'N');

INSERT INTO fight (player_character, non_player_character, pc_won)
VALUES ('Character5', 'NPC5', 'Y');