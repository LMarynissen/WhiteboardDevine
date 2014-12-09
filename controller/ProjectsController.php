<?php

require_once WWW_ROOT . 'controller' . DS . 'Controller.php';
require_once WWW_ROOT . 'dao' . DS . 'ProjectDAO.php';
require_once WWW_ROOT . 'dao' . DS . 'UserDAO.php';
require_once WWW_ROOT . 'php-image-resize' . DS . 'ImageResize.php';

class ProjectsController extends Controller {

	private $projectDAO;
	private $userDAO;

	function __construct() {
		$this->projectDAO = new ProjectDAO();
		$this->userDAO = new UserDAO();
	}

	public function index() {
		if(!empty($_SESSION["user"])){
			$this->set("projects",$this->projectDAO->selectByUser($_SESSION["user"]["id"]));
		}
	}

	public function view(){

		$project = false;
		$items = false;
		$invited = false;
		$access = false;

		if(!empty($_GET["id"])){
			$project = $this->projectDAO->selectById($_GET["id"]);
			$items = $this->projectDAO->selectItemsByProjectId($_GET["id"]);
			
			$invited = $this->projectDAO->selectInvitedByProjectId($_GET["id"]);

			if(!empty($_SESSION["user"])){
				//If person is on the invited list for this whiteboard
				foreach ($invited as $invite) {
					if($_SESSION["user"]["id"] == $invite['user_id']){
						$access = true;
					}
				}

				//If person is creator of whiteboard
				if($_SESSION["user"]["id"] == $project['user_id']){
					$access = true;
				}

				if(!$access){
					$_SESSION["info"] = "You do not have access to this whiteboard";
					$this->redirect("index.php");
				}

			}else{
				$_SESSION["info"] = "You need to be logged in to view whiteboards";
				$this->redirect("index.php");
			}
			
			if(empty($project)){
				$this->redirect("index.php");
			}
			$this->set("project",$project);
			$this->set("items",$items);
			$this->set("access",$access);
		} else {
			$this->redirect("index.php");
		}
		if(empty($project)){
			$this->redirect("index.php");
		}
		//$this->set("project",$project);
	}

	public function add(){
		$errors = array();

		if(!empty($_POST)){

			$title = $_POST["title"];
			$description = $_POST["description"];

			if(empty($errors)){
					$this->projectDAO->insert(array(
						"user_id"=>$_SESSION["user"]["id"],
						"title"=>$title,
						"description"=>$description
					));
					$_SESSION["info"] = "Project created successfully";
					$this->redirect("index.php?page=detail&id=");
			}
		}	

		if(!empty($errors)){
			$_SESSION["error"] = "the project could not be created";
		}
		$this->set('errors', $errors);
	}

	public function addItem(){
		$errors = array();
		$size = array();

		if(!empty($_FILES["image"])){
			if(!empty($_FILES["image"]["error"])){
				$errors["image"] = "the image could not be uploaded";
			}

			if(empty($errors["image"])){
				$size = getimagesize($_FILES["image"]["tmp_name"]);
				if(empty($size)){
					$errors["image"] = "please insert an image";
				}
			}
			if(empty($errors["image"])){
				if($size[0] < 200 || $size[1] < 200){
					$errors["image"] = "image should be at least 400x400";
				}
			}
			if(empty($errors["image"])){
				$project_id = $_GET["id"];
				$title = $_POST["title"];
				$description = $_POST["description"];
				$Color = $_POST["color"];
				$contentlink = preg_replace("/\\.[^.\\s]{3,4}$/", "", $_FILES["image"]["name"]);
				$extension = explode($contentlink.".", $_FILES["image"]["name"])[1];
				$this->projectDAO->insertItem(array(
					"user_id"=>$_SESSION["user"]["id"],
					"contentlink"=>$contentlink,
					"extension"=>$extension,
					"posX"=>100,
					"posY"=>100,
					"title"=>$title,
					"description"=>$description,
					"project_id"=>$_GET["id"],
					"datum"=>date("Y-m-d h:i:s"),
					"Color"=>$Color
				));
				$imageresize = new EventViva\ImageResize($_FILES["image"]["tmp_name"]);
				$imageresize->resizeToHeight(600);
				//$imageresize->crop(600,600);
				$imageresize->save(WWW_ROOT."uploads".DS.$contentlink.".".$extension);
				$imageresize->resizeToHeight(120);
				$imageresize->crop(180,120);
				$imageresize->save(WWW_ROOT."uploads".DS.$contentlink."_th.".$extension);
				$this->redirect("index.php?page=detail&id=".$_GET["id"]);
				$_SESSION["info"] = "The sticky note was uploaded";
			}

		}
		if(!empty($errors)){
			$_SESSION["error"] = "the sticky note could not be uploaded";

		}

		$this->set('errors', $errors);
	}

	public function delete(){
		$errors = array();

		if(empty($errors)){
				$this->projectDAO->delete($_GET["id"]);
				$_SESSION["info"] = "Project deleted successfully";
				$this->redirect("index.php");
		}

		if(!empty($errors)){
			$_SESSION["error"] = "the project could not be deleted";
		}
		$this->set('errors', $errors);
	}

	public function deleteItem(){
		$errors = array();

		if(empty($errors)){
				$this->projectDAO->deleteItem($_POST["id"]);
				$_SESSION["info"] = "Item deleted successfully";
				$this->redirect("index.php");
		}

		if(!empty($errors)){
			$_SESSION["error"] = "the Item could not be deleted";
		}
		$this->set('errors', $errors);
	}

	public function moveItem(){
		$errors = array();

		if(!empty($_POST)){

			$id = $_POST["id"];
			$x = $_POST["x"];
			$y = $_POST["y"];

			if(empty($errors)){
					$this->projectDAO->moveUpdate(array(
						"id"=>$id,
						"posX"=>$x,
						"posY"=>$y
					));
					//$_SESSION["info"] = "Project created successfully";
					//$this->redirect("index.php?page=detail&id=");
			}
		}	

		if(!empty($errors)){
			$_SESSION["error"] = "the sticky note could not be moved";
		}
		$this->set('errors', $errors);
	}
}