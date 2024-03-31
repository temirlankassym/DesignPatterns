<?php

class MacroNutrients{
    public int $carbohydrates;
    public int $proteins;
    public int $fats;
}

class NutritionPlan{
    public int $dailyCaloricIntake;
    public MacroNutrients $macroNutrientsRatios;
    public array $mealPlans;
    public string $fitnessGoal;
    public array $dietaryRestrictions;
}

class NutritionPlanBuilder {
    private NutritionPlan $nutritionPlan;

    public function __construct(){
        $this->nutritionPlan = new NutritionPlan();
        $this->nutritionPlan->macroNutrientsRatios = new MacroNutrients();
    }

    public function setCaloricIntake(int $calories){
        $this->nutritionPlan->dailyCaloricIntake = $calories;
    }

    public function setMacronutrientRatios(int $carbohydrates, int $proteins, int $fats){
        $this->nutritionPlan->macroNutrientsRatios->carbohydrates = $carbohydrates;
        $this->nutritionPlan->macroNutrientsRatios->proteins = $proteins;
        $this->nutritionPlan->macroNutrientsRatios->fats = $fats;
    }

    public function setMealPlans(array $mealPlans){
        $this->nutritionPlan->mealPlans = $mealPlans;
    }

    public function setFitnessGoal(string $fitnessGoal){
        $this->nutritionPlan->fitnessGoal = $fitnessGoal;
    }

    public function setDietaryRestrictions(array $dietaryRestrictions = []){
        $this->nutritionPlan->dietaryRestrictions = $dietaryRestrictions;
    }

    public function build(){
        return $this->nutritionPlan;
    }
}

class NutritionPlanDirector{
    public NutritionPlanBuilder $nutritionPlanBuilder;

    public function setBuilder(NutritionPlanBuilder $nutritionPlanBuilder): void{
        $this->nutritionPlanBuilder = $nutritionPlanBuilder;
    }

    public function crateNutritionPlan(): NutritionPlan{
        //default parameters
        $this->nutritionPlanBuilder->setCaloricIntake(0);
        $this->nutritionPlanBuilder->setMacronutrientRatios(0,0,0);
        $this->nutritionPlanBuilder->setMealPlans([]);
        $this->nutritionPlanBuilder->setFitnessGoal('');
        return $this->nutritionPlanBuilder->build();
    }
}

class WeightLossNutritionPlanBuilder extends NutritionPlanBuilder {
    public function setCaloricIntake(int $calories){
        parent::setCaloricIntake(1200);
    }
    public function setMacronutrientRatios(int $carbohydrates, int $proteins, int $fats){
        parent::setMacronutrientRatios(50, 30, 20);
    }

    public function setMealPlans(array $mealPlans){
        parent::setMealPlans(['vegetables', 'fish', 'chicken']);
    }

    public function setFitnessGoal(string $fitnessGoal){
        parent::setFitnessGoal('lose weight');
    }

    public function setDietaryRestrictions(array $dietaryRestrictions = []){
        parent::setDietaryRestrictions($dietaryRestrictions);
    }
}

class WeightGainNutritionPlanBuilder extends NutritionPlanBuilder{
    public function setCaloricIntake(int $calories){
        parent::setCaloricIntake(3000);
    }
    public function setMacronutrientRatios(int $carbohydrates, int $proteins, int $fats){
        parent::setMacronutrientRatios(40, 30, 30);
    }
    public function setMealPlans(array $mealPlans){
        parent::setMealPlans(['rice', 'beans', 'beef']);
    }
    public function setFitnessGoal(string $fitnessGoal){
        parent::setFitnessGoal('gain weight');
    }
    public function setDietaryRestrictions(array $dietaryRestrictions = []){
        parent::setDietaryRestrictions($dietaryRestrictions);
    }
}

class MaintenanceNutritionPlanBuilder extends NutritionPlanBuilder{
    public function setCaloricIntake(int $calories){
        parent::setCaloricIntake(2000);
    }
    public function setMacronutrientRatios(int $carbohydrates, int $proteins, int $fats){
        parent::setMacronutrientRatios(40, 30, 30);
    }
    public function setMealPlans(array $mealPlans){
        parent::setMealPlans(['eggs', 'beans', 'chicken']);
    }
    public function setFitnessGoal(string $fitnessGoal){
        parent::setFitnessGoal('maintain weight');
    }
    public function setDietaryRestrictions(array $dietaryRestrictions = []){
        parent::setDietaryRestrictions($dietaryRestrictions);
    }
}

function clientCode($director){
    $builder = new WeightLossNutritionPlanBuilder();
    $builder->setDietaryRestrictions(['vegan', 'gluten-free']);
    $director->setBuilder($builder);
    print_r($director->crateNutritionPlan());

    $builder = new WeightGainNutritionPlanBuilder();
    $builder->setDietaryRestrictions(['lactose-free']);
    $director->setBuilder($builder);
    print_r($director->crateNutritionPlan());

    $builder = new MaintenanceNutritionPlanBuilder();
    $director->setBuilder($builder);
    print_r($director->crateNutritionPlan());
}

$director = new NutritionPlanDirector();
clientCode($director);