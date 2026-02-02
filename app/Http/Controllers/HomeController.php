<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\{LinkRouteController, Module, Page, Outil, User};
use App\RefactoringItems\SaveModelController;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\Environment\Console;
use Illuminate\Http\Request;

class HomeController extends SaveModelController
{
    /**
     * @var \Illuminate\Database\Eloquent\Collection
     */
    protected $modules;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->modules = Module::with(['modules', 'pages', 'mode_link'])->whereNull('module_id')->orderBy('order')->get();
    }

    public function getModules()
    {
        if (Auth::check())
        {
            $modules_access = array();
            foreach ($this->modules as $module)
            {
                $can_access = false;
                $pages_col = array();
                $all_pages_col = array();
                foreach($module->pages as $keyPage => $page)
                {
                     //if ($module->id==5 && $keyPage==3)
                        //dd($module->pages, 'ja', $page->permissions, Outil::hasOnePermissionOf($page->permissions));
                    $modules_col = array();
                    foreach($module->modules as $keySubModule => $SubModule)
                    {
                        $can_access_sub_module = false;
                        $sub_pages_col = array();
                        $all_sub_pages_col = array();
                        foreach($SubModule->pages as $keySubPage => $subPage)
                        {
                            if (isset($subPage) && Outil::hasOnePermissionOf($subPage->permissions))
                            {
                                array_push($sub_pages_col, $subPage);
                                array_push($all_sub_pages_col, $subPage);
                                $can_access_sub_module = true;
                            }
                        }
                        if ($can_access_sub_module)
                        {
                            $SubModule['pages_col'] = $sub_pages_col;
                            $SubModule['all_pages_col'] = $all_sub_pages_col;
                            array_push($modules_col, $SubModule);
                        }
                    }

                    if (isset($page) && Outil::hasOnePermissionOf($page->permissions))
                    {
                        array_push($pages_col, $page);
                        array_push($all_pages_col, $page);
                        $can_access = true;
                        // break;
                    }
                }
                if ($can_access)
                {
                    $module['pages_col'] = $pages_col;
                    $module['all_pages_col'] = $all_pages_col;
                    $module['modules_col'] = $modules_col;
                    //dd($module, $pages_col, $all_pages_col);
                    //if ($module->id==5)
                    //    dd($can_access, $page, Outil::hasOnePermissionOf($page->permissions));
                    array_push($modules_access, $module);
                }
            }

            //dd($modules_access, $this->modules);
            $this->modules = $modules_access;
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->getModules();
    
        $user = auth()->user();
    
        $hasMoodToday = $user->moods()
            ->whereDate('created_at', now()->toDateString())
            ->exists();
    
        $users = User::whereHas('moods', function ($query) {
            $query->whereDate('created_at', now()->toDateString());
        })
        ->with(['moods' => function ($query) {
            $query->whereDate('created_at', now()->toDateString())->latest();
        }])
        ->get();
    
        return view('home', [
            'modules' => $this->modules,
            'showMoodModal' => !$hasMoodToday,
            'users' => $users,
        ]);
    }
    



    public function namepage(Request $request, $namepage, $prefixepermission = '')
    {
        $retour = [];

        // Pour récupérer les attrs balancés
        foreach (array_keys($request->all()) as $key)
        {
            $retour[$key] = $request->all()[$key];
        }

        $this->getModules();

        $viewName = "pages.unauthorized";
        $getPage = Page::where('link', Outil::getOperateurLikeDB(), "%{$namepage}")->first();
        if (isset($getPage) && Outil::hasOnePermissionOf($getPage->permissions))
        {
            $viewName = 'pages.' . $namepage;
        }

        if (!view()->exists($viewName))
        {
            $viewName = "pages.unauthorized";
        }

        if (str_contains($namepage, "detail") || str_contains($namepage, "sections"))
        {
            $viewName = 'pages.' . $namepage;
        }

        $retour['prefixepermission']       = $prefixepermission;
        $retour['modules']                 = $this->modules;
        $retour['page']                    = $getPage;
        //dd($viewName, $getPage);

        return view($viewName, $retour);
    }

    public function redirectToController($table_name, $methode = 'save', $id = null, \Illuminate\Http\Request $request)
    {
        $models = Outil::getAllClassesOf(['Http', 'Controllers']);
        $getController = preg_grep( "/" . preg_quote("\\{$table_name}Controller", "/") . "/i" , $models );
        if (count($getController) > 0)
        {
            $getController = array_values($getController)[0];
            $getController = explode('\\', $getController)[4];
        }
        else
        {
            $getController = LinkRouteController::whereRaw("LOWER(TRIM(route_name)) = LOWER(TRIM(?))", [$table_name])->first()->controller_name . "Controller";
        }

        // dd("App\\Http\\Controllers\\{$getController}");

        return app()->make("App\\Http\\Controllers\\{$getController}")->callAction($methode, $parameters = array(isset($id) ? $id : $request));
    }

}

