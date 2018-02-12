<?php

class Attachments extends Contenido {

	public function getAttachment(){

		$emails = imap_search($this->inbox,'ALL');
		$attachs = array();

		rsort($emails);

		for ($i=0; $i < count($emails); $i++) { 

			$structure = imap_fetchstructure ( $this->inbox, $emails[$i] );

			$attachments = array ();

			if (isset ( $structure->parts ) && count ( $structure->parts )) {
				for ($j=0; $j < count ( $structure->parts ); $j++) { 
					$attachments [$j] = array (
	                            'is_attachment' => false,
	                            'filename' => '',
	                            'name' => '',
	                            'attachment' => '' 
	                );

	                if ($structure->parts[$j]->ifdparameters) {
	                    foreach ( $structure->parts[$j]->dparameters as $object ) {
	                        if (strtolower ( $object->attribute ) == 'filename') {
	                        	if (strstr($object->value, "csv")) {
	                        		
		                            $attachments[$j]['is_attachment'] = true;
		                            $attachments[$j]['filename'] = $object->value;
	                        	}
	                        }
	                    }
	                }
	                if ($structure->parts[$j]->ifparameters) {
	                    foreach ( $structure->parts[$j]->parameters as $object ) {
	                        if (strtolower ( $object->attribute ) == 'name') {
	                        	if (strstr($object->value, "csv")) {
	                        		
		                            $attachments[$j]['is_attachment'] = true;
		                            $attachments[$j]['name'] = $object->value;
	                        	}
	                        }
	                    }
	                }
	                if ($attachments[$j]['is_attachment']) {
		                    $attachments[$j]['attachment'] = imap_fetchbody ( $this->inbox, $emails[$i], $j + 1 );
		                    if ($structure->parts[$j]->encoding == 3) { // 3 = BASE64
		                        $attachments[$j]['attachment'] = base64_decode ( $attachments[$j]['attachment'] );
		                    } elseif ($structure->parts[$j]->encoding == 4) { // 4 = QUOTED-PRINTABLE
		                        $attachments[$j]['attachment'] = quoted_printable_decode ( $attachments [$j] ['attachment'] );
		                    }
	                }
				}
				

				array_push($attachs, $attachments);
			}
			
		}

		return $attachs;
	}
}

?>