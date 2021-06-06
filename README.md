# Backend Assignment

A) Design a SQL database to store NBA players, teams and games (column and table contents are all up to you). 

Users mostly query game results by date and team name. 

The second most frequent query is players statistics by player name.

### teams
- UNSIGNED BIGINT AUTO_INCREMENTS id
- VARCHAR(255) name INDEX
- DATETIME created_at
- DATETIME updated_at

```php
Schema::create('teams', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->timestamps();
});
```

### players
- UNSIGNED BIGINT AUTO_INCREMENTS id
- VARCHAR(255) name INDEX
- DATE birthday
- DATETIME created_at
- DATETIME updated_at

```php
Schema::create('players', function (Blueprint $table) {
    $table->id();
    $table->string('name')->index();
    $table->date('birthday')->nullable();
    $table->timestamps();
});
```

### games
- UNSIGNED BIGINT AUTO_INCREMENTS id
- DATETIME datetime
- VARCHAR(255) location
- UNSIGNED BIGINT local_team_id FOREIGN KEY on teams id
- UNSIGNED BIGINT foreign_team_id FOREIGN KEY on teams id
- DATETIME created_at
- DATETIME updated_at

```php
Schema::create('games', function (Blueprint $table) {
    $table->id();
    $table->datetime('datetime');
    $table->string('location');
    $table->unsignedBigInteger('local_team_id');
    $table->unsignedBigInteger('foreign_team_id');
    $table->timestamps();

    $table->foreign('local_team_id')
        ->references('id')
        ->on('teams')
        ->onDelete('restrict');

    $table->foreign('foreign_team_id')
        ->references('id')
        ->on('teams')
        ->onDelete('restrict');
});
```

### game_player
- UNSIGNED BIGINT AUTO_INCREMENTS id
- UNSIGNED BIGINT game_id FOREIGN KEY on teams id
- UNSIGNED BIGINT player_id FOREIGN KEY on players id
- INT (1) starter
- DATETIME created_at
- DATETIME updated_at

```php
Schema::create('game_player', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('game_id');
    $table->unsignedBigInteger('player_d');
    $table->boolean('starter')
    $table->timestamps();

    $table->foreign('game_id')
        ->references('id')
        ->on('games')
        ->onDelete('restrict');

    $table->foreign('player_d')
        ->references('id')
        ->on('players')
        ->onDelete('restrict');
});
```

### game_events
- UNSIGNED BIGINT AUTO_INCREMENTS id
- UNSIGNED BIGINT game_id FOREIGN KEY on teams id
- UNSIGNED BIGINT player_id NULLABLE FOREIGN KEY on players id
- VARCHAR(255) event
- UNSIGNED BIGINT replaced_player_id NULLABLE FOREIGN KEY on players id
- DATETIME created_at
- DATETIME updated_at

```php
Schema::create('game_events', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('game_id');
    $table->unsignedBigInteger('player_id')->nullable();
    $table->string('event')
    $table->unsignedBigInteger('replaced_player_id')->nullable();
    $table->timestamps();

    $table->foreign('game_id')
        ->references('id')
        ->on('games')
        ->onDelete('restrict');

    $table->foreign('player_id')
        ->references('id')
        ->on('players')
        ->onDelete('restrict');

    $table->foreign('replaced_player_id')
        ->references('id')
        ->on('players')
        ->onDelete('restrict');
});
```
