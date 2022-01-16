<?php
namespace Juice\Controllers;

use Symfony\Component\HttpFoundation\Request;

class MyController extends BaseController
{
    public function home()
    {
        $this->display('home.twig');
    }

    public function dev(Request $request)
    {
        $this->display('dev.twig', ['name' => $request->get('name')]);
    }


}