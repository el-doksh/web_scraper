<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use App\Services\ScraperService;

class ProductController extends BaseApiController
{
    private ProductService $productService;
    private ScraperService $scraperService;

    public function __construct() {
        $productService = new ProductService();
        $scraperService = new ScraperService();

        $this->productService = $productService;
        $this->scraperService = $scraperService;
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->fetch_products();
        $products = $this->productService->getAll();
        $productsResource = ProductResource::collection($products);

        return $this->successResponse($productsResource);
    }

    public function fetch_products()
    {
        $url = 'https://www.jumia.com.eg/mlp-128gb-phones';
        $isFetched = $this->scraperService->fetchProduct($url);

        if($isFetched) {
            return $this->successResponse();
        } 
        return $this->errorResponse();
    }
}
