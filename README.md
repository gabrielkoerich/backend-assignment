# Backend Assignment

[![PHP Tests](https://github.com/gabrielkoerich/backend-assignment/actions/workflows/ci.yml/badge.svg)](https://github.com/gabrielkoerich/backend-assignment/actions/workflows/ci.yml)

### A) Design a SQL database to store NBA players, teams and games (column and table contents are all up to you). 

Users mostly query game results by date and team name. 

The second most frequent query is players statistics by player name.

#### teams
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

#### players
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

#### games
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

#### game_player
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

#### game_events
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

### B) How would you find files that begin with "0aH" and delete them given a folder (with subfolders)? Assume there are many files in the folder.

The function is implemented [here](https://github.com/gabrielkoerich/backend-assignment/blob/master/app/helpers.php#L10).

The helper file is loaded via composer.

The implementation is being tested [here](https://github.com/gabrielkoerich/backend-assignment/blob/master/tests/Unit/HelpersTest.php#L19).

Tests are runing on every push via [Github Actions](https://github.com/gabrielkoerich/backend-assignment/actions).

### C) Write a function that sorts 11 small numbers (<100) as fast as possible. Estimate how long it would take to execute that function 10 Billion (10^10) times on a normal machine?

The function is implemented [here](https://github.com/gabrielkoerich/backend-assignment/blob/master/app/helpers.php#L26).

Tests: https://github.com/gabrielkoerich/backend-assignment/blob/master/tests/Unit/HelpersTest.php#L46

On my machine (macbook pro m1 16gb) this was the results:

Run 1000 times in 11.060375 microseconds
It would take 30.723263888889 hours to run 10 billion times
It would take 1.2801359953704 days to run 10 billion times

Using PHP 8.

They run on the CI too:

https://github.com/gabrielkoerich/backend-assignment/runs/2756979907?check_suite_focus=true#step:7:6

Results:
Run 1000 times in 34.357115 microseconds
It would take 95.436430555556 hours to run 10 billion times
It would take 3.9765179398148 days to run 10 billion times

### D) Write a function that sorts 10000 powers (a^b) where a and b are random numbers between 100 and 10000? Estimate how long it would take on your machine?


