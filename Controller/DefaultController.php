<?php

namespace tomsyrovy\ContentEditableBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use tomsyrovy\ContentEditableBundle\Entity\ContentEditable;
use tomsyrovy\Controller\DefaultControllerInterface;

class DefaultController extends Controller
{

    public function saveAction(Request $request)
    {

        $uid = $request->query->get('uid');

        $em = $this->getDoctrine()->getManager();

        $contentEditable = $em->getRepository(ContentEditable::class)->find($uid);

        if(!$contentEditable){
            $contentEditable = new ContentEditable();
            $contentEditable->setUid($uid);
        }

        $content = $request->query->get('content');

        $contentEditable->setContent($content);

        $em->persist($contentEditable);
        $em->flush();

        //prepare the response
        $response = array("status" => 200, "success" => true);

        //you can return result as JSON
        return new JsonResponse($response, 200);
    }
}
