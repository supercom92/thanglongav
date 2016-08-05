<?php

namespace Webapp\Frontend\Controllers;

use Webapp\Frontend\Utility\Helper;
use Webapp\Frontend\Models\CategoryView;
use Webapp\Frontend\Models\Category;
use Webapp\Frontend\Models\Contact;
use Webapp\Frontend\Models\Article;

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        $listcategory = CategoryView::find(array(
            "conditions"=>"poskey='menublockhome'",
            "order"=>"sorts asc"
        ));
        $htmlx ="";
        foreach($listcategory as $categoryview){
            $category = $categoryview->Category;
            $htmlx .= $this->swithCategoryView($category);
        }
        $this->view->htmlx = $htmlx;
        /** Header */
        $this->view->header = array(
            "title"=>"Thanglong Av",
            "desc"=>"Thanglong Av",
            "keyword"=>"Thanglong Av",
            "canonial"=>$this->config->application->baseUrl,
            "image"=>$this->config->media->host.'uploads/default-image/fb-thumb.jpg'
        );
    }
    private function swithCategoryView($category){
        if($category->type=="network"){
            $category->listarticle = Article::query()
                ->leftJoin('Webapp\Frontend\Models\AtCat', 'Webapp\Frontend\Models\AtCat.atid = Webapp\Frontend\Models\Article.id')
                ->where('Webapp\Frontend\Models\AtCat.catid = :catid: and  Webapp\Frontend\Models\Article.status = 1', array('catid' => $category->id))
                ->orderBy('Webapp\Frontend\Models\Article.datecreate DESC')
                ->limit(8,0)
                ->execute();
        }
        else if($category->type=="creator"){
            $category->listarticle = Article::query()
                ->leftJoin('Webapp\Frontend\Models\AtCat', 'Webapp\Frontend\Models\AtCat.atid = Webapp\Frontend\Models\Article.id')
                ->where('Webapp\Frontend\Models\AtCat.catid = :catid: and  Webapp\Frontend\Models\Article.status = 1', array('catid' => $category->id))
                ->orderBy('Webapp\Frontend\Models\Article.datecreate DESC')
                ->limit(3,0)
                ->execute();
        }
        else if($category->type=="news"){
            $category->listarticle = Article::query()
                ->leftJoin('Webapp\Frontend\Models\AtCat', 'Webapp\Frontend\Models\AtCat.atid = Webapp\Frontend\Models\Article.id')
                ->where('Webapp\Frontend\Models\AtCat.catid = :catid: and  Webapp\Frontend\Models\Article.status = 1', array('catid' => $category->id))
                ->orderBy('Webapp\Frontend\Models\Article.datecreate DESC')
                ->limit(4,0)
                ->execute();
        }
        else if($category->type=="learning"){
            $category->listarticle = Article::query()
                ->leftJoin('Webapp\Frontend\Models\AtCat', 'Webapp\Frontend\Models\AtCat.atid = Webapp\Frontend\Models\Article.id')
                ->where('Webapp\Frontend\Models\AtCat.catid = :catid: and  Webapp\Frontend\Models\Article.status = 1 and Webapp\Frontend\Models\Article.types = :types:', array('catid' => $category->id,"types"=>"tinbai"))
                ->orderBy('Webapp\Frontend\Models\Article.datecreate DESC')
                ->limit(2,0)
                ->execute();
            $category->listarticle2 = Article::query()
                ->leftJoin('Webapp\Frontend\Models\AtCat', 'Webapp\Frontend\Models\AtCat.atid = Webapp\Frontend\Models\Article.id')
                ->where('Webapp\Frontend\Models\AtCat.catid = :catid: and  Webapp\Frontend\Models\Article.status = 1 and Webapp\Frontend\Models\Article.types = :types:', array('catid' => $category->id,"types"=>"tinbai"))
                ->orderBy('Webapp\Frontend\Models\Article.datecreate DESC')
                ->limit(2,2)
                ->execute();
        }
        return $this->render_template("index/template",$category->type,$category);
    }

    public function contactAction(){
        if($this->request->isPost()){
            try {
                $datapost = Helper::post_to_array("name,phone,email,contents");
                $datapost['status'] = 1;
                $datapost['create_at'] = time();
                $contact = new Contact();
                $contact->map_object($datapost);
                $contact->save();
                $this->flash->success("Thông tin của bạn đã được gửi thành công");
            } catch (Exception $e) {
                print_r($e);die;
                $this->flash->success("Thông tin của bạn đã được gửi thành công");
            }
        }

        /** Header */
        $this->view->header = array(
            "title"=>"Liên hệ - Thăng Long AV",
            "desc"=>"Liên hệ - Thăng Long AV",
            "keyword"=>"Liên hệ - Thăng Long AV",
            "canonial"=>$this->config->application->baseUrl."index/contact",
            "image"=>$this->config->media->host.'uploads/default-image/fb-thumb.jpg'
        );
    }
}

