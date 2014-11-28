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

		if(!empty($_GET["id"])){
			$project = $this->projectDAO->selectById($_GET["id"]);
			$items = $this->projectDAO->selectItemsByProjectId($_GET["id"]);
			
			if(empty($project)){
				$this->redirect("index.php");
			}
			$this->set("project",$project);
			$this->set("items",$items);
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
}