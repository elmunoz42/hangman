<?php
    date_default_timezone_set('America/Los_Angeles');
    require_once __DIR__.'/../vendor/autoload.php';
    require_once __DIR__.'/../src/Game.php';

    session_start();

    if (empty($_SESSION['game'])) {
        $_SESSION['game'] = array();
    };

    $app = new Silex\Application();

    $app['debug'] = true;

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    $app->get('/', function() use($app) {

      return $app['twig']->render('home.html.twig', array('guesses' => Game::getAll()));

    });

    $app->post('/', function() use($app) {
        $game_words = array("peanut","butter", "elephant", "dog", "ant", "computer", "axiom", "affix", "azure", "ruby", "galaxy", "glowworm", "haphazard", "gizmo");

        $new_chosen_word = $game_words[rand(0, ((int)count($game_words)) - 1)];
        $new_game= new Game($new_chosen_word);
        Game::deleteAll();
        $new_game->save();
        return $app->redirect('/');
    });

    $app->post('/guess_action', function() use($app) {
        $guess_input = $_POST['guess_input'];
        $game_object = Game::getAll();
        $game_word = str_split ($game_object[0]->getChosenWord());
        $success = false;
        for ($index=0; $index<(int) sizeof($game_word); $index ++){
            if ($game_word[$index]==$guess_input){
                $game_object[0]->setCorrectGuesses($index, $guess_input);
                $success = true;
            }
        }
        if (!$success){
            $game_object[0]->setIncorrectGuesses($guess_input);
        }

        return $app->redirect('/');


    });

    return $app;
?>
