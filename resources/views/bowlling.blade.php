<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>BowllingApp</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    </head>
    <body>
        <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">
            <h5 class="my-0 mr-md-auto font-weight-normal">Bowlling App</h5>
        </div>
        <div class="px-3 py-3 pt-md-5 pb-md-4 mx-auto">
      <h1 class="display-4">Games</h1>
        <p>
            <a href="game/add" class="btn btn-primary">New Game</a>
        </p>

        <table class="table">
            <thead> 
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Score</th>
                    <th scope="col"># Frames</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @foreach($games as $game)
                <tr>
                    <td>{{$game->id}}</td>
                    <td>{{$game->name}}</td>
                    <td>{{$game->score}}</td>
                    <td>{{count($game->frames)}}</td>
                    <td><a href="frame/{{$game->id}}/add">Add Frames</a></td>
                </tr>
                <tr>
                    <td colspan="5">
                    
                        <div class="table-responsive">
                            <table width="100%">
                            <tr>
                                @foreach($game->frames as $frame)
                                <td>
                                    <p>Frame #{{ $frame->number }}</p>
                                    <p>Try 1: {{ $frame->first_try }}</p>
                                    <p>Try 2: {{ $frame->second_try }}</p>
                                    @if($frame->number == 10)
                                    <p>Bonus: {{$frame->bonus_try}}</p>
                                    @endif
                                    <p>Score: <strong>{{ $frame->score }}</strong></p>
                                </td>
                                @endforeach
                            </tr>
                            </table>  
                        </div>                      
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table> 
    </div>        
    </body>
</html>






