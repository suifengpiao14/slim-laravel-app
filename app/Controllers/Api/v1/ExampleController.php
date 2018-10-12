<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\8\4 0004
 * Time: 15:51.
 */

namespace App\Controllers\Api\v1;

use App\Controllers\Controller;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class ExampleController.
 */
class ExampleController extends Controller
{
    /**
     * 打招呼
     *
     * @SWG\Get(
     *     path="/api/v1/example/hello",
     *     tags={"api"},
     *     summary="打招呼",
     *     produces={"application/json"},
     *     consumes={"application/x-www-form-urlencoded"},
     *     @SWG\Parameter(
     *          name="name",
     *          type="string",
     *          in="query",
     *          description="名称",
     *          default="world",
     *     ),
     *     @SWG\Response(response=400,description="bad request",ref="#/responses/BadRequest"),
     *     @SWG\Response(response=404,description="bad request",ref="#/responses/NotFound"),
     *     @SWG\Response(response="200", description="ok",),
     *),
     **/
    public function hello(Request $request, Response $response)
    {
        $name = $request->getParam('name');
        $data['greet'] = "hello $name!";

        return $this->view->render($request, $response, $data);
    }
}
