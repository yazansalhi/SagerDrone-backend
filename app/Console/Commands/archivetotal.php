<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Product;
use App\Category;
use App\User;
use App\TotalArchives;


class archivetotal extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:set-total-archive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Archive total data of (product,category,users) every night at 12 AM';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalUsers = User::count();

        $totalArchives =  new TotalArchives();
        $totalArchives->products = $totalProducts;
        $totalArchives->categories = $totalCategories;
        $totalArchives->users = $totalUsers;
        $totalArchives->save();

    }
}
