<?php

    class Game
    {
        private $correct_guesses;
        private $incorrect_guesses;
        private $chosen_word;

        function __construct($game_word) {
            $this->chosen_word = (string) $game_word;
            $this->correct_guesses = array();
            $length = (int) strlen($game_word);
            for ($index = 0; $index < $length; $index ++ ) {
                array_push($this->correct_guesses, '_');
            }
            $this->incorrect_guesses = array();
        }

        function getCorrectGuesses() {
            return $this->correct_guesses;
        }
        function setCorrectGuesses($index, $user_character) {
            $this->correct_guesses[$index] = $user_character;
        }
        function getIncorrectGuesses() {
            return $this->incorrect_guesses;
        }
        function setIncorrectGuesses($user_character) {
            array_push($this->incorrect_guesses, $user_character);
        }
        function getChosenWord() {
            return $this->chosen_word;
        }
        function save() {
            array_push($_SESSION['game'], $this);
        }

        static function getAll() {
            return $_SESSION['game'];
        }

        static function deleteAll() {
            $_SESSION['game'] = array();
        }
    }

 ?>
