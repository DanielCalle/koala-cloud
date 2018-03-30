<?php

class SalirController
{
	public function indexAction()
	{
		session_start();
		session_destroy();
		header("Location: ./");
	}
}