<?php

class Furniture{
    private string $name;
    private string $style;
    private string $material;
    private float $price;

    public function __construct(string $name, string $style, string $material, float $price)
    {
        $this->name = $name;
        $this->style = $style;
        $this->material = $material;
        $this->price = $price;
    }

    public function getName(){
        return $this->name;
    }
}

class Chair extends Furniture{
    public function __construct(string $name, string $style, string $material, float $price)
    {
        parent::__construct($name, $style, $material, $price);
    }
}

class Table extends Furniture{
    public function __construct(string $name, string $style, string $material, float $price)
    {
        parent::__construct($name, $style, $material, $price);
    }
}

class Sofa extends Furniture{
    public function __construct(string $name, string $style, string $material, float $price)
    {
        parent::__construct($name, $style, $material, $price);
    }
}

abstract class FurnitureFactory{
    public abstract function createChair();
    public abstract function createTable();
    public abstract function createSofa();

    public function getList(array $furnitures){
        $list = [];
        foreach ($furnitures as $furniture){
            $list[] = $furniture->getName();
        }
        return $list;
    }
}

class ModernWoodFactory extends FurnitureFactory{
    protected array $chairs;
    protected array $tables;
    protected array $sofas;

    public function createChair(){
        $this->chairs = [new Chair('Gaming Chair', 'Modern', 'Wood', 100.0),
                        new Chair('Office Chair', 'Modern', 'Wood', 150.0)];

        echo "Choose a chair from the following: ".implode(', ', $this->getList($this->chairs))."\n";
        $option = readline();
        foreach($this->chairs as $chair){
            if($option==$chair->getName()){
                return $chair;
            }
        }
        echo "Invalid option\n";
    }

    public function createTable(){
        $this->tables = [new Table('Study Table', 'Modern', 'Wood', 199.99),
                        new Table('Dining Table', 'Modern', 'Wood', 250.0)];

        echo "Choose a table from the following: ".implode(', ', $this->getList($this->tables))."\n";
        $option = readline();
        foreach($this->tables as $table){
            if($option==$table->getName()){
                return $table;
            }
        }
        echo "Invalid option\n";
    }

    public function createSofa(){
        $this->sofas = [new Sofa('Cool Sofa', 'Modern', 'Wood', 300.0),
                        new Sofa('Comfy Sofa', 'Modern', 'Wood', 350.0)];

        echo "Choose a sofa from the following: ".implode(', ', $this->getList($this->sofas))."\n";
        $option = readline();
        foreach($this->sofas as $sofa){
            if($option==$sofa->getName()){
                return $sofa;
            }
        }
        echo "Invalid option\n";
    }
}

class TraditionalMetalFactory extends FurnitureFactory {
        protected array $chairs;
        protected array $tables;
        protected array $sofas;

        public function createChair(){
            $this->chairs = [new Chair('Cool Metal Chair', 'Traditional', 'Metal', 100.0),
                             new Chair('Heavy Chair', 'Traditional', 'Metal', 149.99)];

            echo "Choose a chair from the following: ".implode(', ', $this->getList($this->chairs))."\n";
            $option = readline();
            foreach($this->chairs as $chair){
                if($option==$chair->getName()){
                    return $chair;
                }
            }
            echo "Invalid option\n";
        }

        public function createTable(){
            $this->tables = [new Table('Antique Table', 'Traditional', 'Metal', 200.1),
                new Table('Coffee Table', 'Traditional', 'Metal', 250.0)];

            echo "Choose a table from the following: ".implode(', ', $this->getList($this->tables))."\n";
            $option = readline();
            foreach($this->tables as $table){
                if($option==$table->getName()){
                    return $table;
                }
            }
            echo "Invalid option\n";
        }

        public function createSofa(){
            $this->sofas = [new Sofa('Vintage Sofa', 'Traditional', 'Metal', 300.0),
                new Sofa('Classic Sofa', 'Traditional', 'Metal', 350.0)];

            echo "Choose a sofa from the following: ".implode(', ', $this->getList($this->sofas))."\n";
            $option = readline();
            foreach($this->sofas as $sofa){
                if($option==$sofa->getName()){
                    return $sofa;
                }
            }
            echo "Invalid option\n";
        }
}

class IndustrialGlassFactory extends FurnitureFactory{
        protected array $chairs;
        protected array $tables;
        protected array $sofas;

        public function createChair(){
            $this->chairs = [new Chair('Transparent Chair', 'Industrial', 'Glass', 100.0),
                             new Chair('Glass Chair', 'Industrial', 'Glass', 150)];

            echo "Choose a chair from the following: ".implode(', ', $this->getList($this->chairs))."\n";
            $option = readline();
            foreach($this->chairs as $chair){
                if($option==$chair->getName()){
                    return $chair;
                }
            }
            echo "Invalid option\n";
        }

        public function createTable(){
            $this->tables = [new Table('Glass Table', 'Industrial', 'Glass', 200),
                             new Table('Transparent Table', 'Industrial', 'Glass', 250.5)];

            echo "Choose a table from the following: ".implode(', ', $this->getList($this->tables))."\n";
            $option = readline();
            foreach($this->tables as $table){
                if($option==$table->getName()){
                    return $table;
                }
            }
            echo "Invalid option\n";
        }

        public function createSofa(){
            $this->sofas = [new Sofa('Glass Sofa', 'Industrial', 'Glass', 300),
                            new Sofa('Transparent Sofa', 'Industrial', 'Glass', 350)];

            echo "Choose a sofa from the following: ".implode(', ', $this->getList($this->sofas))."\n";
            $option = readline();
            foreach($this->sofas as $sofa){
                if($option==$sofa->getName()){
                    return $sofa;
                }
            }
            echo "Invalid option\n";
        }
}


class FurnitureCreator{
    private FurnitureFactory $factory;
    public function setFactory(FurnitureFactory $factory){
        $this->factory = $factory;
    }

    public function createChair(){
        return $this->factory->createChair();
    }

    public function createTable(){
        return $this->factory->createTable();
    }

    public function createSofa(){
        return $this->factory->createSofa();
    }
}

function client(){
    echo 'Select style Industrial, Traditional, Modern: ';
    $style = readline();

    if ($style == 'Industrial')
        $factory = new IndustrialGlassFactory();
    elseif ($style == 'Traditional')
        $factory = new TraditionalMetalFactory();
    elseif ($style == 'Modern')
        $factory = new ModernWoodFactory();
    else
        echo "Invalid style\n";

    $furnitureCreator = new FurnitureCreator();
    $furnitureCreator->setFactory($factory);

    $chair = $furnitureCreator->createChair();
    $table = $furnitureCreator->createTable();
    $sofa = $furnitureCreator->createSofa();
    print_r($chair);
    print_r($table);
    print_r($sofa);
}

client();
