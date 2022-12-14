<?php

namespace App\Http\Livewire\Categories;

use App\Models\Category;
use App\Traits\WithPagination;
use Livewire\Component;

class Index extends Component
{
    use WithPagination;

    private $categories;
    public $search = '';

    public function render()
    {
        $this->setCategories();
        return view('livewire.categories.index', [
            'categories' => $this->categories
        ]);
    }

    private function setCategories(){
        if($this->search){
            $this->categories = Category::orWhere('name','ilike','%'.$this->search.'%')
            ->orWhere('short_name','ilike','%'.$this->search.'%')
            ->paginate(10);
        }else{
            $this->categories = Category::paginate(10);
        }
    }

    public function updatingSearch()
    {
        $this->gotoPage(1);
    }
}
