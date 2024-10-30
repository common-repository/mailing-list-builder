<?php

class grapi
{		
	function addSubscriber($campaign, $email, $name, $ref, $ip, $customs)
	{
		$api_key = get_option('mlb_api_key');
	    // build GET request string
	    $request = 'http://www.getresponse.com/subscriber_api.html'
	        . '?method=AddSubscriber'
	        . '&api_key=' . urlencode($api_key)
	        . '&email=' . urlencode($email)
	        . '&campaign=' . urlencode($campaign)
	        . '&ref=' . urlencode($ref)
	        . '&name=' . urlencode($name)
	        . '&ip=' . urlencode($ip);
	
	    foreach ($customs as $key => $custom)
	    {
	    	$request .= '&customs[' . $key . '][name]=' . urlencode($custom['name'])
	            . '&customs[' . $key . '][value]=' . urlencode($custom['value']);
	    }
	    
	   	// result is in XML
	    $doc = new DOMDocument();
	    $doc->loadXML(self::connect($request));
	
	    $elements = $doc->getElementsByTagName('Status');
	    $result = $elements->item(0)->nodeValue;
	
	    if ($result == 'ok')
	    {
	    	echo '1';
	    }
	    else
	    {
	    	echo $elements->item(0)->getAttribute('description');
	    }
	}
	
	function getCampaignList()
	{
		$api_key = get_option('mlb_api_key');
		
	    // build GET request string
	    $request = 'http://www.getresponse.com/subscriber_api.html'
	        . '?method=GetCampaignList'
	        . '&api_key=' . urlencode($api_key);
	
	   	// result is in XML
	    $doc = new DOMDocument();
	    $doc->loadXML(self::connect($request));
	
	    $elements = $doc->getElementsByTagName('Status');
	    $result = $elements->item(0)->nodeValue;
	    
	    if ('ok' == $result)
	    {	
	        $xpath = new DOMXPath($doc);
	        $rows = $xpath->query("Data/Item");
	
	        foreach ($rows as $row)
	        {
	            $campaigns[] = $row->childNodes->item(1)->nodeValue;
	        }
	        
	        return $campaigns;
	    }
	    else
	    {
	    	return false;
//	        echo "Error: " . $elements->item(0)->getAttribute('error_code') . ' - ' . $elements->item(0)->getAttribute('description') . "\n";
	    }
	}
	
	function printCampaignList()
	{
		$campaigns = self::getCampaignList();

?>
<ul style="list-style-type: disc;">
<?php
		if (is_array($campaigns))
		{
			foreach($campaigns as $campaign) 
			{ 
?>
	<li><strong><?php echo $campaign; ?></strong></li>
<?php 
			}
		}	
?>
</ul>
<?php 
	}
	
	function validate_key($api_key)
	{
	    // build GET request string
	    $request = 'http://www.getresponse.com/subscriber_api.html'
	        . '?method=GetCampaignList'
	        . '&api_key=' . urlencode($api_key);
	
	   	// result is in XML
	    $doc = new DOMDocument();
	    $doc->loadXML(self::connect($request));
	
	    $elements = $doc->getElementsByTagName('Status');
	    $result = $elements->item(0)->nodeValue;
	    
	    if ('ok' == $result)
			return true;
	    else
			return false;
	}
	
	function connect($request)
	{
		$curl = curl_init();
	    curl_setopt($curl, CURLOPT_URL, $request);
	    curl_setopt($curl, CURLOPT_HTTPGET, 1);
	    curl_setopt($curl, CURLOPT_HEADER, 0);
	    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	    $output = curl_exec($curl);
	    curl_close($curl);
	    
	    return $output;
	}
}