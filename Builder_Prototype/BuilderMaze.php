<?php

require_once 'Maze.php';

interface MazeBuilderInterface{
    public function buildRooms();
    public function buildDoors();
    public function build();
}

class BaseMazeBuilder{
    private Maze $maze;

    public function __construct(){
        $this->maze = new Maze();
    }

    public function buildDoor(Room $r1, Room $r2, string $d1, string $d2){
        $door = new DoorWall($r1,$r2);
        $r1->setSide($d1,$door);
        $r2->setSide($d2,$door);
        return $door;
    }

    public function buildRoom(int $roomNo){
        $room = new Room($roomNo);
        $room->setSide(DIRECTION['n'],new Wall());
        $room->setSide(DIRECTION['e'],new Wall());
        $room->setSide(DIRECTION['s'],new Wall());
        $room->setSide(DIRECTION['w'],new Wall());
        $this->maze->addRoom($room);
    }

    public function getMaze(){
        return $this->maze;
    }

}

// Old Maze
class OldMazeBuilder extends BaseMazeBuilder implements MazeBuilderInterface {
    public function buildRooms(){
        $this->buildRoom(1);
        $this->buildRoom(2);
    }

    public function buildDoors(){
        $this->buildDoor($this->getMaze()->getRoom(1),$this->getMaze()->getRoom(2),'n','s');
    }

    public function build(){
        return $this->getMaze();
    }
}

//New Maze
class NewMazeBuilder extends BaseMazeBuilder implements MazeBuilderInterface {
    public function buildRooms(){
        $this->buildRoom(1);
        $this->buildRoom(2);
        $this->buildRoom(3);
        $this->buildRoom(4);
    }

    public function buildDoors(){
        $this->buildDoor($this->getMaze()->getRoom(1),$this->getMaze()->getRoom(2),'n','s');
        $this->buildDoor($this->getMaze()->getRoom(2),$this->getMaze()->getRoom(3),'n','s');
        $this->buildDoor($this->getMaze()->getRoom(3),$this->getMaze()->getRoom(4),'e','w');
    }

    public function build(){
        return $this->getMaze();
    }
}

class MazeGameDirector{
    public function createMaze(MazeBuilderInterface $builder){
        $builder->buildRooms();
        $builder->buildDoors();
        return $builder->build();
    }
}

function clientCode(MazeGameDirector $director){
    $oldMaze = $director->createMaze(new OldMazeBuilder());
    $newMaze = $director->createMaze(new NewMazeBuilder());

    print_r($oldMaze);
    print_r($newMaze);
}

$director = new MazeGameDirector();
clientCode($director);