<?php

namespace App\Http\Controllers\Front;

use App\Shop\Categories\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Shop\Products\Repositories\ProductRepository;
use App\Shop\Products\Product;
use App\Shop\Products\Transformations\ProductTransformable;
use Illuminate\Http\Request;

class HomeController
{
    use ProductTransformable;

    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepo;
    private $productRepo;

    /**
     * HomeController constructor.
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(CategoryRepositoryInterface $categoryRepository, ProductRepository $productRepo)
    {
        $this->categoryRepo = $categoryRepository;
        $this->productRepo = $productRepo;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    /* public function index() // Old code
    {
        $cat1 = $this->categoryRepo->findCategoryById(2);
        $cat1->products = $cat1->products->map(function (Product $item) {
            return $this->transformProduct($item);
        });

        $cat2 = $this->categoryRepo->findCategoryById(3);
        $cat2->products = $cat2->products->map(function (Product $item) {
            return $this->transformProduct($item);
        });

      $cat3 = $this->categoryRepo->findCategoryById(1);
      $cat3->products = $cat3->products->map(function (Product $item) {
        return $this->transformProduct($item);
      });

        return view('front.index', compact('cat1', 'cat2', 'cat3'));
    } */

    public function index(Request $request)
    {
        $products = $this->productRepo->paginate();
        $productData = $products->map(function (Product $item) {
            return $this->transformProduct($item);
        });

        return view('client.homepage', compact('productData', 'products'));
    }

    public function faqsPage()
    {
        return view('client.page.faqs');
    }

    public function termsOfServicePage()
    {
        return view('client.page.terms_of_service');
    }

    public function privacyPolicyPage()
    {
        return view('client.page.privacy_policy');
    }

    public function paymentMethodsPage()
    {
        return view('client.page.payment_methods');
    }

    public function returnPolicyPage()
    {
        return view('client.page.return_policy');
    }
}
