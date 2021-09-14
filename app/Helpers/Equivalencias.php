<?php
namespace App\Helpers;

class Equivalencias
{

	private static $urlProduccion = 'https://app.cne.gov.co/usuarios/public/';

	public static function urlProduccion()
	{
		return self::$urlProduccion;
	}

}
