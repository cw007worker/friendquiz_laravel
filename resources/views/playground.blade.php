@extends('Layout.canvas')
@section('content')

<div class="game-banner">

    <div class="pagination">
        <ul class="pagi">
            <li class="pagi1">1</li>
            <li class="pagi2">2</li>
            <li class="pagi3">3</li>
            <li class="pagi4">4</li>
            <li class="pagi5">5</li>
            <li class="pagi6">6</li>
            <li class="pagi7">7</li>
            <li class="pagi8">8</li>
            <li class="pagi9">9</li>
            <li class="pagi10">10</li>
            <li class="pagi11">11</li>
            <li class="pagi12">12</li>
            <li class="pagi13">13</li>
            <li class="pagi14">14</li>
            <li class="pagi15">15</li>
        </ul>
    </div>

    <div class="section-game">

        <form class="metaInfo">
            <input type="hidden" name="game_id" id="game_id" value="{{ $game_id }}">
            <input type="hidden" name="player_name" id="player_name" value="{{ $player_name }}">
            <input type="hidden" name="quiz_id" id="quiz_id" value="{{ bin2hex(random_bytes(3)) }}">
        </form>

        <div class="paper">
        </div>

    </div>

</div>

@stop
