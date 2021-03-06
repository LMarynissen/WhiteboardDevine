<?php
require_once WWW_ROOT . 'controller' . DS . 'Controller.php';
require_once WWW_ROOT . 'dao' . DS . 'UserDAO.php';
require_once WWW_ROOT . 'dao' . DS . 'ProjectDAO.php';
require_once WWW_ROOT . 'phpass' . DS . 'Phpass.php';

class UsersController extends Controller {

	private $userDAO;
	private $projectDAO;

	function __construct() {
		$this->userDAO = new UserDAO();
		$this->projectDAO = new ProjectDAO();
	}

	public function index() {
		$this->set("users",$this->userDAO->selectAll());
	}

	public function register() {
		if (!empty($_POST)) {
			$errors = array();
			if(empty($_POST['email'])) {
				$errors['email'] = 'Please enter your email';
			} else {
				$existing = $this->userDAO->selectByEmail($_POST['email']);
				if(!empty($existing)) {
					$errors['email'] = 'Email address is already in use';
				}
			}
			if(empty($_POST['password'])) {
				$errors['password'] = 'Please enter a password';
			}
			if($_POST['confirm_password'] != $_POST['password']) {
				$errors['confirm_password'] = 'Passwords do not match';
			}
			if(empty($errors)) {
				$hasher = new \Phpass\Hash;
				$inserteduser = $this->userDAO->insert(array(
					'email' => $_POST['email'],
					'password' => $hasher->hashPassword($_POST['password']),
					'role' => 0
				));
				if(!empty($inserteduser)) {
					$_SESSION['info'] = 'Registration Successful!';
					$_SESSION['user'] = $inserteduser;
					$this->redirect('index.php');
				}
			}
			$_SESSION['error'] = 'Registration Failed!';
			$this->set('errors', $errors);
		}
	}

	public function login(){
		if (!empty($_POST)) {
			$errors = array();
			if(empty($_POST['email'])) {
				$errors['email'] = 'Please enter your email';
			}
			if(empty($_POST['password'])) {
				$errors['password'] = 'Please enter your password';
			}
			if(empty($errors)) {
				$existing = $this->userDAO->selectByEmail($_POST['email']);
				if(!empty($existing)) {
					$hasher = new \Phpass\Hash;
					if ($hasher->checkPassword($_POST['password'], $existing['password'])) {
						$_SESSION['info'] = 'Login successful';
						$_SESSION['user'] = $existing;
						$this->redirect('index.php');
					} else {
						$_SESSION['error'] = 'Unknown username / password';
					}
				} else {
					$_SESSION['error'] = 'Unknown username / password';
				}
			} else {
				$_SESSION['error'] = 'Unknown username / password';
			}
			$this->set('errors', $errors);
		}
	}

	public function logout(){
		unset($_SESSION['user']);
		$_SESSION['info'] = 'Logged Out';
		$this->redirect('index.php');
	}

	public function invitePerson(){
		$errors = array();
		if(!empty($_POST)){

			$user = $this->userDAO->selectByEmail($_POST["email"]);
			$project_id = $_GET["id"];
			$alreadyInvited = $this->projectDAO->selectInvitedByProjectAndUserId($project_id, $user['id']);

			if(empty($user)){
				$errors['user'] = 'Vul aub een geldig email-adres in';
			}

			if(empty($project_id)){
				$errors['project_id'] = 'OH GOD, SOMETHING WENT WRONG! SAVE YOURSELF!';
			}

			//check if user is already invited
			if(!empty($alreadyInvited)){
				$errors['user'] = 'Deze persoon is alreeds ge-invite';
			}

			if(empty($errors)){
				$this->userDAO->invitePerson(array(
					"project_id"=>$project_id,
					"user_id"=>$user['id']
				));
				$_SESSION["info"] = "Invite successvol";
				$this->redirect("index.php?page=detail&id=".$_GET['id']);
			}
		}	

		if(!empty($errors)){

			$_SESSION["error"] = "De persoon kon niet toegevoegd worden";
			$this->redirect("index.php?page=detail&id=".$_GET['id']);


		}
		$this->set('errors', $errors);
	}

	public function deleteUser(){
		$errors = array();

		if(empty($errors)){
			$this->userDAO->deleteUser($_GET["user_id"], $_GET["project_id"]);
			$_SESSION["info"] = "Person deleted successfully. You monster.";
			$this->redirect("index.php?page=detail&id=".$_GET['project_id']);

		}

		if(!empty($errors)){
			$_SESSION["error"] = "the Person could not be deleted";
		}
		$this->set('errors', $errors);
	}


}