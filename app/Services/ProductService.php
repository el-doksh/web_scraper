<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    /**
     * retrieve list of products based on filteration
     * @param array $filters
     * @param int $limit
     */
    public function getAll(array $filters = [], $limit = 20)
    {
        return Product::search($filters)->latest()->paginate($limit);
    }


    /**
     * Create or update a product
     * @param string $title
     * @param float $price
     * @param string $imageUrl
     * @return bool
     */
    public function createProduct(string $title, float $price, string $imageUrl) : bool
    {
        try {
            $product = Product::where('title', $title)->first();
            if($product) {
                $product->update([
                    'price' => $price,
                    'image_url' => $imageUrl,
                ]);
            } else {
                $product = Product::Create([
                    'title' => $title,
                    'price' => $price,
                    'image_url' => $imageUrl,
                ]);
            }

            return true;
        } catch (\Throwable $th) {

            return false;
        }
    }
}