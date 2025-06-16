<?php

namespace App\Services;

use GuzzleHttp\Client;
use Exception;
use Symfony\Component\DomCrawler\Crawler;

class ScraperService
{
    private ProductService $productService;
    
    public function __construct() {
        $productService = new ProductService();
        $this->productService = $productService;
    }

    public function fetchProduct($url)
    {
        try {
            $client = new Client(['verify' => false]);
            $response = $client->request('GET', $url, [
                                            'headers' => [
                                                'User-Agent' => $this->getRandomUserAgent(),
                                                // 'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9',
                                                // 'Accept-Language' => 'en-US,en;q=0.9',      
                                            ],
                                            // Optional: proxy from Golang microservice
                                        ]);
            $html = (string) $response->getBody();
            $crawler = new Crawler($html);

            $crawler->filter('.c-prd')->each(function($product) {
                $productTitle = $product->filter('.name')->text(). '</br>';
                $productPrice = $product->filter('.prc')->text(). '</br>';
                $productImage = $product->filter('.img')->attr('data-src') .'</br>';
                $this->productService->createProduct($productTitle, 430, $productImage);
            });

            return true;

        } catch (Exception $err) {
            throw $err;
        }
    }


    private function getRandomUserAgent() {
        
        return array_rand([
            'Mozilla/5.0 (Linux\; Android 9\; Mi MIX 2S) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.111 Mobile Safari/537.36',
            'Mozilla/5.0 (Linux; Linux i656 ) Gecko/20100101 Firefox/49.5',
            'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 10.0; Win64; x64 Trident / 5.0)',
        ]);
    }
}
