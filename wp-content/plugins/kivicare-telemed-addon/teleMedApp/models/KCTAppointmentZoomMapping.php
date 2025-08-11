<?php


namespace TeleMedApp\models;

use App\baseClasses\KCModel;

class KCTAppointmentZoomMapping extends KCModel {

	public function __construct()
	{
		parent::__construct('appointment_zoom_mappings');
	}

}