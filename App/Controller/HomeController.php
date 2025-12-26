<?php

declare(strict_types=1);

namespace App\Controller;

use Magma\Base\BaseController;
/*
use App\Model\UserModel;
use Magma\Yaml\YamlConfig;
use App\DataColumns\UserColumns;
use Magma\Datatable\Datatable;
use Magma\Http\RequestHandler;
*/

class HomeController extends BaseController
{

    public function __construct($routeParams)
    {
        parent::__construct($routeParams);

    }

    public function indexAction()
    {
        echo 'Home TheCodingWorkshop <br />';
/*
        $args = YamlConfig::file('controller')['user'];
        $user = new UserModel();
        $repository = $user->getRepo()->findWithSearchAndPaging((new RequestHandler())->handler(), $args);

        $tableData = (new Datatable())->create(UserColumns::class, $repository, $args)->setAttr(['table_id' => 'sexytable', 'table_class' => ['youtube-datatable']])->table();

        $this->render('client/home/index.html.twig', [
            'table' => $tableData,
            'pagination' => (new Datatable())->create(UserColumns::class, $repository, $args)->pagination()
        ]);
  */
    }

    protected function before()
    {
        echo 'This is the before action hook <br />';
    }

    protected function after()
    {
        echo 'This is the after action hook <br />';
    }


}
