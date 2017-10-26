<?php

namespace Tests\Http\Controllers\Panel;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Panel\PanelBaseTestCase;

class CategoryControllerTest extends PanelBaseTestCase
{
    use RefreshDatabase;

    public $route = 'back.category';

    public $model = Category::class;
}
