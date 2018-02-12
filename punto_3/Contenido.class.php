<?php


Class Contenido {

	protected $inbox;
	private $host = "{imap.gmail.com:993/imap/ssl}INBOX";
	private $user = "ingkjop@gmail.com";
	private $password = "testing1234";

	public function __construct(){

		$this->inbox = imap_open($this->host,$this->user,$this->password) or die('Ha fallado la conexión: ' . imap_last_error());
	}

	public function parseAttachment($attachments){

		foreach ($attachments as $containt) {
			foreach ($containt as $att) {
				if ($att['is_attachment']) {
					
					echo "<br>" . str_replace("\n", "<br>", $att["attachment"]) . "<br>";

					$content = explode("\n", $att["attachment"]);
					$table = '<table style="border: 1px solid black; width: 50%">';

					foreach ($content as $campos) {

						$valor = explode(",", $campos);

						$table .= '<tr>';

						foreach ($valor as $val) {
							if ($val != "") {
								
								$table .= '<td style="border: 1px solid black;">'.$val.'</td>';
							}
						}

						$table .= '</tr>';

					}

					$table .= '</table>';

					echo $table;
					
				}
			}
		}
	}

	public function destroyImap(){
		imap_close($this->inbox);
	}

}

?>