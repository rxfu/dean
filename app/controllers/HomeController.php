<?php

class HomeController extends Controller {

	public function index() {
		$welcome = 'Hello, Student!';

		$this->view->render('index', array('welcome' => $welcome));
	}
}