<?php

class Appearance{
    private $description;
    public function __construct($description){
        $this->description = $description;
    }
}

class Ability{
    private string $name;

    public function __construct(string $name){
        $this->name = $name;
    }
}

class Equipment{
    private string $name;
    public function __construct(string $name){
        $this->name = $name;
    }
}

class Attributes{
    private $health;
    private $mana;
    private $strength;

    public function __construct(array $attributes){
        $this->health = $attributes[0];
        $this->mana = $attributes[1];
        $this->strength = $attributes[2];
    }
}

class Character{
    public string $name;
    public Appearance $appearance;
    public array $abilities;
    public array $equipment;
    public Attributes $attributes;

    public function __construct(string $name){
        $this->name = $name;
    }

    protected function setAbilities(Ability $ability){
        $this->abilities[] = $ability;
    }
}

abstract class CharacterFactory{

    abstract public function createCharacter(string $name);

    public function chooseEquipments(Character $character, $equipments = []) {
        echo "Choose your Equipments: ".implode(", ", $equipments)."\n";
        $equipments = explode(" ",readline());
        $character->equipment = [];
        foreach ($equipments as $equipment){
            $character->equipment[] = new Equipment($equipment);
        }
    }

    public function chooseAppearance(Character $character, $appearances = []) {
        echo "Choose your Appearance: ".implode(", ", $appearances)."\n";
        $character->appearance = new Appearance(readline());
    }

    public function chooseAbilities(Character $character, $abilities = []) {
        echo "Choose your Abilities: ".implode(", ", $abilities)."\n";
        $abilities = explode( " ",readline());
        $character->abilities = [];
        foreach ($abilities as $ability){
            $character->abilities[] = new Ability($ability);
        }
    }

    public function chooseAttributes(Character $character, $attributes = []) {
        echo "Choose stats for Attributes: ".implode(", ", $attributes)."\n";
        $character->attributes = new Attributes(explode(" ",readline()));
    }

    public function changeEquipments(Character $character){
        echo "Changing Equipments\n";
        $this->chooseEquipments($character);
    }

    public function changeAppearance(Character $character){
        echo "Changing Appearance\n";
        $this->chooseAppearance($character);
    }

    public function changeAbilities(Character $character){
        echo "Changing Abilities\n";
        $this->chooseAbilities($character);
    }

    public function changeAttributes(Character $character){
        echo "Changing Attributes\n";
        $this->chooseAttributes($character);
    }
}

class WarriorFactory extends CharacterFactory{
    public function createCharacter(string $name){
        $character = new Character("Warrior ".$name);
        $this->chooseAbilities($character, ["Slash", "Block", "Charge"]);
        $this->chooseAttributes($character, ["Health", "Mana", "Strength"]);
        $this->chooseEquipments($character, ["Sword", "Shield", "Axe"]);
        $this->chooseAppearance($character, ["Tall", "Short", "Muscular"]);
        return $character;
    }
}

class MageFactory extends CharacterFactory{
    public function createCharacter(string $name){
        $character = new Character("Mage ".$name);
        $this->chooseAbilities($character, ["Fireball", "Iceball", "Thunder"]);
        $this->chooseAttributes($character, ["Health", "Mana", "Strength"]);
        $this->chooseEquipments($character, ["Staff", "Wand", "Orb"]);
        $this->chooseAppearance($character, ["Tall", "Short", "Slim"]);
        return $character;
    }
}

class ArcherFactory extends CharacterFactory{
    public function createCharacter(string $name) {
        $character = new Character("Archer ".$name);
        $this->chooseAbilities($character, ["Arrow shot", "Dodge", "Stealth"]);
        $this->chooseAttributes($character, ["Health", "Mana", "Strength"]);
        $this->chooseEquipments($character, ["Bow", "Arrow", "Crossbow"]);
        $this->chooseAppearance($character, ["Tall", "Short", "Slim"]);
        return $character;
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

    public function changeEquipments($character){
        $this->factory->changeEquipments($character);
    }
    public function changeAppearance($character){
        $this->factory->changeAppearance($character);
    }
    public function changeAbilities($character){
        $this->factory->changeAbilities($character);
    }
    public function changeAttributes($character){
        $this->factory->changeAttributes($character);
    }
}

function client(CharacterFactory $factory){
    $characterCreator = new CharacterCreator();
    $characterCreator->setFactory($factory);
    $character = $characterCreator->createCharacter(readline("Enter your name: "));
    print_r($character);

    //changing our character
    $characterCreator->changeAbilities($character);
    $characterCreator->changeAttributes($character);
    $characterCreator->changeEquipments($character);
    $characterCreator->changeAppearance($character);
    print_r($character);
}

$factory = new ArcherFactory();
client($factory);