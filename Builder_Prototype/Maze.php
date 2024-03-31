<?php

interface Cloneable{
    public function __clone();
}

const DIRECTION = [
    'n'=>'NORTH',
    'e'=>'EAST',
    's'=>'SOUTH',
    'w'=>'WEST'
];

class Wall
{

}

class DoorWall extends Wall
{
    private Room $r1;
    private Room $r2;
    private bool $isOpen = false;

    public function __construct(Room $r1, Room $r2)
    {
        $this->r1 = $r1;
        $this->r2 = $r2;
    }
}

class Room implements Cloneable {
    private array $sides = [];
    public int $roomNo;

    public function __construct(int $roomNo)
    {
        $this->roomNo = $roomNo;
    }

    public function getSide(string $direction): Wall
    {
        return $this->sides[$direction];
    }

    public function setSide(string $direction, Wall $wall): void
    {
        $this->sides[$direction] = $wall;
    }

    public function getRoomNo(){
        return $this->roomNo;
    }

    //cloned roomsNo starts with 100
    public function __clone(): void{
        $this->roomNo += 100;
    }
}

class Maze implements Cloneable {
    private array $rooms = [];

    public function addRoom(Room $room): void
    {
        $this->rooms[$room->getRoomNo()] = $room;
    }

    public function getRoom(int $roomNo): Room
    {
        return $this->rooms[$roomNo];
    }

    //cloning rooms
    public function __clone(){
        $copyOfRooms = [];
        foreach ($this->rooms as $room) {
            $copyOfRooms[] = clone $room;
        }
        $this->rooms = $copyOfRooms;
    }
}