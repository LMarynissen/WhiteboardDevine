<?php
require_once WWW_ROOT . 'dao' . DS . 'DAO.php';

class UserDAO extends DAO {

	public function selectAll() {
		$sql = "SELECT * FROM `users`";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function selectById($id) {
		$sql = "SELECT * FROM `users` WHERE `id` = :id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(':id', $id);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	public function insert($data) {
		$errors = $this->getValidationErrors($data);
		if(empty($errors)) {
			$sql = "INSERT INTO `users` (`email`, `password`, `role`) VALUES (:email, :password, :role)";
	        $stmt = $this->pdo->prepare($sql);
	        $stmt->bindValue(':email', $data['email']);
	        $stmt->bindValue(':password', $data['password']);
	        $stmt->bindValue(':role', $data['role']);
			if($stmt->execute()) {
				$insertedId = $this->pdo->lastInsertId();
				return $this->selectById($insertedId);
			}
		}
		return false;
	}

	public function getValidationErrors($data) {
		$errors = array();
		if(empty($data['email'])) {
			$errors['email'] = "Please fill in the email";
		}
		if(empty($data['password'])) {
	        $errors['password'] = 'please enter a password';
	    }
	    if(!isset($data['role'])) {
	        $errors['role'] = 'please enter a role';
	    }
		return $errors;
	}

	public function selectByEmail($email){
		$sql = "SELECT *
				FROM `users`
				WHERE `email` = :email";
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue("email", $email);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	public function invitePerson($data) {
		//$errors = $this->getValidationErrors($data);
		if(empty($errors)) {
			$sql = "INSERT INTO `invites` (`project_id`, `user_id`) VALUES (:project_id, :user_id)";
	        $stmt = $this->pdo->prepare($sql);
	        $stmt->bindValue(':project_id', $data['project_id']);
	        $stmt->bindValue(':user_id', $data['user_id']);
			if($stmt->execute()) {
				$insertedId = $this->pdo->lastInsertId();
				return $this->selectById($insertedId);
			}
		}
		return false;
	}
}