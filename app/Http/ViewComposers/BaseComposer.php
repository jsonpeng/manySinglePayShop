<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;

use App\Repositories\SettingRepository;
use App\Repositories\MenuRepository;
use App\Repositories\LinkRepository;
use App\Repositories\BannerRepository;
use App\Repositories\CategoryRepository;

class BaseComposer
{
    private $categoryRepository;
    private $settingRepository;
    private $menuRepository;
    private $linkRepository;
    private $bannerRepository;

    public function __construct(
        CategoryRepository $categoryRepo,
        SettingRepository $settingRepo,
        MenuRepository $menuRepo,
        LinkRepository $linkRepo,
        BannerRepository $bannerRepo
    )
    {
        $this->categoryRepository = $categoryRepo;
        $this->settingRepository = $settingRepo;
        $this->menuRepository = $menuRepo;
        $this->linkRepository = $linkRepo;
        $this->bannerRepository = $bannerRepo;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {

   
        
    }
}
