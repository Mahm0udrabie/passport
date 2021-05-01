<?php 
namespace Modules\Blog\Repositories;

use Modules\Blog\Entities\Blog;
use Modules\Blog\Repositories\BlogRepositoryInterface;

class BlogRepository implements BlogRepositoryInterface
{
    public function index() {
        return Blog::all();
    }
}
