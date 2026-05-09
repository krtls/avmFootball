<?php

use App\Livewire\PlayerShotSpeedBoard;
use App\Models\Player;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

test('shot speed page can be rendered', function () {
    $this->actingAs(User::factory()->create());

    $response = $this->get(route('shot-speed.index'));

    $response->assertOk();
});

test('a player and shot speed can be recorded', function () {
    Livewire::test(PlayerShotSpeedBoard::class)
        ->set('playerName', 'Kylian Mbappe')
        ->set('shotSpeed', 131.4)
        ->call('savePlayer')
        ->assertSet('playerName', '')
        ->assertSet('shotSpeed', null);

    $this->assertDatabaseHas('players', [
        'name' => 'Kylian Mbappe',
        'shot_speed_kmh' => 131.4,
    ]);
});

test('players are listed from highest speed to lowest speed', function () {
    Player::factory()->create(['name' => 'Player Low', 'shot_speed_kmh' => 95.0]);
    Player::factory()->create(['name' => 'Player Top', 'shot_speed_kmh' => 128.3]);
    Player::factory()->create(['name' => 'Player Mid', 'shot_speed_kmh' => 108.7]);

    Livewire::test(PlayerShotSpeedBoard::class)
        ->assertSeeInOrder(['Player Top', 'Player Mid', 'Player Low']);
});

test('leaderboard is paginated', function () {
    Player::factory()->count(21)->create();

    Livewire::test(PlayerShotSpeedBoard::class)
        ->assertSee('Next');
});

test('a player can be updated from the board', function () {
    $player = Player::factory()->create([
        'name' => 'Old Name',
        'shot_speed_kmh' => 90.0,
    ]);

    Livewire::test(PlayerShotSpeedBoard::class)
        ->call('startEditing', $player->id)
        ->set('editPlayerName', 'New Name')
        ->set('editShotSpeed', 111.5)
        ->call('updatePlayer', $player->id)
        ->assertSet('editingPlayerId', null);

    $this->assertDatabaseHas('players', [
        'id' => $player->id,
        'name' => 'New Name',
        'shot_speed_kmh' => 111.5,
    ]);
});

test('a player can be deleted from the board', function () {
    $player = Player::factory()->create();

    Livewire::test(PlayerShotSpeedBoard::class)
        ->call('deletePlayer', $player->id);

    $this->assertDatabaseMissing('players', [
        'id' => $player->id,
    ]);
});
