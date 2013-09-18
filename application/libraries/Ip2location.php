<?php
   if(!defined('BASEPATH')) exit('No direct script access allowed');

   class Ip2location
   {
	   var $errors = array();
	   var $service = 'api.ipinfodb.com';
	   var $version = 'v3';
	   var $apiKey = 'eb4cd8487cfd845e21ed472f769f4ca93198f0636143f93132de1bbe893a324f';
	   var $city_label = 'cityName';
	   var $country_label = 'countryCode';

	   function __construct()
	   {
	   }

	   //get error while send the ip2location request
	   function getError()
	   {
		   return implode("\n", $this->errors);
	   }

	   //get country-level location data
	   //input:host ip string
	   //output:
	   function get_country_level_data($host_ip)
	   {
		   return $this->get_location_data_by_api($host_ip, 'ip-country');
	   }

	   //get city-level location data
	   //input:host ip string
	   //output:
	   function get_city_level_data($host_ip)
	   {
		   return $this->get_location_data_by_api($host_ip, 'ip-city');
	   }

	   function get_location_data_by_api($host, $name)
	   {
			$ip = @gethostbyname($host);

			if(preg_match('/^(?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)(?:[.](?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)){3}$/', $ip))
			{
				$xml = @file_get_contents('http://' . $this->service . '/' . $this->version . '/' . $name . '/?key=' . $this->apiKey . '&ip=' . $ip . '&format=xml');
				try{
					$response = @new SimpleXMLElement($xml);
                    if($response == '')
                    {
                        return '';
                    }

					foreach($response as $field=>$value)
					{
					   $result[(string)$field] = (string)$value;
					}
					return $result;
				}
				catch(Exception $e)
				{
					$this->errors[] = $e->getMessage();
					return;
				}
			}//if
			$this->errors[] = '"' . $host . '" is not a valid IP address or hostname.';
			return;
	  }

	  //get city name from ip
	  function get_city_name_from_ip($host_ip)
	  {
	     $location_data = $this->get_city_level_data($host_ip);

		 if(isset($location_data[$this->city_label]))
		 {
		    return $location_data[$this->city_label];
		 }
		 return '';
	  }

   }// END Language_translate class

/* End of file Language_translate.php */
/* Location: ./system/application/libraries/IP2location.php */