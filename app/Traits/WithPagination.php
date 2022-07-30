<?php

namespace App\Traits;

use Livewire\WithPagination as LivewireWithPagination;

trait WithPagination{
    use LivewireWithPagination;

    protected $paginationTheme = 'bootstrap';
}