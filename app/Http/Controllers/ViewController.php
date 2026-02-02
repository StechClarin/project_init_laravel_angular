<?php

namespace App\Http\Controllers;

use App\Models\{Outil, LinkRouteController, Commande, Module, Page};
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ViewController extends Controller
{

    /**
     * Le root path du view
     *
     * @var string
     */
    protected $viewPath = '';
    private $modules;


    public function __construct()
    {
        //$module = Module::find(16);
        //dd($module->permissions());
        $this->modules = Module::with(['modules', 'pages'])->whereNull('module_id')->orderBy('order')->get();
        $this->middleware('auth');
        Str::startsWith(request()->path(), 'admin') ? $this->viewPath = 'pages.back-office' : 'pages';
    }
    /**
     * Permet de rendre les views liée a un model
     *
     * @param Request $request
     * @param [type] $model
     * @param [type] $view
     * @return void
     */
    public function rendererModelView(Request $request, $model, $view)
    {
        $model = Str::kebab($model);
        return view("{$this->viewPath}.{$model}.{$view}", compact($model));
    }

    /**
     * Permet de rendre les autres vues
     *
     * @param Request $request
     * @param [type] $view
     * @return void
     */
    public function rendererView(Request $request, $view)
    {
        return view("{$this->viewPath}.{$view}");
    }

    public function index()
    {
        return view('home', ["modules" => $this->modules]);
    }

    public function namepage($namepage)
    {
        $viewName = 'pages.' . "unauthorized";
        $getPage = Page::where('link', Outil::getOperateurLikeDB(), "%{$namepage}%")->first();

        if (isset($getPage) && Outil::hasOnePermissionOf($getPage->permissions))
        {
            $viewName = 'pages.' . $namepage;
        }
        else if (strpos($namepage,"detail") !== false)
        {
            $viewName = 'pages.' . $namepage;
        }
        return view($viewName, ["modules" => $this->modules, "page" => $getPage]);
    }

    public function namepageOld($namepage)
    {
        $viewName = "unauthorized";
        $getPage = Page::where('link', Outil::getOperateurLikeDB(), "%{$namepage}%")->first();
        // if (Outil::hasOnePermissionOf($getPage->permissions))
        // {
            $viewName = 'pages.' . $namepage;
       // }
        return view($viewName, ["modules" => $this->modules, "page" => $getPage]);
    }



    /**
     * Permet de faire le routage au niveau du Wb
     *
     * @param table_name $table_name
     * @param methode $method
     * @param id $id
     * @param Request $request
     * @return void
     */

    public function redirectToController(Request $request, $table_name, $methode = 'save', $id = null)
    {
        $models = Outil::getAllClassesOf(['Http', 'Controllers']);
        $getController = preg_grep( "/" . preg_quote("\\$table_name", "/") . "/i" , $models );
        if (count($getController) > 0)
        {
            $getController = array_values($getController)[0];
            $getController = explode('\\', $getController)[4];
        }
        else
        {
            $getController = LinkRouteController::whereRaw("LOWER(TRIM(route_name)) = LOWER(TRIM(?))", [$table_name])->first()->controller_name . "Controller";
            // dd($getController);
        }
        return app()->make("App\\Http\\Controllers\\{$getController}")->callAction($methode, $parameters = array(isset($id) ? $id : $request));
    }
}
