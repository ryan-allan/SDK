<?php

	class Skycore	{

		public function Skycore($key)	{

			$this->api_key = $key;

		}

		//Function for the subscribe call
		//-------------------------------
		public function subscribe($number, $campid)	{

			//XML Query Information
			//---------------------
			$POSTArray['XML']=
			"<REQUEST>
			<ACTION>subscribe</ACTION>
			<API_KEY>".$this->api_key."</API_KEY>
			<CAMPAIGNID>".$campid."</CAMPAIGNID>
			<MOBILE>".$number."</MOBILE>
			</REQUEST>";

			//Make the HTTPS request
			//----------------------
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, 'https://scale-secure.skycore.com/API/wxml/1.3/index.php?');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $POSTArray);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			$result = curl_exec($ch);

		}

	}

?>
