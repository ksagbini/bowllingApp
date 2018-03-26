<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Game;
use App\Frame;

class BowllingController extends Controller
{
    

    public function index(){

        $games = Game::all();
        return view('bowlling', ['games' => $games]);

    }


    public function newGame(){
        $game = new Game;
        $game->name = 'Game ' . (Game::all()->count() + 1);
        $game->score = 0;
        $game->save();
        return redirect('bowlling');
    }

    public function newFrame($game_id){


        $number_frame = count(Game::find($game_id)->frames) + 1;
        if($number_frame > 10){
            echo 'maximo';
            return redirect('bowlling');
        }


        $frame = new Frame();
        $frame->number = $number_frame;
        $frame->game_id = $game_id;
        $frame->score = 0;
        $frame->first_try = $this->getTry(0, 10);

        if($frame->first_try<10){
            $frame->second_try = $this->getTry(0, 10 - $frame->first_try);
            $frame->score = $frame->first_try + $frame->second_try < 10? $frame->first_try + $frame->second_try : 0;
        }
        else{
            $frame->second_try = 0;
        }

        if($frame->number == 10){
            if($frame->isStrike()){
                $frame->second_try = $this->getTry(0,10);
                $frame->bonus_try = $this->getTry(0,10);
            }

            if( $frame->isSpread()){
                $frame->bonus_try = $this->getTry(0,10);
            }
        }
        
        $frame->save();
        $this->updateScore($frame->game_id);
        return redirect('bowlling');

    }

    private function updateScore($game_id){
        
        $game = Game::find($game_id);
        
        $game_score = 0;
        $cont = 0;
        foreach ($game->frames as $frame){

            $lastFrame = $frame->number == 10;


            if($frame->isStrike()){

                //Search the first and the second frame (in case of double strike) to get the frames scores
                $frame->score = $frame->first_try;
                $next_frame = isset($game->frames[$cont+1]) ? $game->frames[$cont+1] : null;
                $next_two_frame = isset($game->frames[$cont+2]) ? $game->frames[$cont+2] : null;
    
                if($next_frame){

                    if($next_frame->isStrike()){
                        $frame->score += $next_frame->first_try;
                        if($next_two_frame){
                            $frame->score += $next_two_frame->first_try;
                        }
                    }
                    else{
                        $frame->score += $next_frame->first_try + $next_frame->second_try;
                    }
                }

            }
            else if($frame->isSpread()){

                //Search the next frame to get the first roll
                $next_frame = isset($game->frames[$cont+1]) ? $game->frames[$cont+1] : null;
                if($next_frame){
                    $frame->score = $frame->first_try + $frame->second_try + $next_frame->first_try;    
                }
                else{
                    $frame->score = $frame->first_try + $frame->second_try;
                }
            }
            else{
                $frame->score = $frame->first_try + $frame->second_try;
            }

            if($frame->number == 10) { 
                $frame->score+= $frame->second_try + $frame->bonus_try;
            }

            $frame->save();
            $game_score += $frame->score;
            $cont++;

        }

        $game->score = $game_score;
        $game->save();

    }

    

    private function getTry($min = 0, $max = 10){
        return rand($min, $max);
    }


}
