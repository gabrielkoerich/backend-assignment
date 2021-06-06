A) Design a SQL database to store NBA players, teams and games (column and table contents are all up to you). 

Users mostly query game results by date and team name. 

The second most frequent query is players statistics by player name.

teams
- UNSIGNED BIGINT AUTO_INCREMENTS id
- VARCHAR(255) name INDEX
- DATETIME created_at
- DATETIME updated_at

players
- UNSIGNED BIGINT AUTO_INCREMENTS id
- VARCHAR(255) name INDEX
- DATETIME birthday
- DATETIME created_at
- DATETIME updated_at

games
- UNSIGNED BIGINT AUTO_INCREMENTS id
- VARCHAR(255) location
- DATE date
- UNSIGNED BIGINT local_team_id FOREIGN KEY on teams id
- UNSIGNED BIGINT foreign_team_id FOREIGN KEY on teams id
- DATETIME created_at
- DATETIME updated_at

game_player
- UNSIGNED BIGINT AUTO_INCREMENTS id
- UNSIGNED BIGINT game_id FOREIGN KEY on teams id
- UNSIGNED BIGINT player_id FOREIGN KEY on players id
- INT (1) starter
- DATETIME created_at
- DATETIME updated_at

game_events
- UNSIGNED BIGINT AUTO_INCREMENTS id
- UNSIGNED BIGINT game_id FOREIGN KEY on teams id
- UNSIGNED BIGINT player_id NULLABLE FOREIGN KEY on players id
- VARCHAR(255) event
- UNSIGNED BIGINT replaced_player_id NULLABLE FOREIGN KEY on players id
- DATETIME created_at
- DATETIME updated_at

