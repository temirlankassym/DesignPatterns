<?php

class Weapon{
    public string $type;
    public int $damage;
    public int $speed;
    public int $range;

    public function __construct(string $type, int $damage, int $speed, int $range){
        $this->type = $type;
        $this->damage = $damage;
        $this->speed = $speed;
        $this->range = $range;
    }
}

class Character{
    public string $name;
    public string $class;
    public Weapon $weapon;
    public int $health;
    public int $mana;

    public function __construct(string $name, string $class, Weapon $weapon, int $health, int $mana){
        $this->name = $name;
        $this->class = $class;
        $this->weapon = $weapon;
        $this->health = $health;
        $this->mana = $mana;
    }
}

class ConcreteCharacter extends Character{
    public function __construct(string $name, string $class, Weapon $weapon, int $health, int $mana){
        parent::__construct($name, $class, $weapon, $health, $mana);
    }
}

class ConcreteWeapon extends Weapon{
    public function __construct(string $type, int $damage, int $speed, int $range){
        parent::__construct($type, $damage, $speed, $range);
    }
}

abstract class CharacterFactory{
    public abstract function createCharacter(string $name);
    public abstract function createWeapon();
}

class WarriorSwordFactory extends CharacterFactory{
    public function createCharacter(string $name){
        echo 'Choose Stats for Health and Mana: ';
        $stats = explode(" ", readline());
        $character = new ConcreteCharacter($name, "Warrior", $this->createWeapon(), $stats[0], $stats[1]);
        return $character;
    }

    public function createWeapon(){
        echo "Choose sword Longsword/Katana/Claymore: ";
        $name = readline();

        if($name == "Longsword")
            return new ConcreteWeapon("Longsword", 10, 5, 2);
        else if ($name == "Katana")
            return new ConcreteWeapon("Katana", 15, 3, 1);
        else if ($name == "Claymore")
            return new ConcreteWeapon("Claymore", 5, 7, 3);
        else
            return null;
    }
}

class MageStaffFactory extends CharacterFactory{
    public function createCharacter(string $name){
        echo 'Choose Stats for Health and Mana: ';
        $stats = explode(" ", readline());
        $character = new ConcreteCharacter($name, "Mage", $this->createWeapon(), $stats[0], $stats[1]);
        return $character;
    }

    public function createWeapon(){
        echo "Choose staff Fire Staff/Ice Staff/Lightning Staff: ";
        $name = readline();

        if($name == "Fire Staff")
            return new ConcreteWeapon("Fire Staff", 20, 2, 5);
        else if ($name == "Ice Staff")
            return new ConcreteWeapon("Ice Staff", 15, 3, 4);
        else if ($name == "Lightning Staff")
            return new ConcreteWeapon("Lightning Staff", 25, 1, 6);
        else
            return null;
    }
}

class ArcherBowFactory extends CharacterFactory{
    public function createCharacter(string $name){
        echo 'Choose Stats for Health and Mana: ';
        $stats = explode(" ", readline());
        $character = new ConcreteCharacter($name, "Archer", $this->createWeapon(), $stats[0], $stats[1]);
        return $character;
    }

    public function createWeapon(){
        echo "Choose bow Longbow/Shortbow/Crossbow: ";
        $name = readline();

        if($name == "Longbow")
            return new ConcreteWeapon("Longbow", 10, 5, 10);
        else if ($name == "Shortbow")
            return new ConcreteWeapon("Shortbow", 5, 7, 8);
        else if ($name == "Crossbow")
            return new ConcreteWeapon("Crossbow", 15, 3, 12);
        else
            return null;
    }
}

class CharacterCreator{
    private CharacterFactory $factory;

    public function setFactory(CharacterFactory $factory){
        $this->factory = $factory;
    }

    public function createCharacter(string $name){
        return $this->factory->createCharacter($name);
    }
}

function client(){
    echo "Enter name: ";
    $name = readline();
    echo "Choose class Warrior/Mage/Archer: ";
    $class = readline();

    if($class == "Warrior")
        $factory = new WarriorSwordFactory();
    else if($class == "Mage")
        $factory = new MageStaffFactory();
    else if($class == "Archer")
        $factory = new ArcherBowFactory();
    else
        throw new Exception("Invalid class");

    $creator = new CharacterCreator();
    $creator->setFactory($factory);

    $character = $creator->createCharacter($name);
    print_r($character);
}

client();