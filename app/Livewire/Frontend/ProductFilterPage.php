<?php

namespace App\Livewire\Frontend;

use App\Models\Brands;
use App\Models\Categories;
use App\Models\Products;
use App\Models\Productvars;
use App\Models\Subcategories;
use Livewire\Component;
use Livewire\WithPagination;

class ProductFilterPage extends Component
{
    use WithPagination;

    public array $selectedCategories = [];

    protected $queryString = [
        'selectedCategories' => ['except' => []],
        'selectedSubcategories' => ['except' => []],
        'selectedChildCategories' => ['except' => []],
        'selectedBrands' => ['except' => []],
        'selectedVariants' => ['except' => []],
        'minPrice' => ['except' => null],
        'maxPrice' => ['except' => null],
        'sortBy' => ['except' => 'none'],
        'search' => ['except' => ''],
    ];

    public array $selectedSubcategories = [];
    public array $selectedChildCategories = [];
    public array $selectedBrands = [];
    public array $selectedVariants = [];
    public ?float $minPrice = null;
    public ?float $maxPrice = null;
    public string $sortBy = 'none';
    public string $search = '';

    public function mount(?int $category = null, ?int $subcategory = null, ?int $childCategory = null, ?int $brand = null, ?string $q = null): void
    {
        if ($category) $this->selectedCategories = [$category];
        if ($subcategory) $this->selectedSubcategories = [$subcategory];
        if ($childCategory) $this->selectedChildCategories = [$childCategory];
        if ($brand) $this->selectedBrands = [$brand];
        if ($q) $this->search = trim($q);
    }

    public function updating($name): void
    {
        if (str_starts_with($name, 'selected') || in_array($name, ['minPrice', 'maxPrice', 'sortBy', 'search'], true)) {
            $this->resetPage();
        }
    }

    public function updatedSelectedCategories(): void
    {
        $this->selectedSubcategories = [];
        $this->selectedChildCategories = [];
        $this->selectedVariants = [];
    }

    public function updatedSelectedSubcategories(): void
    {
        $this->selectedChildCategories = [];
        $this->selectedVariants = [];
    }

    public function clearFilters(): void
    {
        $this->reset([
            'selectedCategories', 'selectedSubcategories', 'selectedChildCategories',
            'selectedBrands', 'selectedVariants', 'minPrice', 'maxPrice'
        ]);
        $this->sortBy = 'none';
    }
    public function clearAll(): void
    {
        $this->reset([
            'selectedCategories',
            'selectedSubcategories',
            'selectedChildCategories',
            'selectedBrands',
            'selectedVariants',
            'minPrice',
            'maxPrice',
            'search' // 🔥 kritik
        ]);

        $this->sortBy = 'none';
    }
    public function render()
    {
        $hasSelectedCategories = !empty($this->selectedCategories);

        $categories = Categories::orderBy('category_title')->get();
        $subcategories = collect();
        $childCategories = collect();

        if ($hasSelectedCategories) {
            $subcategories = Subcategories::whereNull('parent_id')
                ->whereIn('top_category', $this->selectedCategories)
                ->orderBy('sub_title')
                ->get();

            if (!empty($this->selectedSubcategories)) {
                $childCategories = Subcategories::whereNotNull('parent_id')
                    ->whereIn('parent_id', $this->selectedSubcategories)
                    ->orderBy('sub_title')
                    ->get();
            }
        }

        $query = Products::query()->where('status', 1)
            ->when(!empty($this->selectedCategories), fn($q) => $q->whereIn('category', $this->selectedCategories))
            ->when(!empty($this->selectedBrands), fn($q) => $q->whereIn('brand', $this->selectedBrands))
            ->when($this->search !== '', function ($q) {
                $term = trim($this->search);
                $q->where(function ($inner) use ($term) {
                    $inner->where('title', 'like', '%' . $term . '%')
                        ->orWhere('product_token', 'like', '%' . $term . '%');
                });
            });

        if (!empty($this->selectedChildCategories)) {
            $query->whereIn('sub_category', $this->selectedChildCategories);
        } elseif (!empty($this->selectedSubcategories)) {
            $childIds = Subcategories::whereIn('parent_id', $this->selectedSubcategories)->pluck('id');
            $query->where(function ($q) use ($childIds) {
                $q->whereIn('sub_category', $this->selectedSubcategories)
                    ->orWhereIn('sub_category', $childIds);
            });
        }

        if ($this->minPrice !== null) {
            $query->where('price', '>=', $this->minPrice);
        }
        if ($this->maxPrice !== null) {
            $query->where('price', '<=', $this->maxPrice);
        }

        if (!empty($this->selectedVariants)) {
            $query->whereIn('id', Productvars::whereIn('variant_name', $this->selectedVariants)->pluck('product_id'));
        }

        $brands = collect();
        $variantGroups = collect();

        if ($hasSelectedCategories) {
            $brands = Brands::whereIn('id', (clone $query)->select('brand')->distinct()->pluck('brand'))
                ->orderBy('brand_title')
                ->get();

            $variantGroups = Productvars::whereIn('product_id', (clone $query)->select('id')->pluck('id'))
                ->whereNotNull('variant_type')
                ->whereNotNull('variant_name')
                ->orderBy('variant_type')
                ->orderBy('variant_name')
                ->get(['variant_type', 'variant_name'])
                ->groupBy('variant_type')
                ->map(fn($items) => $items->pluck('variant_name')->unique()->values());
        }


        $selectedCategoryNames = Categories::whereIn('id', $this->selectedCategories)->pluck('category_title');
        $selectedSubcategoryNames = Subcategories::whereIn('id', $this->selectedSubcategories)->pluck('sub_title');
        $selectedBrandNames = Brands::whereIn('id', $this->selectedBrands)->pluck('brand_title');

        match ($this->sortBy) {
            'a_z' => $query->orderBy('title'),
            'z_a' => $query->orderByDesc('title'),
            'price_asc' => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            default => $query->latest('id'),
        };

        return view('livewire.frontend.product-filter-page', [
            'products' => $query->paginate(12),
            'categories' => $categories,
            'subcategories' => $subcategories,
            'childCategories' => $childCategories,
            'brands' => $brands,
            'variantGroups' => $variantGroups,
            'hasSelectedCategories' => $hasSelectedCategories,
            'selectedCategoryNames' => $selectedCategoryNames,
            'selectedSubcategoryNames' => $selectedSubcategoryNames,
            'selectedBrandNames' => $selectedBrandNames,
            'searchTerm' => $this->search,
        ]);
    }
}
