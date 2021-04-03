<?php


namespace tests;


use App\Cart;
use PHPUnit\Framework\TestCase;

class CartTest extends TestCase
{
    public function testCalculateDiscount() : void
    {
        $cart = $this->getMockBuilder(Cart::class)
            ->setMethods(['isMultipleOf5'])
            ->getMock();
        $cart->method('isMultipleOf5')->willReturn(true);
        $this->assertEquals(50, $cart->calculateDiscount());
    }

    public function testCalculateDiscountZero() : void
    {
        $cart = $this->getMockBuilder(Cart::class)
            ->disableOriginalConstructor()
            ->setMethods(['isMultipleOf5'])
            ->getMock();
        $cart->method('isMultipleOf5')->willReturn(false);
        $this->assertEquals(0, $cart->calculateDiscount());
    }

    /**
     * @dataProvider dataProvider
     */
    public function testIsMultipleOf5(int $orderNumber, bool $expected) : void
    {
        $cart = $this->getMockBuilder(Cart::class)
            ->disableOriginalConstructor()
            ->setMethods(['getOrderNumber'])
            ->getMock();

        $cart->method('getOrderNumber')->willReturn($orderNumber);
        $this->assertEquals($expected, $cart->isMultipleOf5());
    }

    public function dataProvider() : array
    {
        return [
            [ 'orderNumber' => 5,
                'expected' => true
            ],
            [ 'orderNumber' => 1,
                'expected' => false
            ],
            [ 'orderNumber' => 15,
                'expected' => true
            ],
        ];
    }

    /**
     * @dataProvider dataProviderOrderNumber
     * @param int $orderNumber
     * @param int $expected
     */
    public function testGetOrderNumber(int|string $orderNumber, int $expected) : void
    {
        $_SESSION['orderNumber'] = $orderNumber;
        $cart = new Cart();
        $this->assertSame($expected, $cart->getOrderNumber());
    }

    public function dataProviderOrderNumber() : array
    {
        return [
            [
                'orderNumber' => 1,
                'expected' => 1
            ],
            [
                'orderNumber' => 5,
                'expected' => 5
            ],
            [
                'orderNumber' => "100500",
                'expected' => 100500
            ],
        ];
    }
}