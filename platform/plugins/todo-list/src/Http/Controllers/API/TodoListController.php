<?php
namespace Platform\TodoList\Http\Controllers\API;

use App\Handle\ResponseHandle;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Platform\TodoList\Services\TodoListService;

class TodoListController extends Controller
{
    protected $request;
    protected $response;
    protected $service;

    /**
     * TodoListController constructor.
     * @param $request
     * @param $response
     * @param $service
     */
    public function __construct(Request $request, ResponseHandle $response, TodoListService $service)
    {
        $this->request = $request;
        $this->response = $response;
        $this->service = $service;
    }

    public function index()
    {
        dd('index');
    }

    public function store()
    {
        dd('store');
    }

    public function edit($id)
    {
        dd('edit');
    }

    public function update($id)
    {
        dd('update');
    }

    public function destroy($id)
    {
        dd('destroy');
    }

}
