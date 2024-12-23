<?php

class Product
{
    protected $id;
    protected $name;
    protected $price;
    protected $description;

    // Constructor to initialize a new Product object with its properties.
    public function __construct(string $id, string $name, float $price, string $description)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->description = $description;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function updatePrice($newPrice)
    {
        $this->price = $newPrice;
    }

    public function applyDiscount($percentage)
    {
        // Calculate the new price after applying the discount
        $discountedPrice = $this->price - ($this->price * ($percentage / 100));
        // Use updatePrice method to set the new price
        $this->updatePrice($discountedPrice);
    }
}

class Food extends Product
{
    private $ingredients;
    private $macroNutrients;
    private $calories;

    public function __construct(string $id, string $name, float $price, string $description, array $ingredients, array $macroNutrients)
    {
        parent::__construct($id, $name, $price, $description);
        $this->ingredients = $ingredients;
        $this->standardizeIngredients();


        if (in_array('sugar', $ingredients) || in_array('palm oil', $ingredients) || in_array('salt', $ingredients)) {
            $this->description = "{$this->description} Beware: Do not consume too much.";
        }
        $this->macroNutrients = $macroNutrients;
        $this->updateCalories();

    }

    private function standardizeIngredients()
    {
        $this->ingredients = array_map('strtolower', $this->ingredients);
    }

    public function getMacroInfo(string $name): ?int
    {
        return $this->macroNutrients[$name] ?? 0;
    }

    public function updateCalories(): ?int
    {
        $multipliers = [
            'carbs' => 4,
            'proteins' => 4,
            'fats' => 9
        ];

        $total = 0;
        foreach ($multipliers as $key => $value) {
            $total += $value * ($this->macroNutrients[$key] ?? 0);
        }

        return $this->calories = $total;

    }

    public function applyDiscount($percentage): float
    {

        $discountedPrice = $this->price - ($this->price * ($percentage / 100));

        if ($this->calories < 200) {
            $discountedPrice = $discountedPrice - ($discountedPrice * (10 / 100));
        }

        $this->updatePrice($discountedPrice);

        return $this->price;

    }


}

$macroNutrients = [
    'carbs' => 30, // grams per serving
    'proteins' => 15, // grams per serving
    'fats' => 2 // grams per serving
];
//$food = new Food('id', 'name', 10.00, 'Granola bar', ['salt'], $macroNutrients, 0);

$foodItem = new Food("002", "High-Calorie Snack", 10.00, "Tasty high-calorie snack", ["Ingredient1", "Ingredient2"], $macroNutrients);
$foodItem->applyDiscount(20);

var_dump($foodItem->getPrice());

















