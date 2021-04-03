<?php


namespace App;


use JetBrains\PhpStorm\Pure;

class Cart
{
    #[Pure] public function calculateDiscount() : int
    {
        return $this->isMultipleOf5() ? 50 : 0;
    }

    #[Pure] public function isMultipleOf5() : bool
    {
        return $this->getOrderNumber() % 5 === 0;
    }

    public function getOrderNumber() : int
    {
        return $_SESSION['orderNumber'];
    }
}