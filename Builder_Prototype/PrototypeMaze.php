<?php

require_once 'Maze.php';

//create old game
$maze = new Maze();

$room1 = new Room(1);
$room2 = new Room(2);
$door = new DoorWall($room1, $room2);

$maze->addRoom($room1);
$maze->addRoom($room2);

$room1->setSide(DIRECTION['n'], $door);
$room1->setSide(DIRECTION['e'], new Wall());
//...

print_r($maze);

//clone old game

$copyOfMaze = clone $maze;

print_r($copyOfMaze);
