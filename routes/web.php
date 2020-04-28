<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('decorator', function () {

    // // base
    // interface CarService{
    //     public function getCost();

    //     public function getDescription();
    // }
    // // component
    // class BasicInspection implements CarService {
    //     public function getCost()
    //     {
    //         return 19;
    //     }

    //     public function getDescription()
    //     {
    //         return 'a basic inspection';
    //     }
    // }

    // // decorator
    // class OilChange implements CarService {

    //     protected $carService;

    //     public function __construct(CarService $carService)
    //     {
    //         $this->carService = $carService;
    //     }

    //     public function getCost()
    //     {
    //         return 29 + $this->carService->getCost();
    //     }

    //     public function getDescription()
    //     {
    //         return $this->carService->getDescription() . ' and oil change';
    //     }
    // }

    // // decorator
    // class TireRotation implements CarService {

    //     protected $carService;

    //     public function __construct(CarService $carService)
    //     {
    //         $this->carService = $carService;
    //     }

    //     public function getCost()
    //     {
    //         return 15 + $this->carService->getCost();
    //     }

    //     public function getDescription()
    //     {
    //         return $this->carService->getDescription() . ' and tire rotation';
    //     }
    // }

    // $service = new BasicInspection;

    // $service = new OilChange($service);

    // $service = new TireRotation($service);

    // return 'Service: ' . $service->getDescription() . ' at: ' . $service->getCost();


    // case 2
    // delivery product

    // $sale = new Sale($amount);

    // $sale = new DeliveryCost($sale);

    // $sale = new CouponSale($sale);

    // $sale = new Tax($sale);

    interface DeliveryService {

        public function rate();

    }

    class FedexService implements DeliveryService {

        public function rate()
        {
            // it can calc with more variables distance, country, time but in this example only this
            return '500';
        }
    }

    interface SaleCalculation {

        public function cost();

    }

    class Sale implements SaleCalculation {

        protected $price;

        public function __construct($price)
        {
            $this->price = $price;
        }

        public function cost()
        {
            return $this->price;
        }
    }

    class DeliveryCost implements SaleCalculation {

        protected $saleCalculation;
        protected $deliveryServiceCost;

        public function __construct(SaleCalculation $saleCalculation, DeliveryService $deliveryServiceCost)
        {
            $this->saleCalculation = $saleCalculation;
            $this->deliveryServiceCost = $deliveryServiceCost;
        }

        public function cost()
        {
            return $this->saleCalculation->cost() + $this->deliveryServiceCost->rate();
        }
    }

    $sale = new Sale(200);
    $sale = new DeliveryCost($sale, new FedexService);
    return $sale->cost();

});
